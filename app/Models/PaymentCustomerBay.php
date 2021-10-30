<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentCustomerBay extends Model
{
    use HasFactory, SoftDeletes;


    /*create transact number*/
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $randomAlphabet = chr(rand(65,90)).chr(rand(65,90));
            $formatId = $randomAlphabet . date('dmy')."-";
            $maxValue = DB::table('payment_customer_bays')->where('payment_number','like',"$formatId%")->max('payment_number');
            if ($maxValue != null) {
                $counter = (int) substr($maxValue,9,3) + 1;
                $model->payment_number = $formatId.str_pad($counter,3,0,STR_PAD_LEFT);
            }else{
               $model->payment_number = $formatId.'001';
            }
        });
    }
}
