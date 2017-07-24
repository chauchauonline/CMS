<?php namespace Modules\Cms\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Cms\Http\Requests\CompanyRequest;
use Modules\Cms\Entities\Company;
use Modules\Cms\Entities\Image;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Modules\Cms\Http\Requests\UpdateCompanyRequest;
class CompanyController extends Controller {
    public function index(Request $request)
    {
        $limit = Config::get('constants.RECORD_PER_PAGE');
        $keyword = $request->get('keyword','');
        if ($keyword) {
            $company = Company::where('name','LIKE',"%$keyword%")->orderBy('updated_at','DESC')->paginate($limit);
        }else {
            $company = Company::orderBy('updated_at','DESC')->paginate($limit);
        }

        return view('cms::companies.index',compact('company','keyword'));
    }

    public function create()
    {
        return view('cms::companies.create');
    }

    public function store(CompanyRequest $request)
    {
        $company = $request->all();
        $photo = $request->file('image');
        $image = $this->upload($photo);
        $company['image'] = $image->id;
        Company::create($company);
        return redirect()->route('companies.index');
    }
    public function edit($id)
    {
        $company = Company::find($id);
        return view('cms::companies.edit', compact('company'));
    }
    public function update($id,UpdateCompanyRequest $request)
    {
        $company = Company::find($id);
        $data = $request->all();
        $photo = $request->file('image');
        if (!empty($photo)){
                    $image = Image::find($company->image);
                    if ($image) {
                        $image = $this->updateImage($image, $photo);
                        $data['image'] = $image->id;;
                    }else{
                        $image = $this->upload($photo);
                        $data['image'] = $image->id;
                    }

                }

        $company->update($data);
        return redirect()->route('companies.index');
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $company = Company::find($id);
        $company->delete();
        return redirect()->route('companies.index');
    }
    public function show($id)
    {
        $company = Company::find($id);
        return view('cms::companies.show',compact('company'));
    }
    protected function upload($photo){
        $image = new Image();
        $image->file_type = $photo->getClientMimeType();
        $image->file_size = $photo->getClientSize();
        if($image->save()){
            $image_id = $image->id;
            // Lưu image vào folder upload
            $name = $photo->getClientOriginalName(); // getting image name
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $extractFileName = explode('.'.$extension, $name)[0];
            $fileName = $extractFileName."-".$image_id;
            $newFileName = str_slug($fileName).".".$extension;
            $image->thumbs = '/uploads/partners/'.$newFileName ;
            $photo->move('uploads/partners/', $newFileName);
            $image->name = $newFileName;
            $image->save();
        }

        return $image;
    }
    protected function updateImage($image, $photo){
        $image->file_type = $photo->getClientMimeType();
        $image->file_size = $photo->getClientSize();
        $name = $photo->getClientOriginalName(); // getting image name
        $extension = $photo->getClientOriginalExtension(); // getting image extension
        $extractFileName = explode('.'.$extension, $name)[0];
        $fileName = $extractFileName."-".$image->id;
        $newFileName = str_slug($fileName).".".$extension;
        $image->thumbs = '/uploads/partners/' . $newFileName;
        $image->name = $newFileName;
        $photo->move('uploads/partners/', $newFileName);
        $image->save();

        return $image;
    }
}
