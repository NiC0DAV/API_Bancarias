<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusFinanceForEmail extends Model
{
    use HasFactory;
    protected $table = 'FN_STATUS_FINANCE_FOR_EMAIL';
    protected $dateFormat = 'Y-m-d\TH:i:s';
}
