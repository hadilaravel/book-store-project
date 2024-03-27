@extends('book::layouts.master')
@section('head-tag')
    <title>کتاب ها</title>
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
                    <h4 class="mb-0">کتاب‌ها 📖️</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($books as $book)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img class="card-img-top" width="640" height="204" src="{{ asset($book->image) }}" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ Str::limit($book->title, 20) }}</h5>
                                    <p class="card-text">{{ Str::limit($book->description, 75) }}</p>
                                    <p class="mb-1 text-warning text-center">{{ number_format($book->price) }} تومان</p>
                                    <a href="{{ route('books.purchase' , $book) }}" class="btn-block btn btn-success"> خرید »</i></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
