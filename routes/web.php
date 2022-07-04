<?php

use App\Http\Controllers\CustomerController;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/first', function () {
  $employees = collect([
    [
        'name' => 'John',
        'email' => 'john3@example.com',
        'sales' => [
            ['customer' => 'The Blue Rabbit Company', 'order_total' => 7444],
            ['customer' => 'Black Melon', 'order_total' => 1445],
            ['customer' => 'Foggy Toaster', 'order_total' => 700],
        ],
    ],
    [
        'name' => 'Jane',
        'email' => 'jane8@example.com',
        'sales' => [
            ['customer' => 'The Grey Apple Company', 'order_total' => 203],
            ['customer' => 'Yellow Cake', 'order_total' => 8730],
            ['customer' => 'The Piping Bull Company', 'order_total' => 3337],
            ['customer' => 'The Cloudy Dog Company', 'order_total' => 5310],
        ],
    ],
    [
        'name' => 'Dave',
        'email' => 'dave1@example.com',
        'sales' => [
            ['customer' => 'The Acute Toaster Company', 'order_total' => 1091],
            ['customer' => 'Green Mobile', 'order_total' => 2370],
        ],
    ],

]);
$emp = [];

$employees =  $employees->sum(function($item) use(&$emp){
   $sum =  collect($item['sales'])->sum('order_total');
    array_push($emp,['name'=>$item['name'],'email'=>$item['email'],'total_sales'=>$sum]);
});

  return $emp;
});


Route::get('third',function(){
  $scores = collect ([
    ['score' => 76, 'team' => 'A'],
    ['score' => 62, 'team' => 'B'],
    ['score' => 82, 'team' => 'C'],
    ['score' => 86, 'team' => 'D'],
    ['score' => 91, 'team' => 'E'],
    ['score' => 67, 'team' => 'F'],
    ['score' => 67, 'team' => 'G'],
    ['score' => 82, 'team' => 'H'],
]);

$scores = $scores->toArray();
$score_point = array_column($scores, 'score');

$finalScores = [];
$iteration =1;

array_multisort($scores, SORT_DESC, $score_point);
$scores = collect($scores);

$scores->groupBy('score')->map((function($team) use(&$finalScores,&$iteration){
 
  array_map(function($team) use(&$iteration,&$finalScores){
    array_push($finalScores,['team'=>$team['team'],'score'=>$team['score'],'rank'=>$iteration]);
  },$team->toArray());
  
  $iteration++;

}));
return $finalScores;
});

// * Write controllers to find the first customer who spent more money on orders &
//  the first customer who has highest number of orders.
Route::get('huge-money',[CustomerController::class,'hugeMoney']);
Route::get('number-orders',[CustomerController::class,'numberOfOrders']);