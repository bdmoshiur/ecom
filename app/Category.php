<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

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

    public static function categoryDetails($url)
    {
        $categoryDetails = Category::select('id','category_name','url')->with(['subcategories' => function ($query) {
            $query->select('id', 'parent_id')->where('status', 1);
        }])->where('url', $url)->first()->toArray();
        $catIds = [];
        $catIds = $categoryDetails['id'];
        foreach ($categoryDetails['subcategories'] as $subCat) {
            $catIds = $subCat['id'];
        }
        return [
            'catIds' => $catIds,
            'categoryDetails' => $categoryDetails
        ];
    }
}
