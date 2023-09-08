<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ratings()
    {
        Session::put('page', "ratings");
        $ratings = Rating::with('user','product')->get()->toArray();

        return view('admin.ratings.ratings',[
            'ratings' => $ratings,
        ]);
    }

    public function updatRatingStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Rating::where('id', $data['rating_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'rating_id' => $data['rating_id']]);
        }
    }

}
