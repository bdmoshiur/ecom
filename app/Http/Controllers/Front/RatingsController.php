<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RatingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addRating( Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);

            if (!Auth::check()) {
                $message = "Login to rate this product";

                Session::flash('error_message', $message);
                return redirect()->back();
            }

            if (!isset( $data['rating'] )) {
                $message = "Add atleast one start rating for this product";

                Session::flash('error_message', $message);
                return redirect()->back();
            }

            $ratingCount = Rating::where(['user_id'=> Auth::user()->id, 'product_id' => $data['product_id'] ])->count();

            if( $ratingCount > 0 ){
                $message = "Your rating already exits for this product";
                Session::flash('error_message', $message);
                return redirect()->back();
            } else {
                $rating = new Rating();
                $rating->user_id = Auth::user()->id;
                $rating->product_id = $data['product_id'];
                $rating->rating = $data['rating'];
                $rating->review = $data['review'];
                $rating->status = 0;
                $rating->save();

                $message = "Thanks for rating this product! It will be shown once aproved.";
                Session::flash('success_message', $message);
                return redirect()->back();
            }
        }
    }



}
