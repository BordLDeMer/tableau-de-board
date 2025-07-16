<?php

namespace App\Http\Balance;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function getSalesDifference()
    {
        $salesDifference = DB::select("
            WITH MonthlySales AS (
                SELECT
                    SUM(CASE WHEN sale_date >= DATE_FORMAT(CURRENT_DATE() - INTERVAL 1 MONTH, '%Y-%m-01')
                             AND sale_date < DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01')
                        THEN sale_amount ELSE 0 END) AS sales_last_month,
                    SUM(CASE WHEN sale_date >= DATE_FORMAT(CURRENT_DATE() - INTERVAL 2 MONTH, '%Y-%m-01')
                             AND sale_date < DATE_FORMAT(CURRENT_DATE() - INTERVAL 1 MONTH, '%Y-%m-01')
                        THEN sale_amount ELSE 0 END) AS sales_month_before_last
                FROM sales
            )
            SELECT
                sales_last_month - sales_month_before_last AS sales_difference
            FROM MonthlySales;
        ");

        return view('sales.difference', compact('salesDifference'));
    }
}
