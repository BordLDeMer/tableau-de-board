<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function getLastMonthSales()
    {
        $lastMonthSales = DB::select("
            SELECT SUM(sale_amount) AS total_sales_last_month
            FROM sales
            WHERE sale_date >= DATE_FORMAT(CURRENT_DATE() - INTERVAL 1 MONTH, '%Y-%m-01')
            AND sale_date < DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01')
        ");

        return view('sales.last_month', compact('lastMonthSales'));
    }
}
