<?php

namespace Modules\Book\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Payment\Entities\PurchasedBook;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title' , 'description' , 'price' , 'image' , 'status'];

    public function purchasedBooks()
    {
        return $this->hasMany(PurchasedBook::class , 'user_id');
    }

    public function isPurchased()
    {
        return  PurchasedBook::query()->where('user_id' , \auth()->id())->where('book_id' , $this->id)->exists();
    }

}
