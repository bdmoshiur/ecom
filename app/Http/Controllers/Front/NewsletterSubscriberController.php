<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\NewsletterSubscriber;

class NewsletterSubscriberController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addSubscriber(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $subscriberCount = NewsletterSubscriber::where('email', $data['subscriber_email'])->count();
            if ($subscriberCount > 0) {
                return "exists";
            } else {
                $newsletter = new NewsletterSubscriber();

                $newsletter->email = $data['subscriber_email'];
                $newsletter->status = 1;
                $newsletter->save();

                return "inserted";
            }
        }
    }
}
