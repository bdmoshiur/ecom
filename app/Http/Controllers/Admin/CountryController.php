<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;
use Illuminate\Support\Facades\Session;

class CountryController extends Controller
{
    public function country()
    {
        Session::put('page', "countrys");
        $countrys = Country::get();

        return view('admin.countrys.countrys',[
            'countrys' => $countrys,
            ]);
    }

    public function updateCountryStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Country::where('id', $data['country_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'country_id' => $data['country_id']]);
        }
    }

    public function addEditcountry( Request $request, $id = null)
    {
        Session::put('page', "countrys");
        if ($id == "") {
            //Add country Functionality
            $title = "Add Country";
            $country = new Country();
            $countrydata = array();
            $message = "Country Added Successfully";
        } else {
            //Edit country Functionality
            $title = "Edit Country";
            $country = Country::find($id);
            $message = "Country Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'country_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'country_code' => 'required',
            ];
            $customMessage = [
                'country_name.required' => 'Country Name is Required',
                'country_name.regex' => 'Valid Country Name is Required',
                'country_code.required' => 'Country Code is Required',
            ];
            $this->validate($request, $rules, $customMessage);

            $country->country_name = $data['country_name'];
            $country->country_code = $data['country_code'];
            $country->save();

            Session::flash('success_message', $message);

            return redirect()->route('admin.country');

        }

        return view('admin.countrys.add_edit_country',[
            'title' => $title,
            'country' => $country,
        ]);
    }

    public function deleteCountry($id)
    {
        $deletecountrys = Country::find($id)->delete();
        Session::flash('success_message', 'Country Deleted Successfully');

        return redirect()->back();
    }
}
