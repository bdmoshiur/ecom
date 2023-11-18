<?php

namespace App\Http\Controllers\Front;

use App\CmsPage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class CmsPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function cmsPage()
    // {
    //     $currentRoute = url()->current();
    //     $currentRoute = str_replace('http://127.0.0.1:8000/','', $currentRoute);
    //     $cmsPagePoute = CmsPage::where(['status' => 1])->get()->pluck('url')->toArray();

    //     if (in_array($currentRoute, $cmsPagePoute)) {

    //         $cmsPageDetails = CmsPage::where('url', $currentRoute)->first()->toArray();

    //         $meta_title = $cmsPageDetails['meta_title'];
    //         $meta_description = $cmsPageDetails['meta_description'];
    //         $meta_keywords = $cmsPageDetails['meta_keywords'];

    //         return view('front.pages.cms_pages',[
    //             'cmsPageDetails' => $cmsPageDetails,
    //             'meta_title' => $meta_title,
    //             'meta_description' => $meta_description,
    //             'meta_keywords' => $meta_keywords,
    //         ]);
    //     }else{
    //         abort(404);
    //     }

    // }

    /**
     * Show the form for contactUs.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactUs(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'comment' => 'required',
            ];
            $customMessage = [
                'name.required' => 'Name is Required',
                'email.required' => 'Email is Required',
                'email.email' => 'Valid email is Required',
                'subject.required' => 'Subject is Required',
                'comment.required' => 'Message is Required',
            ];
            $validator = Validator::make($data, $rules, $customMessage);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $email = "moshiurcse888@gmail.com";
            $messageData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'comment' => $data['comment'],
            ];

            Mail::send('emails.enquiry', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Enquiry from e-commerce website');
            });

            $message = 'Thanks for your enquiry. we will get back to you soon';
            Session::flash('success_message', $message);
            return redirect()->back();

        }

        return view('front.pages.contact');
    }



}
