<?php

namespace Modules\Book\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Book\Entities\Book;
use Modules\Book\Http\Requests\BookRequest;
use Modules\Book\Repositories\BookRepo;
use Modules\Book\Services\BookService;

class BookAdminController extends Controller
{
    public BookRepo $bookRepo;
    public BookService $bookService;

    public function __construct(BookRepo $bookRepo , BookService $bookService)
    {
        $this->bookRepo = $bookRepo;
        $this->bookService = $bookService;
    }

    public function  index()
    {
        $books = $this->bookRepo->index()->paginate(8);
        return view('book::panel.index' , compact('books'));
    }


    public function create()
    {
        return view('book::panel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $this->bookService->store($request);
        alert()->success('ساخت محصول' , 'عملیات با موفقیت انجام شد');
        return to_route('admin.book.index');
    }


    public function edit(Book $book)
    {
        return view('book::panel.edit' , compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $this->bookService->update($request, $book);
        alert()->success('ویرایش محصول' , 'عملیات با موفقیت انجام شد');
        return to_route('admin.book.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $this->bookRepo->delete($book);
        alert()->success('حذف محصول' , 'عملیات با موفقیت انجام شد');
        return to_route('admin.book.index');
    }


    public function status(Book $book)
    {
        $book->status = $book->status == 0 ? 1 : 0;
        $book->save();
        alert()->success(' وضعیت  محصول' , 'وضعیت  پست با موفقیت  تغیر کرد');
        return to_route('admin.book.index');
    }

}
