@extends('book::layouts.master')
@section('head-tag')
    <title> {{ $book->title }}</title>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
           @include('book::home.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">{{ $book->title }}</h4>
                </div>
                <div class="card-body">
                    <div class="media">
                        <img width="200" src="{{ asset($book->image) }}" class="rounded">
                        <div class="media-body mr-4">
                            <h3>{{ $book->title }}</h3>
                            <p>{{ $book->description }}</p>
                            <button class="btn btn-outline-success">مشاهده آنلاین</button>
                            <a href="{{ route('books.download' , $book->id) }}" class="btn btn-outline-info">دانلود</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
