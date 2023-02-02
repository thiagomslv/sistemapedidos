<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $global;

    public function __construct($e){ $this->global = $e;} 

    public function view(): View
    {
        return view('dash.table', [
            'orders' =>  $this->global
        ]);
    }
}
