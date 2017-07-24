@extends('layouts.master')
@section('title', 'Hoạt động')

@section('content')
    <section class="newsdetail subpage region">
        <h2 class="textcenter fronttitle">Hoạt động</h2>
    </section>

    <!-- Begin newslist -->
    <section class="newslist subpage region">
        <div class="wauto">
            <div class="row boxsubpage">
                <!--Begin contents-->
                <article class="col col69 contents mcol100">
                    <!--Begin topnews-->
                    <div class="topnews">
                    @if($newest)
                        <?php  $image1 = Modules\Cms\Entities\Image::find($newest->image_id);?>
                        @if($image1)
                            <a href="{{ Route('site.articles.details',[$newest->id]) }}" title="{{ $newest->title }}" class="hidesm">
                                <img src="{{ asset($image1->thumbs) }}" width="762" height="313" alt="{{ $newest->title }}">
                            </a>
                            <a href="{{ Route('site.articles.details',[$newest->id]) }}" title="{{ $newest->title }}" class="hidepc">
                                <img src="{{ asset($image1->thumbs) }}" width="572" height="454" alt="{{ $newest->title }}">
                            </a>
                        @else
                            <a href="/" title="" class="hidesm"><img src="" width="762" height="313" alt=""></a>
                            <a href="/" title="" class="hidepc"><img src="" width="572" height="454" alt=""></a>
                        @endif
                        <div class="bgnew">
                            <span class="datetime">{{ \Carbon\Carbon::parse($newest->updated_at)->format('d-m-Y') }}</span>
                            <h3><a href="{{ Route('site.articles.details',[$newest->id]) }}" title="{{ $newest->title }}">{{ $newest->title }}</a></h3>
                        </div>
                    @endif
                    </div>
                    <!--End topnews-->
                    <!--Begin contentnewslist-->
                    <div class="contentnewslist">
                        <ul class="morenewslist">
                            @forelse($articles as $art)
                                <?php  $image = Modules\Cms\Entities\Image::find($art->image_id);?>
                                <li>
                                    <div class="row">
                                        <div class="col col24 mcol100">
                                            @if($image)
                                                <a  class="hidesm" href="{{ Route('site.articles.details',[$art->id]) }}" title="{{ $art->title }}">
                                                    <img class="mcol100 " src="{{ asset($image->thumbs) }}" width="157" height="112" alt="{{ $art->title }}"></a>
                                                <a  class="hidepc" href="{{ Route('site.articles.details',[$art->id]) }}" title="{{ $art->title }}">
                                                    <img class="mcol100 " src="{{ asset($image->thumbs) }}" width="570" height="240" alt="{{ $art->title }}"></a>
                                            @else
                                                <a  class="hidesm" href="#" title=""><img class="mcol100 " src="" width="157" height="112" alt="{{ $art->title }}"></a>
                                                <a  class="hidepc" href="#" title=""><img class="mcol100 " src="" width="570" height="240" alt="{{ $art->title }}"></a>
                                            @endif
                                        </div>
                                        <div class="col col75 mcol100">
                                            <div class="newsmedia">
                                                <?php $category = Modules\Cms\Entities\Category::Where('id', '=', $art->category_id)->first(); ?>
                                                <span class="ebtn" style="background-color:{{$category->color}}"> {{ $category->name}} </span>
                                                <span class="time">{{ \Carbon\Carbon::parse($art->updated_at)->format('d-m-Y') }}</span>
                                                <h4><a href="{{ Route('site.articles.details', [$art->id]) }}" title="{{ $art->title }}">{{ $art->title }}</a></h4>
                                                <article>
                                                    <p>{{ $art->brief }}</p>
                                                </article>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                @if(!$newest)
                                    <p>Không có bài viết để hiển thị</p>
                                @endif
                            @endforelse
                        </ul>
                        @if($articles)
                            @if($articles->total() > $articles_per_page)
                            <nav class="pagination">
                                <ul>
                                    {!! with(new App\Pagination\Pagination($articles->appends(\Input::except('page'))))->render() !!}
                                </ul>
                            </nav>
                            @endif
                        @endif
                    </div>
                    <!--End contentnewslist-->
                </article>
                <!--End contents-->
                <!--Begin sidebar-->
                <aside class="col col30 eventnew sidebar mcol100">
                    <div class="sidebarbox">
                        @if($newest)
                            <!--Begin latestnews-->
                            <div class="block latestnews">
                                <h3 class="newstitle">Hoạt động mới</h3>
                                <ul class="vertical-slide">
                                    <li><a href="{{ Route('site.articles.details', [$newest->id]) }}" title="{{ $newest->title }}"> {{ $newest->title }} </a></li>
                                    @forelse($articles as $art)
                                        <li><a href="{{ Route('site.articles.details', [$art->id]) }}" title="{{ $art->title }}"> {{ $art->title }} </a></li>
                                    @empty
                                    @endforelse
                                </ul>
                                <a href="{{URL::route('site.articles') }}" title="" class="more fontbold">Xem thêm</a>
                            </div>
                            <!--End latestnews-->
                        @endif
                    </div>
                </aside>
                <!--End sidebar-->
            </div>
        </div>
    </section>
<!-- End newslist -->
@stop