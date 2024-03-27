<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Book\Entities\Book;

class PurchasedBook extends Model
{
    use HasFactory;

    protected $fillable = ['book_id' , 'user_id'];

    public function book()
    {
        return $this->belongsTo(Book::class , 'book_id');
    }

}
