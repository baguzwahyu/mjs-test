<?php

namespace App;

use Alfa6661\AutoNumber\AutoNumberTrait;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use AutoNumberTrait;
    
    protected $guarded = [];

    public function getAutoNumberOptions()
    {
        return [
            'transaction_no' => [
                'format' => 'TRX.?', // autonumber format. '?' will be replaced with the generated number.
                'length' => 5 // The number of digits in an autonumber
            ]
        ];
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
