<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentInsurance extends Model
{
    use HasFactory;

    protected $table = "xray_payment_insurance";

    protected $fillable = [
        'id_payment',
        'payment',
        'created_at',
        'deleted_at'
    ];
}
