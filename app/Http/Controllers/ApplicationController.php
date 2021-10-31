<?php

namespace App\Http\Controllers;

use App\Models\Bay;
use App\Models\BookCustomerBay;
use App\Models\PaymentCustomerBay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    //
    public function checkAvailable()
    {
        $result = Bay::where('status','available')->get();
        return $this->responseJson(200,"success", $result);
    }

    public function book(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'customer_id' => 'required',
            'bay_id' => 'required',
            'owner_id' => 'required',
        ]);
        if ($validate->fails()) {
            return $this->responseJson(400,$validate->errors(),[]);
        }

        // before book, check if current user having another book active before
        // this assumption 1 user only can book 1 bay at the same time
        $checkBook = BookCustomerBay::where('customer_id',$request->customer_id)
                    ->whereNull('end_date')->first();
        if($checkBook){
            return $this->responseJson(500,"you have already another book",[]);
        }

        DB::beginTransaction();
        try {
            if($this->isAvailableBay($request->bay_id)){
                // book the selected bay
                $book = new BookCustomerBay();
                $book->bay_id = $request->bay_id;
                $book->customer_id = $request->customer_id;
                $book->start_date = date('Y-m-d H:i:s');
                $book->save();

                // updating bay
                $this->bookedBay($request->bay_id);
                DB::commit();
                return $this->responseJson(201,"success", $book);
            }

            $anotherBay = $this->checkAvailableBayByOwner($request->owner_id);
            if ($anotherBay != 0){
                // select another bay to book
                $book = new BookCustomerBay();
                $book->bay_id = $anotherBay;
                $book->customer_id = $request->customer_id;
                $book->start_date = date('Y-m-d H:i:s');
                $book->save();

                // updating bay
                $this->bookedBay($anotherBay);
                DB::commit();
                return $this->responseJson(201,"success", $book);
            }
        }catch(\Illuminate\Database\QueryException $e){
            DB::rollback();
            return $this->responseJson(500,"internal server error " . $e->getMessage());
        }

        return $this->responseJson(404,"fully booked",[]);

    }

    public function calculatePrice(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'book_id' => 'required',
        ]);
        if ($validate->fails()) {
            return $this->responseJson(400,$validate->errors(),[]);
        }

        // getting book data
        $duration = $this->duration($request->book_id);
        $price = $this->calculate($duration);
        return $this->responseJson(201,"success", ["price" => $price]);
    }

    public function payment(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'book_id' => 'required',
        ]);
        if ($validate->fails()) {
            return $this->responseJson(400,$validate->errors(),[]);
        }

        // getting book data
        $book = BookCustomerBay::firstWhere('id',$request->book_id);
        if ($book->status == 'paid'){
            return $this->responseJson(500,"book was paid");
        }

        DB::beginTransaction();
        try {
            // calculate charge
            $duration = $this->duration($request->book_id);
            $price = $this->calculate($duration);

            // make payment
            $payment = new PaymentCustomerBay();
            $payment->book_customer_bay_id = $book->id;
            $payment->owner_payment_method_id = 1;
            $payment->charge = $price;
            $payment->tip = 0;
            $payment->tax = 0;
            $payment->total = $price;
            $payment->status = 'settlement';
            $payment->save();

            // update book
            $book->end_date = date('Y-m-d H:i:s');
            $book->status = 'paid';
            $book->duration_in_hours = $duration;
            $book->save();

            // update the bay
            $bay = Bay::firstWhere('id',$book->bay_id);
            $bay->status = 'available';
            $bay->save();
            DB::commit();
            return $this->responseJson(201,"success", $payment);

        }catch(\Illuminate\Database\QueryException $e){
            DB::rollback();
            return $this->responseJson(500,"internal server error " . $e->getMessage());
        }

    }

    // validate the selected bay is booked or not
    private function isAvailableBay($bayId)
    {
        $result = Bay::where('status','available')
                    ->where('id',$bayId)->first();
        if($result){
            return true;
        }
        return false;
    }

    // this function to get another bay available
    private function checkAvailableBayByOwner($ownerId)
    {
        $result = Bay::where('status','available')
                    ->where('owner_id',$ownerId)->first();
        if($result){
            return $result->id;
        }
        return 0; // when 0 it's mean all bay is booked
    }

    private function bookedBay($bayId)
    {
        $bay = Bay::firstWhere('id',$bayId);
        $bay->status = 'occupied';
        $bay->save();
    }


    private function duration($bookId)
    {
        $book = BookCustomerBay::firstWhere('id',$bookId);
        $start  = date_create($book->start_date);
        $now = date_create(date('Y-m-d H:i:s'));
        $diff  = date_diff( $start, $now );
        $hours = $diff->h;
        return $hours;
    }

    private function calculate($duration)
    {
        $price = 0;
        if ( $duration >= 1 && $duration <= 2 ){
            $price = 20;
        }else if( $duration >= 2 && $duration <= 3){
            $price = 60;
        }else if( $duration >= 3 && $duration <= 4){
            $price = 240;
        }else if ($duration > 4){
            $price = 300;
        }
        return $price;
    }
}
