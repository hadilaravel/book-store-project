@extends('book::layouts.master')
@section('head-tag')
    <title>کتاب های من</title>
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
                    <h4 class="mb-0">کتابخانه‌ی من 📖️</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($items as $item)
                        <div class="col-md-4 mb-3">
                            <div class="card">
{{--                                <img  width="640" height="204" src="{{ asset($item->book->image) }} alt="Card image cap">--}}
                                <img src="{{ asset($item->book->image) }}" class="card-img-top" >
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('books.show', $item->book->id) }}">{{ $item->book->title }}</a>
                                    </h5>
                                    <p class="card-text">{{ Str::limit($item->book->description, 75) }}</p>
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
