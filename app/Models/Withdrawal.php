<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;
    //Payment Detail Relationship
    public function payment_detail()
    {
        return $this->belongsTo('App\Models\BankDetail');
    }

    //User Detail Relationship
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    //,Investment Relationship
    public function investment()
    {
        return $this->belongsTo('App\Models\Investment');
    }

}
