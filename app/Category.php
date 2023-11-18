<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PharIo\Manifest\Url;

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

    public static function catDetails($url)
    {
        $catDetails = Category::select('id', 'parent_id', 'category_name', 'description', 'meta_title',
        'meta_description', 'meta_keywords', 'url')->with(['subcategories' => function ($query) {
            $query->select('id', 'parent_id')->where('status', 1);
        }])->where('url', $url)->first()->toArray();

        if ($catDetails['parent_id'] == 0) {
            $breadcambs = '<a href="' . Url($catDetails['url']) . '">' . $catDetails['category_name'] . '</a>';
        } else {
            $parentCategory = Category::select('category_name', 'url')->where('id', $catDetails['parent_id'])->first()->toArray();
            $breadcambs = '<a href="' . url($parentCategory['url']) . '">' . $parentCategory['category_name'] . '</a>&nbsp;<span class="divider">/</span>&nbsp;<a href="' . url($catDetails['url']) . '">' . $catDetails['category_name'] . '</a>';
        }

        $catIds = [];
        $catIds[] = $catDetails['id'];

        foreach ($catDetails['subcategories'] as $subCat) {
            $catIds[] = $subCat['id'];
        }

        return [
            'catIds' => $catIds,
            'catDetails' => $catDetails,
            'breadcambs' => $breadcambs,
        ];
    }
}
