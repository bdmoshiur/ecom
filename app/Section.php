<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    function categories()
    {
        return $this->hasMany('App\Category','section_id')->where(['parent_id'=>'ROOT', 'status'=>1])->with('subcategories');
    }
}
