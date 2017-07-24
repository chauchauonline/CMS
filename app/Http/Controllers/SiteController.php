<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Modules\Cms\Entities\User;
use Modules\Cms\Entities\Article;
use Modules\Cms\Entities\Page;
use Modules\Cms\Entities\ContactForm;
use Illuminate\Support\Facades\Config;
use DB;
use Modules\Cms\Entities\Category;
use Redirect;
use Modules\Cms\Entities\Company;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class SiteController extends Controller
{
    public function index()
    {
        if($user = Sentinel::check()){
            $members =  User::all();
        }else{
            $members = User::Where('share','=','1')->orderBy('created_at','DESC')->get();
        }
        $articles = DB::table('articles as a')
                        ->where('a.deleted_at', '=', null)
                        ->Where('a.status','=', '1')
                        ->join('categories as c', 'a.category_id', '=', 'c.id')
                        ->Where('c.deleted_at', '=', null)
                        ->Where('c.status', '=', '1')
                        ->orderBy('a.updated_at','DESC')
                        ->select('a.*')
                        ->take(3)->get();
        return View::make('site.index', compact('members', 'articles'));
    }

    public function contact()
    {
        return View::make('site.contact');
    }

    public function save_contact(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required|max:100',
            'email'     => 'required|email',
            'mobile'    => 'required|regex: /^[0-9+]*$/|min:8|max:15',
        ]);
        $data = $request->all();
        $contact = ContactForm::create($data);
        $contact->status = Config::get('constants.UNREPLY');
        $contact->save();
        return redirect('/');
    }

    public function get_all_members(Request $request)
    {
        $company = Company::take(4)->get();
        $key = $request->get('keyword');
        $members_per_page = Config::get('constants.MEMBERS_PER_PAGE');
        if($key) {
            $members = User::Where(function($query) use ($key) {
                                 $query->orWhere(DB::raw('CONCAT(last_name, " ", first_name)'), 'LIKE', "%".trim($key)."%")
                                        ->orWhere('company_name', 'LIKE', "%".trim($key)."%")
                                        ->orWhere('mobile', 'LIKE', "%".trim($key)."%")
                                        ->orWhere('position', 'LIKE', "%".trim($key)."%")
                                        ->orWhere('career', 'LIKE', "%".trim($key)."%");
                            })
                            ->Where(function($query) use ($key) {
                                if(! Sentinel::check()){
                                    $query->Where('share', '=', '1');
                                }
                            })
                            ->orderBy('updated_at', 'DESC')
                            ->paginate($members_per_page);
            $members->appends(['keyword' => $key]);
        } else {
            if($user = Sentinel::check()){
                $members = User::orderBy('updated_at', 'DESC')
                                ->paginate($members_per_page);
            } else {
                $members = User::Where('share', '=', '1')
                                ->orderBy('updated_at', 'DESC')
                                ->paginate($members_per_page);
            }
        }
        return View::make('site.members', compact('members', 'key', 'members_per_page', 'company'));
    }

    public function show_page($slug)
    {
        $page = Page::Where('status','=','1')->Where('slug', '=', $slug)->first();
        if($page) {
            return View::make('site.show_page', compact('page'));
        } else {
            return redirect('/')->withErrors('Page not found!');
        }
    }

    public function member_details($id)
    {
        $member = User::Where('id', '=', $id)->first();
        if($member){
            $position = $member->position;
            $career = $member->career;
            if($user = Sentinel::check()){
                $related_member = User::Where('id', '<>', $member->id)
                                        ->where(function($query) use ($position, $career) {
                                            if( $career != '') {
                                                $query->orWhere('career', 'LIKE', "%".$career."%");
                                            }
                                            if($position != '') {
                                                    $query->orWhere('position', 'LIKE', "%".$position."%");
                                            }
                                        })
                                        ->orderBy('first_name')
                                        ->get();
                return view('site.member_details', compact('member', 'related_member'));
                } else {
                    $related_member = User::Where('share', '=', '1')
                                            ->Where('id', '<>', $member->id)
                                            ->where(function($query) use ($position, $career) {
                                                if( $career != '') {
                                                    $query->orWhere('career', 'LIKE', "%".$career."%");
                                                }
                                                if($position != '') {
                                                    $query->orWhere('position', 'LIKE', "%".$position."%");
                                                }
                                            })
                                            ->orderBy('first_name')
                                            ->get();
                }
            return view('site.member_details', compact('member', 'related_member'));
        }
        return redirect('members')->withErrors("Hội viên không tồn tại");
    }

    public function about()
    {
        $about = Page::Where('status','=','1')->orderBy('order','ASC')->take(5)->get();
        return view('site.about',compact('about'));
    }

    public function search(Request $request) {
        $keyword = $request->get('keyword');
        $articles_per_page = Config::get('constants.ARTICLES_PER_PAGE', 5);
        $articles = DB::table('articles as a')
                        ->where('a.deleted_at', '=', null)
                        ->Where('a.status','=', '1')
                        ->Where(function($query) use ($keyword) {
                                     $query->where('a.title','LIKE',"%".trim($keyword)."%")
                                        ->orWhere('a.brief','LIKE',"%".trim($keyword)."%");
                        })
                        ->join('categories as c', 'a.category_id', '=', 'c.id')
                        ->Where('c.deleted_at', '=', null)
                        ->Where('c.status', '=', '1')
                        ->orderBy('a.updated_at','DESC')
                        ->select('a.*')
                        ->paginate($articles_per_page);
        return View::make('site.search', compact('articles', 'articles_per_page', 'keyword'));
    }

    public function show_all_articles()
    {
        $articles_per_page = Config::get('constants.ARTICLES_PER_PAGE');
        $newest = DB::table('articles as a')
                    ->where('a.deleted_at', '=', null)
                    ->Where('a.status','=', '1')
                    ->join('categories as c', 'a.category_id', '=', 'c.id')
                    ->Where('c.deleted_at', '=', null)
                    ->Where('c.status', '=', '1')
                    ->orderBy('a.updated_at','DESC')
                    ->select('a.*')
                    ->first();
        if($newest){
            $newest_id = $newest->id;
            $articles = DB::table('articles as a')
                                ->where('a.deleted_at', '=', null)
                                ->Where('a.status','=', '1')
                                ->Where('a.id', '<>', $newest_id)
                                ->join('categories as c', 'a.category_id', '=', 'c.id')
                                ->Where('c.deleted_at', '=', null)
                                ->Where('c.status', '=', '1')
                                ->orderBy('a.updated_at','DESC')
                                ->select('a.*')
                                ->paginate($articles_per_page);
        } else {
            $articles =[];
        }
        return View::make('site.show_all_articles', compact('newest', 'articles', 'articles_per_page'));
    }

    public function show_article_details($article_id)
    {
        $article = Article::find($article_id);
        $category_id = $article->category_id;
        $category = Category::find($category_id);
        $articles = DB::table('articles as a')
                        ->where('a.deleted_at', '=', null)
                        ->Where('a.status','=', '1')
                        ->join('categories as c', 'a.category_id', '=', 'c.id')
                        ->Where('c.deleted_at', '=', null)
                        ->Where('c.status', '=', '1')
                        ->orderBy('a.updated_at','DESC')
                        ->select('a.*')
                        ->get();
        $related_articles = Article::Where('id', '<>', $article_id)
                                    ->Where('status', '=', '1')
                                    ->Where('category_id', '=', $category_id)
                                    ->orderBy('updated_at', 'DESC')
                                    ->take(3)->get();
        return view::make('site.show_article_details',compact('article', 'articles', 'related_articles', 'category'));
    }
}