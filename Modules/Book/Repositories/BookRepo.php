<?php

namespace Modules\Book\Repositories;

use Illuminate\Support\Facades\File;
use Modules\Book\Entities\Book;

class BookRepo
{

    public function index()
    {
        return Book::query()->latest();
    }

    public function delete($book)
    {
        if($book->image !== null and File::exists($book->image))
        {
            File::delete($book->image);
        }
        return $book->delete();
    }


}
