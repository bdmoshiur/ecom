<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements WithHeadings, FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $usersData = User::select('id', 'name', 'address', 'city', 'state','country','pincode', 'mobile', 'email', 'created_at')->where('status',1)->orderBy('id','DESC')->get();
        return $usersData;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Name',
            'Address',
            'City',
            'State',
            'Country',
            'Pincode',
            'Mobile',
            'Email',
            'Registered on'
        ];
    }
}
