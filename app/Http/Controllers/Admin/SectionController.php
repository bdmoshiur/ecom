<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function sections()
    {
        $sections = Section::get();
        return view('admin.sections.sections',compact('sections'));
    }
}
