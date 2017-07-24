<?php namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Modules\Cms\Entities\Article;
use Modules\Cms\Entities\Image;
use Modules\Cms\Entities\User;
use Modules\Cms\Http\Requests\ArticleRequest;
use Pingpong\Modules\Routing\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use DB;
use Helpers;
use Modules\Cms\Entities\Category;
use Modules\Cms\Http\Requests\UpdateArticleRequest;
use Redirect;
use Illuminate\Support\Facades\Lang;
use Validator;
use Illuminate\Mail\Message;

class ArticleController extends Controller {

    /**
     *  List Articles
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request)
    {
        $limit = Config::get('constants.RECORD_PER_PAGE');
        $keyword = $request->get('keyword','');
        if ($keyword) {
            $article = Article::where('title','LIKE',"%$keyword%")->orderBy('updated_at','DESC')->paginate($limit);
        }else {
            $article = Article::orderBy('updated_at','DESC')->paginate($limit);
        }
        $status = Config::get('constants.article_status');

        return view('cms::articles.index',compact('article','keyword','status'));
    }

    /**
     * Show form create
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $cate = Category::lists('name','id')->all();
        $user = Sentinel::getUser();
        return view('cms::articles.create',compact('user','cate'));
    }

    /**
     *  Create new Article
     * @param ArticleRequest $request
     */
    public function store(Request $request)
    {
        Try{
            $user = Sentinel::getUser();
            $article = $request->all();

            // create file image
            $photo = $request->file('image');
            dd(photo);
            if($photo == null){
                return Redirect::back()->withInput()->withErrors(Lang::get('cms::message.upload_photo_empty'));
            } else {
                $file = ['image' => $photo];
                $rules = [
                    'image' =>'image|max:2048',
                ];
                $validator = Validator::make($file, $rules);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                } else {
                    $image = $this->upload($photo);
                    $article['image_id'] = $image->id;
                }
            }

            // create file image facebook
            $photo_fb = $request->file('image_fb');
            if($photo_fb == null){
                return Redirect::back()->withInput()->withErrors(Lang::get('cms::message.upload_photo_fb_empty'));
            } else {
                $file = ['image_fb' => $photo_fb];
                $rules = [
                        'image_fb' =>'image|max:2048',
                ];
                $validator = Validator::make($file, $rules);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                } else {
                    $image_fb = $this->upload($photo_fb);
                    $article['image_fb_id'] = $image_fb->id;
                }
            }

            // save form article
            $article['slug']= Helpers::generateUniqueSlug($request->title);
            $article['user_id'] = $user->id;
            Article::create($article);
            return redirect()->route('articles.index');
        }catch (\Exception $e){
            $cate = Category::lists('name','id')->all();
            $user = Sentinel::getUser();
            return view('cms::articles.create',compact('user','cate'))->withErrors(Lang::get('cms::message.upload_file_maxsize'));
        }
    }

    /**
     * Show Article
     * @param unknown $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show($id)
    {
        $user = Sentinel::getUser();
        $status = Config::get('constants.article_status');
        $article = Article::findOrFail($id);
        $cate = $article->category_id;
        $cates = Category::find($cate);
        return view('cms::articles.show',compact('article','status','user','cates'));
    }

    /**
     * show form edit Article
     * @param unknown $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit($id)
    {
        $user = Sentinel::getUser();
        $article = Article::find($id);
        $cate = Category::lists('name','id')->all();
        return view('cms::articles.edit', compact('article','user','cate'));
    }

    /**
     * update Articles
     * @param unknown $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id,UpdateArticleRequest $request)
    {
        try {
            $article = Article::find($id);
            $articles = $request->all();
            $photo = $request->file('image');
            $photo_fb = $request->file('image_fb');

            //kiểm tra dữ liệu ảnh
            if (!empty($photo)){
                $image = Image::find($article->image_id);
                if ($image) {
                    $image = $this->updateImage($image, $photo);
                }else{
                    $image = $this->upload($photo);
                    $articles['image_id'] = $image->id;
                }

            }

            // kiểm tra dữ liệu
            if(!empty($photo_fb)){

            $image_fb = Image::find($article->image_fb_id);
                if ($image_fb) {
                    // Lưu image vào folder upload
                    $image_fb = $this->updateImage($image_fb, $photo_fb);
                }else{
                    $image_fb = $this->upload($photo_fb);
                    $articles['image_fb_id'] = $image_fb->id;
                }
            }

            // cập nhập bài viết
            $articles['slug']= Helpers::generateUniqueSlug($request->title);
            $article->update($articles);
            return redirect()->route('articles.index');
        }catch (\Exception $e){
            $user = Sentinel::getUser();
            $article = Article::find($id);
            $cate = Category::lists('name','id')->all();
            return view('cms::articles.edit', compact('article','user','cate'))->withErrors(Lang::get('cms::message.upload_file_maxsize'));
        }
    }

    /**
     * remove Article
     * @param unknown $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $article = Article::find($id);
        $img_id = $article->image_id;
        $image = Image::find($img_id);
        if($image){
            // Xóa trong DB
            $image->delete();
        }
        $img_fb_id = $article->image_fb_id;
        $image_fb = Image::find($img_fb_id);
        if($image_fb){
            // Xóa trong DB
            $image_fb->delete();
        }
        $article->delete();
        return redirect()->route('articles.index');
    }

    /**
     * Upload and create image
     * @param Request file $photo
     * @return \Modules\Cms\Entities\Image
     */
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
            $image->thumbs = '/uploads/articles/'.$newFileName ;
            $photo->move('uploads/articles/', $newFileName);
            $image->name = $newFileName;
            $image->save();
        }

        return $image;
    }

    /**
     * Upload and update image
     * @param Image $image
     * @param Request file $photo
     * @return Image
     */
    protected function updateImage($image, $photo){
        $image->file_type = $photo->getClientMimeType();
        $image->file_size = $photo->getClientSize();
        $name = $photo->getClientOriginalName(); // getting image name
        $extension = $photo->getClientOriginalExtension(); // getting image extension
        $extractFileName = explode('.'.$extension, $name)[0];
        $fileName = $extractFileName."-".$image->id;
        $newFileName = str_slug($fileName).".".$extension;
        $image->thumbs = '/uploads/articles/' . $newFileName;
        $image->name = $newFileName;
        $photo->move('uploads/articles/', $newFileName);
        $image->save();

        return $image;
    }
}