<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookCustomerBay extends Model
{
    use HasFactory, SoftDeletes;

    /*create transact number*/
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $randomAlphabet = chr(rand(65,90)).chr(rand(65,90));
            $formatId = $randomAlphabet . date('dmy')."-";
            $maxValue = DB::table('book_customer_bays')->where('book_number','like',"$formatId%")->max('book_number');
            if ($maxValue != null) {
                $counter = (int) substr($maxValue,9,3) + 1;
                $model->book_number = $formatId.str_pad($counter,3,0,STR_PAD_LEFT);
            }else{
               $model->book_number = $formatId.'001';
            }
        });
    }
}
