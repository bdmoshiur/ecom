<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrepaidPincode extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'prepaid_pincodes';
}
