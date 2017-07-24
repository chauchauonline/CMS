@extends('layouts.master')
@section('title', 'Giới thiệu')
@section('content')
        <section class="subpage region">
            <h2 class="textcenter fronttitle">Giới Thiệu</h2>
        </section>
<section class="aboutseta subpage region">
       <div class="contentabout">
        <div class="wauto">
            <div class="boxsubpage">
                <div class="informationsatff info-bout">
                <h4 style="text-align: center;">{{ $page->name}}</h4>
                <p>
                    {!! $page->content !!}
                </p>
                </div>
            </div>
        </div>
@stop