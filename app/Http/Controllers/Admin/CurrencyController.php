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

    public function adminAddEditCurrency() {

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
}
