<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\NewsletterSubscriber;
use Illuminate\Support\Facades\Session;

class NewsletterSubscriberController extends Controller
{
    public function newsletterSubscriber() {
        Session::put('page', "newsletter_subscriber");
        $newsletter_subscriber = NewsletterSubscriber::orderBy('created_at','DESC')->get()->toArray();

        return view('admin.newsletter.newsletter_subscriber',[
            'newsletter_subscriber' => $newsletter_subscriber,
        ]);
    }

    public function updateSubscriberStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            NewsletterSubscriber::where('id', $data['subscriber_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'subscriber_id' => $data['subscriber_id']]);
        }
    }

    public function deleteSubscriber($id)
    {
        $deleteSubscriber = NewsletterSubscriber::find($id)->delete();
        Session::flash('success_message', 'Subscriber Deleted Successfully');
        return redirect()->back();
    }
}
