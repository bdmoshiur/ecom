<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        Session::put('page', "users");
        $users = User::get();
        return view('admin.users.users',[
            'users' => $users,
        ]);
    }

    public function updateUserStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            User::where('id', $data['user_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'user_id' => $data['user_id']]);
        }
    }

    public function viewUsersCharts() {

        $current_month_users = User::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->count();

        $before_1_month_users = User::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->subMonth(1))
        ->count();

        $before_2_month_users = User::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->subMonth(2))
        ->count();

        $before_3_month_users = User::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->subMonth(3))
        ->count();

        $usersCount = [
          $current_month_users,
           $before_1_month_users,
           $before_2_month_users,
           $before_3_month_users,
        ];
        return view('admin.users.view_users_charts', [
            'usersCount' => $usersCount,
        ]);

    }

    public function viewUsersCountries() {

        $getUsersCountries = User::select('country', DB::raw('count(country) as count'))->groupBy('country')->get()->toArray();

        return view('admin.users.view_users_countries', [
            'getUsersCountries' => $getUsersCountries,
        ]);

    }
    public function exportUsers() {

        return Excel::download(new UsersExport, 'users.xlsx');
    }


}
