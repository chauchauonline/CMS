<?php
namespace Modules\Cms\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Cms\Entities\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Modules\Cms\Entities\Article;

class CategoryController extends Controller
{
    public function index()
    {
        $records = Config::get('constants.RECORD_PER_PAGE');
        $categories = Category::paginate($records);
        $category_status = Config::get('constants.CATEGORY_STATUS');
        return View::make('cms::categories.index', compact('categories', 'category_status'));
    }

    public function create()
    {
        $category_status = Config::get('constants.CATEGORY_STATUS');
        return view('cms::categories.create', compact('category_status'));
    }

    public function store( Request $request )
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'color' => 'required',
            'slug' => 'required|max:50|unique:categories',
        ]);
        $data = $request->all();
        $category = Category::create($data);
        return redirect('categories')->withSuccess(Lang::get('cms::message.create_category_success'));
    }

    public function show($id)
    {
        $category = Category::find($id);
        $category_status = Config::get('constants.CATEGORY_STATUS');
        return View::make('cms::categories.show', compact('category', 'category_status'));
    }

    public function edit( $id )
    {
        if($category = Category::find($id)) {
            $category_status = Config::get('constants.CATEGORY_STATUS');
            return View::make('cms::categories.edit', compact('category', 'category_status'));
        } else {
            return redirect('categories')->withErrors(Lang::get('cms::message.category_not_found'));
        }
    }

    public function update( Request $request, $id )
    {
        $this->validate($request, [
                'name' => 'required|max:50',
                'color' => 'required',
                'slug' => 'required|max:50|unique:categories,slug,'. $id,
        ]);
        $data = $request->all();
        $category = Category::find($id);
        $category->update($data);
        return redirect('categories')->withSuccess(Lang::get('cms::message.update_category_success'));
    }

    public function delete( Request $request)
    {
        $id = $request->input('id');
        $article = Article::Where('category_id','=',$id)->count();
        if ($article == 0){
            $category = Category::find($id);
            $category->delete();
            return redirect('categories')->withSuccess(Lang::get('cms::message.delete_category_success'));
        }else {
            return redirect('categories')->withErrors(Lang::get('cms::message.delete_category_fail'));
        }
    }

    public function generate_slug(Request $request) {
        $name = $request->get('name');
        $slug = str_slug($name);
        return response()->json(['result' => 'ok', 'data' => ['slug' => $slug]]);
    }
}