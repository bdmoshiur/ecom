<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Fabric;
use Illuminate\Support\Facades\Session;

class FabricController extends Controller
{
    public function fabric()
    {
        Session::put('page', "fabric");
        $fabrics = Fabric::get();

        return view('admin.fabrics.fabrics',[
            'fabrics' => $fabrics,
            ]);
    }

    public function updateFabricStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Fabric::where('id', $data['fabric_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'fabric_id' => $data['fabric_id']]);
        }
    }

    public function addEditFabric( Request $request, $id = null)
    {
        Session::put('page', "fabric");
        if ($id == "") {
            //Add fabric Functionality
            $title = "Add Fabric";
            $fabric = new Fabric();
            $fabricdata = array();
            $message = "Fabric Added Successfully";
        } else {
            //Edit fabric Functionality
            $title = "Edit Fabric";
            $fabric = Fabric::find($id);
            $message = "Fabric Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'fabric_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'fabric_name.required' => 'fabric Name is Required',
                'fabric_name.regex' => 'Valid fabric Name is Required',
            ];
            $this->validate($request, $rules, $customMessage);

            $fabric->name = $data['fabric_name'];
            $fabric->save();

            Session::flash('success_message', $message);

            return redirect()->route('admin.fabric');
        }

        return view('admin.fabrics.add_edit_fabric',[
            'title' => $title,
            'fabric' => $fabric,
        ]);
    }

    public function deleteFabrics($id)
    {
        $deletefabrics = Fabric::find($id)->delete();
        Session::flash('success_message', 'Fabric Deleted Successfully');

        return redirect()->back();
    }
}
