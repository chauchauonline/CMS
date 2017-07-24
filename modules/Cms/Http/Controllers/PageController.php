<?php
namespace Modules\Cms\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Cms\Entities\Page;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Validator;
use Redirect;
use Modules\Cms\Entities\Image;

class PageController extends Controller
{
    public function index()
    {
        $record = Config::get('constants.RECORD_PER_PAGE');
        $pages = Page::paginate($record);
        $page_status = Config::get('constants.PAGE_STATUS');
        $enum_compiler = Config::get('constants.ENUM_COMPILER');
        return View::make('cms::pages.index', compact('pages', 'page_status', 'enum_compiler'));
    }

    public function create()
    {
        $page_status = Config::get('constants.PAGE_STATUS');
        $enum_compiler = Config::get('constants.ENUM_COMPILER');
        return view('cms::pages.create', compact('page_status', 'enum_compiler'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
                'slug'      => 'required|max:50|unique:pages',
                'name'      => 'required|max:50',
                'title'     => 'required',
                'content'   => 'required',
                'image'     => 'required',
                'abstract'  => 'required',
                'order'     => 'numeric',
        ]);

        // Kiểm tra thư mục upload của pages
        $pages_folder = "uploads/pages";
        if(!is_dir($pages_folder)){
            mkdir($pages_folder, 0777);
        }
        // Kiểm tra folder upload đã tồn tại hay chưa
        $upload_folder = $request->get('upload_folder');
        if(!is_dir($upload_folder)) {
            mkdir($upload_folder, 0777);
        }
        // Kiểm tra định dạng ảnh
        $photo = $request->file('image');
        if($photo == null){
            $image_id = null;
        }else {
            $file = ['photo' => $photo];
            $rules = [
                    'photo' => 'mimes:jpeg,bmp,png,tiff,gif|max:10000',
            ];
            $validator = Validator::make($file, $rules);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            }
            else {
                // checking file is valid.
                if ($photo->isValid()) {
                     // Tạo đối tượng Image mới của trang và lưu vào upload_folder
                    $image = $this->upload_photo($upload_folder, $photo);
                    $image_id = $image->id;
                } else {
                   return Redirect::back()->withInput()->withErrors(Lang::get('cms::message.upload_photo_invalid'));
                }
            }
        }
        // Tạo mới trang
        $data = $request->all();
        $page = Page::create($data);
        $page->image_id = $image_id;
        $page->upload_folder = $upload_folder;
        if($page->save()){
            return redirect('pages')->withSuccess(Lang::get('cms::message.create_page_success'));
        } else {
            return redirect('pages')->withSuccess(Lang::get('cms::message.create_page_fail'));
        }
    }

    public function show($id)
    {
        $page = Page::find($id);
        $page_status = Config::get('constants.PAGE_STATUS');
        $enum_compiler = Config::get('constants.ENUM_COMPILER');
        return View::make('cms::pages.show', compact('page', 'page_status', 'enum_compiler'));
    }

    public function edit($id)
    {
        $page = Page::find($id);
        $page_status = Config::get('constants.PAGE_STATUS');
        $enum_compiler = Config::get('constants.ENUM_COMPILER');
        return View::make('cms::pages.edit', compact('page', 'page_status', 'enum_compiler'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
                'slug'      => 'required|max:50|unique:pages,slug,'.$id,
                'name'      => 'required|max:50',
                'title'     => 'required',
                'content'   => 'required',
                'abstract'  => 'required',
                'order'     => 'numeric'
        ]);

        $data = $request->all();
        $page = Page::find($id);
        $page->update($data);
        return redirect('pages')->withSuccess(Lang::get('cms::message.update_page_success'));
    }

    /**
     * Xóa trang
     *
     * @param  int  $id
     * @return Response
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        if ($page = Page::find($id))
        {
            $page->delete();  // Xóa trang
        }
        return redirect('pages')->withSuccess(Lang::get('cms::message.delete_page_success'));
    }

    public function change_image($id) {
        $page = Page::find($id);
        if($page) {
            return view::make('cms::pages.change_image', compact('page'));
        } else {
            return Redirect::back()->withErrors("Trang không tồn tại");
        }
    }
    public function upload(Request $request)
    {
        $page_id = $request->get('page_id');
        $page = Page::find($page_id);
        $old_image_id  = $page->image_id;
        $upload_folder =  $page->upload_folder;

        // Kiểm tra định dạng ảnh mới cập nhật
        $photo = $request->file('image');
        if($photo == null){
            return Redirect::back()->withInput()->withErrors(Lang::get('cms::message.upload_photo_empty'));
        }else {
            $file = ['photo' => $photo];
            $rules = [
                    'photo' => 'mimes:jpeg,bmp,png,tiff,gif|max:10000',
            ];
            $validator = Validator::make($file, $rules);
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
            } else {
                // Nếu hơp lệ, Xóa ảnh cũ trong db
                $image = Image::find($old_image_id);
                if($image){
                    $image->delete();
                }
                // Tạo đối tượng Image mới của trang và lưu vào upload_folder
                $image = $this->upload_photo($upload_folder, $photo);
                // Lưu ảnh mới của trang
                $page->image_id = $image->id;
                $page->save();
                return Redirect::back()->withSuccess(Lang::get('cms::message.upload_photo_success'));
            }
        }
    }

    /**
     * Upload and create image
     * @param Request file $photo
     * @return \Modules\Cms\Entities\Image
     */
    protected function upload_photo($upload_folder, $photo){
        $image = new Image();
        $image->file_type = $photo->getClientMimeType();
        $image->file_size = $photo->getClientSize();
        if($image->save()){
            $image_id = $image->id;

            // Lưu image vào folder upload
            $destinationPath = $upload_folder;
            $name = $photo->getClientOriginalName(); // getting image name
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $extractFileName = explode('.'.$extension, $name)[0];
            $fileName = $extractFileName."-".$image_id;
            $newFileName = str_slug($fileName).".".$extension;
            $photo->move($destinationPath, $newFileName); // uploading file to upload_folder

            $image->name = $newFileName;
            $image->thumbs = '/'.$destinationPath.'/'.$newFileName ;
            $image->save();
        return $image;
        }
    }
}