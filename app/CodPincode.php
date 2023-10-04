<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodPincode extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'cod_pincodes';
}
