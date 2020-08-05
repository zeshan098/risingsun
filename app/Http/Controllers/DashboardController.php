<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Driver;
use App\Oil_Filling;
use App\Booking_Detail;
use App\Car_No;
use App\Driver_Car_Booking_Detail;
use App\Driver_Vehicle_Detail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use DB; 
use Charts;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        $role = Auth::user()->role;
        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Welcome to Admin Dashboard";
        $currentMonth = date('m'); 
        $data = DB::table('oil_fillings')
               ->join('filling_stations','oil_fillings.pump_id','=','filling_stations.id')
              ->select([DB::raw('sum(total) as totalpro'),'date_con'])
               ->where ('filling_stations.id', '=', '6') 
               ->whereRaw('MONTH(date_con) = ?',[$currentMonth])
              ->groupBy('date_con')
              ->get(); 
              
        $data_1 = DB::table('oil_fillings')
               ->join('filling_stations','oil_fillings.pump_id','=','filling_stations.id')
              ->select([DB::raw('sum(total) as totalpro'),'date_con'])
               ->where ('filling_stations.id', '=', '7')
               ->whereRaw('MONTH(date_con) = ?',[$currentMonth])
              ->groupBy('date_con')
              ->get(); 
              
        $data_2 = DB::table('oil_fillings')
               ->join('filling_stations','oil_fillings.pump_id','=','filling_stations.id')
              ->select([DB::raw('sum(total) as totalpro'),'date_con'])
               ->where ('filling_stations.id', '=', '4')
               ->whereRaw('MONTH(date_con) = ?',[$currentMonth])
              ->groupBy('date_con')
              ->get();    
              
        $total_oil = DB::select('select Round(sum(total),0) as total from oil_fillings WHERE MONTH(date_con) = MONTH(CURRENT_DATE()) AND YEAR(date_con) = YEAR(CURRENT_DATE())');
        $no_of_booking = DB::select(" select count(bd.id) as booking from booking_details bd
                                      WHERE MONTH(bd.booking_date) = MONTH(CURRENT_DATE()) AND YEAR(bd.booking_date) = YEAR(CURRENT_DATE())
                                      and bd.is_deleted = 0
                                      and branch_id = '1' "); 
        $cannal_no_of_booking = DB::select(" select count(bd.id) as booking from booking_details bd
                                      WHERE MONTH(bd.booking_date) = MONTH(CURRENT_DATE()) AND YEAR(bd.booking_date) = YEAR(CURRENT_DATE())
                                      and bd.is_deleted = 0
                                      and branch_id = '2' ");
        $total_bookings = DB::select(' SELECT coalesce(Round(Sum(total)),0) as total_booking FROM  booking_details WHERE MONTH(booking_date) = MONTH(CURRENT_DATE()) AND YEAR(booking_date) = YEAR(CURRENT_DATE()) and is_deleted = 0 and branch_id = 1 ');
        $canal_total_bookings = DB::select(' SELECT coalesce(Round(Sum(total)),0) as total_booking FROM  booking_details WHERE MONTH(booking_date) = MONTH(CURRENT_DATE()) AND YEAR(booking_date) = YEAR(CURRENT_DATE()) and is_deleted = 0 and branch_id = 2 ');
        $chart = Charts::create( 'bar', 'highcharts')
                                ->title("Oil Record")
                                ->elementLabel("Afzal Pump")  
                                ->labels($data->pluck('date_con')->all())
                                ->values($data->pluck('totalpro')->all())   
                                ->responsive(true); 
         
        $chart_1 = Charts::create( 'bar', 'highcharts')
                                ->title("Oil Record")
                                ->elementLabel("Malik CNG & Filling Station")  
                                ->labels($data_1->pluck('date_con')->all())
                                ->values($data_1->pluck('totalpro')->all())  
                                ->dimensions(1000, 500)
                                ->responsive(false);
        
        $chart_2 = Charts::create( 'bar', 'highcharts')
                                ->title("Oil Record")
                                ->elementLabel("New Ravi Pump")  
                                ->labels($data_2->pluck('date_con')->all())
                                ->values($data_2->pluck('totalpro')->all())   
                                ->dimensions(1000, 500)
                                ->responsive(false);                          
                                
        $data1 = DB::table('booking_details')
              ->select([DB::raw('sum(total) as totalbalance'),'booking_date' ])
              ->whereRaw('MONTH(booking_date) = ?',[$currentMonth])
              ->where('is_deleted' ,'=', 0)
              ->where('branch_id' ,'=', 1)
              ->groupBy('booking_date')
              ->get();
        
        $data2 = DB::table('booking_details')
              ->select([DB::raw('sum(total) as totalbalance'),'booking_date' ])
              ->whereRaw('MONTH(booking_date) = ?',[$currentMonth])
              ->where('is_deleted' ,'=', 0)
              ->where('branch_id' ,'=', 2)
              ->groupBy('booking_date')
              ->get();
              
        $book_chart = Charts::create( 'bar', 'highcharts')
              ->title("Booking Record")
              ->elementLabel("Total Booking")  
              ->labels($data1->pluck('booking_date')->all())
              ->values($data1->pluck('totalbalance')->all())   
              ->responsive(true); 
        
        $book_chart_2 = Charts::create( 'bar', 'highcharts')
              ->title("Booking Record")
              ->elementLabel("Total Booking")  
              ->labels($data2->pluck('booking_date')->all())
              ->values($data2->pluck('totalbalance')->all())   
              ->dimensions(1000, 500)
              ->responsive(false); 
              
        if($role == 'admin'){
        return view('admin.dashboard.dashboard',compact('chart','chart_1','chart_2', 'book_chart', 'book_chart_2'))
                ->with('total_oil', $total_oil)
                ->with('no_of_booking', $no_of_booking)
                ->with('cannal_no_of_booking', $cannal_no_of_booking)
                 ->with('total_bookings', $total_bookings)
                 ->with('canal_total_bookings', $canal_total_bookings);
        }
        elseif($role == 'uper'){
            return view('upper_management.dashboard.dashboard',compact('chart','chart_1','chart_2', 'book_chart', 'book_chart_2'))
            ->with('total_oil', $total_oil)
                ->with('no_of_booking', $no_of_booking)
                ->with('cannal_no_of_booking', $cannal_no_of_booking)
                 ->with('total_bookings', $total_bookings)
                 ->with('canal_total_bookings', $canal_total_bookings);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ss()
    {
        $usersChart = new UserChart;
        $usersChart->labels(['Jan', 'Feb', 'Mar']);
        $usersChart->dataset('Users by trimester', 'line', [10, 25, 13]);
        dd($usersChart);
        return view('users', [ 'usersChart' => $usersChart ] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
