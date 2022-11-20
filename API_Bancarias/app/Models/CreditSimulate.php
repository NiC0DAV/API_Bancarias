<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditSimulate extends Model
{
    use HasFactory;
    protected $table = 'FN_CREDITSIMULATE';

    protected $fillable = [
        'financialCode',
        'totalAmount',
        'shippingAmount',
        'currency',
        'documentType',
        'documentNumber',
        'firstName',
        'lastName',
        'email',
        'mobileNumber',
        'mobileNumberCountryCode',
        'validToFinance',
        'causalRejection',
        'maximunPaymentTerm',
        'guaranteeRate',
        'requestIP',
        'requestDate',
    ];

}
