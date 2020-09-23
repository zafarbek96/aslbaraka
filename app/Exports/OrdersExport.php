<?php

namespace App\Exports;
use App\Product;
use App\Buy;
use App\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{

    protected $id;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($id)
    {
        $this->id = $id ;

    }

    public function view(): View
    {

        $buy = Buy::find($this->id);
        $orders = Order::where('buy_id', $buy->id)->get();

        return view('excel.orders', [
            'orders' => $orders
        ]);
    }
}
