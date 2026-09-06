<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class reportController extends Controller
{
    public function report(){
        $todaySale = Order::where('status','paid')->whereDate('paid_at',Carbon::today())->sum('total');
        $todayOrder = Order::where('status','paid')->whereDate('paid_at',Carbon::today())->count();
        $pendingTable = Table::where('is_occupied',1)->count();
        // $monthSale = Order::where('status','paid')->whereYear('paid_at',Carbon::now()->year)->whereMonth('created_at',Carbon::now()->month)->sum('total');
        
        // Monthly Sale
        $monthSales = [];
        for($month = 1;$month<=12;$month++){
            $monthSales[] = Order::where('status','paid')->whereYear('paid_at',Carbon::now()->year)->whereMonth('paid_at',$month)->sum('total');
        }

        // daily sales
        $dailySales = [];
        $startofweek = Carbon::now()->startOfWeek();
        $endofweek = Carbon::now()->endOfWeek();
        for($day = 0;$day<7;$day++){
            $newday = $startofweek->copy()->addDays($day);
            $dailySales[]=Order::where('status','paid')->whereDate('paid_at',$newday)->sum('total');
        }
        // Weekly sales
        $weekSales = [];
        $year = Carbon::now()->year;
        $months = Carbon::now()->month;
        for($week = 1; $week<=5;$week++){
            $startofweekly = Carbon::create($year,$months,1)->addDays(($week-1)*7);
            $endofweekly = $startofweekly->copy()->addDays(6);
            if($endofweekly->month!=$months){
                $endofweekly = Carbon::create($year,$months,1)->endOfMonth();
            }
            $weekSales[] = Order::where('status','paid')->whereBetween('paid_at',[$startofweekly,$endofweekly])->sum('total');
        }
        
        return view('Layout.reports',[
                                    'todaySale'=>$todaySale,'todayOrder'=>$todayOrder,
                                    'dailySales'=>$dailySales,
                                    'pendingTable'=>$pendingTable,
                                    'weekSales'=>$weekSales,
                                    'monthSales'=>$monthSales
                                ]);
    }
}
