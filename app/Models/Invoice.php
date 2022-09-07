<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    public function payment(){
        return $this->belongsTo(Payment::class,'id','invoice_id');
    }

    use HasFactory;
    protected $guarded = [];
}
