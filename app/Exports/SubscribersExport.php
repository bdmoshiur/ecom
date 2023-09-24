<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\NewsletterSubscriber;

class SubscribersExport implements WithHeadings,FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $newsletterSubscribersData = NewsletterSubscriber::select('id', 'email', 'created_at')->where('status',1)->orderBy('id','DESC')->get();
        return $newsletterSubscribersData;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Email',
            'Subscribed on'
        ];
    }
}
