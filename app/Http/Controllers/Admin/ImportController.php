<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use  DB;

class ImportController extends Controller
{
    public function addEditCodPincode(Request $request) {

        if ($request->isMethod('post')) {
            $data = $request->all();

            if ($request->hasFile('file')) {
                if($request->file('file')->isValid()){
                    $file = $request->file('file');
                    $destinetion = public_path('imports/pincodes');
                    $ext = $file->getClientOriginalExtension();
                    $filename = 'pincodes-' . rand() . '.' .$ext;
                    $file->move($destinetion, $filename);
                }
            }

            $file = public_path('/imports/pincodes/' . $filename);

            if (file_exists($file) && is_readable($file)) {
                $pincodes = $this->csvToArray($file);

                $latestPincodes = array();

                foreach ($pincodes as $key => $pincode) {
                    $latestPincodes[$key]['pincode'] = $pincode['pincode'];
                    $latestPincodes[$key]['created_at'] = date('Y-m-d H:i:s');
                    $latestPincodes[$key]['updated_at'] = date('Y-m-d H:i:s');
                }

                DB::table('cod_pincodes')->truncate(); // Remove old data
                DB::table('cod_pincodes')->insert($latestPincodes); // Bulk insert


            $message = "COD Pincode has been replace Successfully";
            Session::flash('success_message', $message);

            return redirect()->back();
            } else {
                return redirect()->back()->with('error_message', 'File not found or not readable');
            }

        }

        return view('admin.pincodes.update_cod_pincode');
    }

    public function csvToArray($filename = '', $delimiter =',' ) {

        if (!file_exists($filename) || !is_readable($filename))

            return false;
            $header = NULL;
            $data = array();

            if (($handle = fopen($filename, 'r')) !== FALSE) {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                    if (!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }

        return $data;
    }
}
