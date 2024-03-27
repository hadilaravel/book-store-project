<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Book\Entities\Book;
use Modules\Payment\Entities\PurchasedBook;
use Modules\Payment\Entities\Transaction;
use Shetabit\Multipay\Exceptions\PurchaseFailedException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class PaymentController extends Controller
{

   public function purchase(Book $book)
   {

       if($book->isPurchased())
       {
           return to_route('books.show' , $book->id);
       }

       try {
           //       صورت حساب
           $invoice = new Invoice();
           $invoice->detail(['title' => 'فروشگاه کتاب', 'description' => 'ممنون که از فروشگاه ما خرید میکنید']);
           //       قیمت محصول
           $invoice->amount($book->price);
           //       ساخت یک شناسه یونیک ۳۲ کارکتری
           $paymentId = md5(uniqid());

           $transacrion = Transaction::query()->create([
               'user_id' => auth()->id(),
               'book_id' => $book->id,
               'paid' => $invoice->getAmount(),
               'invoice_details' => $invoice,
               'payment_id' => $paymentId,
           ]);


           $callBackRoute = route('books.purchase.result', ['book' => $book->id, 'payment_id' =>  $paymentId]);
           //       مرحله بعد ساخت یک پیمنت یا قابلیت پرداخت
           $payment = Payment::callbackUrl($callBackRoute);
           $payment->purchase($invoice, function ($driver, $transactionId) use ($transacrion) {
               $transacrion->transaction_id = $transactionId;
               $transacrion->save();
           });

           return $payment->pay()->render();

       }catch (PurchaseFailedException $e){
           $transacrion->transaction_result = $e;
            $transacrion->status = Transaction::STATUS_FAILED;
           $transacrion->save();
           alert()->success('خرید محصول' , 'عملیات با شکست مواجه شد ');
           return to_route('books.index');
       }

   }

   public function result(Request $request , Book $book)
   {
       if($request->missing('payment_id')){
           alert()->success(' محصول' , 'عملیات با شکست مواجه شد ');
           return to_route('books.index');
       }
       $transaction = Transaction::query()->where('payment_id' , $request->payment_id)->first();
       if(empty($transaction))
       {
           alert()->success(' محصول' , 'عملیات با شکست مواجه شد ');
           return to_route('books.index');
       }

       if($transaction->user_id !== \auth()->id())
       {
           alert()->success(' محصول' , 'عملیات با شکست مواجه شد ');
           return to_route('books.index');
       }

       if($transaction->book_id !== $book->id)
       {
           alert()->success(' محصول' , 'عملیات با شکست مواجه شد ');
           return to_route('books.index');
       }

       if($transaction->status !== Transaction::STATUS_PENDING)
       {
           alert()->success(' محصول' , 'عملیات با شکست مواجه شد ');
           return to_route('books.index');
       }
       try {
           $receipt = Payment::amount($transaction->paid)->transactionId($transaction->transaction_id)->verify();
           $transaction->status = Transaction::STATUS_SUCCESS;
           $transaction->save();
           PurchasedBook::query()->create([
              'user_id' => \auth()->id(),
              'book_id' => $book->id
           ]);
           alert()->success(' خرید محصول' , 'خرید شما با موفقیت انجام شد ');
           return to_route('books.index');
       }catch (PurchaseFailedException $e){
          if($e->getCode() < 0){
              $transaction->status = Transaction::STATUS_FAILED;
              $transaction->save();
          }
       }


   }

}
