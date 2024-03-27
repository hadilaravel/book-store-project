<?php

namespace Modules\Payment\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Book\Entities\Book;

class Transaction extends Model
{
    use HasFactory;

    const STATUS_SUCCESS = 2;
    const STATUS_PENDING = 1;
    const STATUS_FAILED = 0;


    protected $fillable = [
        'user_id',
        'book_id',
        'payment_id',
        'status',
        'paid',
        'invoice_details',
        'transaction_id',
        'transaction_result'
    ];



    public function book()
    {
        return $this->belongsTo(Book::class , 'book_id');
    }

    public function user ()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function setInvoiceDetailsAttribute($value)
    {
        $this->attributes['invoice_details'] = serialize($value);
    }

    public function getInvoiceDetailsAttribute()
    {
        return unserialize($this->attributes['invoice_details']);
    }

    public function setTransactionResultAttribute($value)
    {
        $this->attributes['transaction_result'] = serialize($value);
    }

    public function getTransactionResultAttribute()
    {
        return unserialize($this->attributes['transaction_result']);
    }

}
