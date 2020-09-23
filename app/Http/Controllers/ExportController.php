<?php

namespace App\Http\Controllers;
use App\Exports\OrdersExport;
use App\Product;
use App\Buy;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    public function export(Request $request, $id)
    {
        return Excel::download(new OrdersExport($id), 'orders.xlsx');
    }
}
