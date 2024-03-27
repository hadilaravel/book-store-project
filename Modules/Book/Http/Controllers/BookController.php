<?php

namespace Modules\Book\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Modules\Book\Entities\Book;
use Modules\Book\Repositories\BookRepo;
use Modules\Payment\Entities\PurchasedBook;

class BookController extends Controller
{

    public BookRepo $bookRepo;

    public function __construct(BookRepo $bookRepo)
    {
        $this->bookRepo = $bookRepo;
    }

    public function index()
    {
        Auth::loginUsingId(1);
        $books = $this->bookRepo->index()->where('status' , 1)->get();
        return view('book::home.index' , compact('books'));
    }

    public function show(Book $book)
    {
        abort_if(!$book->isPurchased() , 403);
        return view('book::home.single' , compact('book'));
    }

    public function download(Book $book)
    {
        abort_if(!$book->isPurchased() , 403);
        return Response::download($book->image);
    }

    public function library()
    {
        $items = PurchasedBook::query()->where('user_id' , \auth()->id())->with('book')->get();
        return view('book::home.library' , compact('items'));
    }

    public function logout()
    {
        Auth::logout();
        return back();
    }

    public function transactions()
    {
        $transactions = \auth()->user()->transactions;
        dd($transactions->toArray());
    }

}
