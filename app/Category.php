<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'parent_id',
    //     'section_id',
    //     'category_name',
    //     'category_image',
    //     'category_discount',
    //     'description',
    //     'url',
    //     'meta_title',
    //     'meta_description',
    //     'meta_keywords',
    // ];

    public function subcategories()
    {
        return $this->hasMany('App\Category', 'parent_id')->where('status', 1);
    }

    public function section()
    {
        return $this->belongsTo('App\Section', 'section_id')->select('id', 'name');
    }

    function parentcategory()
    {
        return $this->belongsTo('App\Category', 'parent_id')->select('id', 'category_name');
    }
}
