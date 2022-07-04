<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function hugeMoney()
    {
// * Write controllers to find the first customer who spent more money on orders &
        $result = DB::table('customers')
            ->rightJoin('orders','orders.customerNumber','=','customers.customerNumber')
            ->rightJoin('orderdetails','orderdetails.orderNumber','=','orders.orderNumber')
            ->select(\DB::raw('SUM(orderdetails.quantityOrdered*orderdetails.priceEach) as total  '),'customers.*')
            ->orderByDesc('total')->groupBy('customers.customerNumber')->first();
        return $result;
    }
    public function numberOfOrders()
    {
        $result = DB::table('customers')
        ->rightJoin('orders','orders.customerNumber','=','customers.customerNumber')
        ->select(\DB::raw('count(orders.orderNumber) as number_of_orders'),'customers.*')
        ->orderByDesc('number_of_orders')
        ->groupBy('customers.customerNumber')
        ->first();
        return $result;
    }
}
