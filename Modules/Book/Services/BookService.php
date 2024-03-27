<?php

namespace Modules\Book\Services;

use Illuminate\Support\Facades\File;
use Modules\Book\Entities\Book;

class BookService
{

    public function store($request)
    {
        $inputs = [
            'title' => $request->title,
            'description'=> $request->description,
            'price'=> $request->price,
            'status'=> $request->status,
        ];
        if($request->hasFile('image')) {
            $imageName = 'book/images/' . time().'.'.$request->image->extension();
            $request->image->move(public_path('book/images/'), $imageName);
            $inputs['image'] = $imageName;
        }
        return Book::query()->create($inputs);
    }

    public function update($request , $book)
    {
        $inputs = [
            'title' => $request->title,
            'description'=> $request->description,
            'price'=> $request->price,
            'status'=> $request->status,
        ];

        if($request->hasFile('image')) {
            if($book->image !== null and File::exists($book->image))
            {
                File::delete($book->image);
            }
            $imageName = 'book/images/' . time().'.'.$request->image->extension();
            $request->image->move(public_path('book/images/'), $imageName);
            $inputs['image'] = $imageName;
        }
        return $book->update($inputs);
    }

}
