@extends('layouts.master')
@section('title', $article->title)

@section('content')
    <!--Begin newsdetail-->
    <section class="newsdetail subpage region">
        <h2 class="textcenter fronttitle">Hoạt động</h2>
        <div class="wauto">
            <div class="row boxsubpage">
                <!--Begin contents-->
                <article class="col col69 contents mcol100">
                <!--Begin topnewsdetail-->
                <div class="topnewsdetail">
                    <?php $img = Modules\Cms\Entities\Image::find($article->image_id); ?>
                    @if($img)
                        <a class="hidesm"><img src="{{ asset($img->thumbs) }}" width="762" height="313" alt="{{ $article->title }}"></a>
                        <a class="hidepc"><img src="{{ asset($img->thumbs) }}" width="572" height="408" alt="{{ $article->title }}"></a>
                    @endif
                    <div class="subtitle">
                        <span class="ebtn" style="background-color:{{$category->color}}">{{ $category->name }}</span>
                        <span class="time">{{ $article->updated_at->format('d-m-Y') }}</span>
                    </div>
                    <div class="contentarticles">
                        <h3>{{ $article->title }}</h3>
                        {!! $article->content !!}
                    </div>
                    </div>
                    <!--End topnewsdetail-->
                    <!--Begin relatedarticles-->
                    <div class="relatedarticles">
                        <h3 class="newstitle">Các bài viết liên quan</h3>
                        <div class="contentnewslist">
                            <ul class="morenewslist">
                            @forelse ($related_articles as $news)
                                <li>
                                    <div class="row">
                                        <div class="col col24 mcol100">
                                            <?php $img = Modules\Cms\Entities\Image::find($news->image_id); ?>
                                            @if($img)
                                                <a class="hidesm" href="{{ Route('site.articles.details', [$news->id]) }}" >
                                                    <img class="mcol100 " src="{{ asset($img->thumbs) }}" width="157" height="112" alt="{{ $news->title }}"></a>
                                                <a class="hidepc" href="{{ Route('site.articles.details', [$news->id]) }}" >
                                                    <img class="mcol100 " src="{{ asset($img->thumbs) }}" width="570" height="240" alt="{{ $news->title }}"></a>
                                            @endif
                                        </div>
                                        <div class="col col75 mcol100">
                                            <div class="newsmedia">
                                                <span class="ebtn" style="background-color:{{$category->color}}">{{ $category->name }}</span>
                                                <span class="time">{{ $news->updated_at->format('d-m-Y') }}</span>
                                                <h4><a href="{{ Route('site.articles.details', [$news->id]) }}" title="{{ $news->title }}"> {{ $news->title }}</a></h4>
                                                <article class="hidesm">
                                                    <p>{{ $news->brief }}</p>
                                                </article>
                                            </div>
                                      </div>
                                    </div>
                                </li>
                            @empty
                            @endforelse
                            </ul>
                        </div>
                    </div>
                    <!--End relatedarticles-->
                    </article>
                <!--End contents-->
                <!--Begin sidebar-->
                <aside class="col col30 eventnew sidebar mcol100">
                    <div class="sidebarbox">
                        <!--Begin latestnews-->
                        <div class="block latestnews">
                            <h3 class="newstitle">Hoạt động mới</h3>
                            <ul class="vertical-slide">
                                @forelse($articles as $art)
                                    <li><a href="{{ Route('site.articles.details', [$art->id]) }}" title="{{ $art->title }}"> {{ $art->title }} </a></li>
                                @empty
                                @endforelse
                            </ul>
                            <a href="{{ Route('site.articles') }}" title="" class="more fontbold">Xem thêm</a>
                        </div>
                        <!--End latestnews-->
                    </div>
                </aside>
                <!--End sidebar-->
            </div>
        </div>
    </section>
    <!--End newsdetail-->
@stop