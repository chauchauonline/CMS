@extends('layouts.master')
@section('title', 'Tìm kiếm')
@section('content')
    <section class="newsdetail subpage region">
        <h2 class="textcenter fronttitle">Tìm kiếm</h2>
    </section>

    <!-- Begin contents -->
    <section class="searchpage subpage region">
        <div class="wauto">
            <div class="row boxsubpage">
                <article class="col col69 contents mcol100">
                    {!! Form::open(array('method' => 'GET', 'route' => 'site.search', 'class'=>'searchform-2')) !!}
                        <input type="text" class="searchinput" placeholder="Tìm kiếm" name="keyword" value="{{$keyword}}">
                        <input type="submit" class="btnsearch">
                    {!! Form::close() !!}
                    <!--Begin contentsearchresult-->
                    <div class="recruit-content">
                        <ul>
                            @forelse($articles as $art)
                                <?php $category = Modules\Cms\Entities\Category::where('id', '=', $art->category_id)->first();?>
                                <li class="mcol100">
                                    <h4><a href="{{ Route('site.articles.details', [$art->id]) }}" title="{{ $art->title }}">{{ $art->title }}</a></h4><br>
                                    <p>{{ $art->brief }}</p>
                                </li>
                            @empty
                                <p style="padding-left: 15px"> Không có dữ liệu</p>
                            @endforelse
                        </ul>
                    </div>
                    <!--End contentsearchresult-->
                    <?php $total = $articles->total()?>
                    @if($total > $articles_per_page)
                    <nav class="pagination">
                        <ul>
                            {!! with(new App\Pagination\Pagination($articles->appends(\Input::except('page'))))->render() !!}
                        </ul>
                    </nav>
                    @endif
                </article>
            </div>
        </div>
    </section>
<!-- End contents -->
@stop