<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function sections()
    {
        $getSections = Section::with('categories')->where('status',1)->get();
        $getSections = json_decode(json_encode($getSections), true);

        return $getSections;
    }

    function categories()
    {
        return $this->hasMany('App\Category','section_id')->where(['parent_id'=>'ROOT', 'status'=>1])->with('subcategories');
    }
}
