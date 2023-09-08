<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Currency;
use Illuminate\Support\Facades\Auth;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function currencies()
    {
        Session::put('page', "currencies");
        $currencies = Currency::get();

        return view('admin.currencies.currencies',[
            'currencies' => $currencies,
        ]);
    }

    public function addEditCurrency( Request $request, $id = null)
    {
        Session::put('page', "currencies");
        if ($id == "") {
            //Add Currency Functionality
            $title = "Add Currency";
            $currency = new Currency();
            $message = "Currency Added Successfully";
        } else {
            //Edit Currency Functionality
            $title = "Edit Currency";
            $currency = Currency::find($id);
            $message = "Currency Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();


            $rules = [
                'currency_code' => 'required|regex:/^[\pL\s\-]+$/u',
                'exchange_rate' => 'required|integer',
            ];
            $customMessage = [
                'currency_code.required' => 'Currency Code Name is Required',
                'currency_code.regex' => 'Valid Currency Code Name is Required',
                'exchange_rate.required' => 'Currency Rate Name is Required',
                'exchange_rate.integer' => 'Valid Currency Rate Name is Required',
            ];
            $this->validate($request, $rules, $customMessage);


            $currency->currency_code = $data['currency_code'];
            $currency->exchange_rate = $data['exchange_rate'];
            $currency->save();

            Session::flash('success_message', $message);
            return redirect()->route('admin.currencies');

        }

        return view('admin.currencies.add_edit_currencies',[
            'title' => $title,
            'currency' => $currency,
        ]);
    }

    public function updatCurrencyStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Currency::where('id', $data['currency_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'currency_id' => $data['currency_id']]);
        }
    }

    public function deleteCurrencies($id)
    {
        $currency = Currency::find($id);
        $currency->delete();
        Session::flash('success_message', 'Currency Deleted Successfully');
        return redirect()->back();
    }
}
