<?php

namespace App\Http\Controllers;
use App\Incentive;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use DB;  
use Mail;
use PDF;

class IncentiveController extends Controller
{
    public function add_incentive(){

        $role = Auth::user()->role;
        $users = \DB::table('users')  
            ->Select('users.id', 'users.first_name','users.last_name' )
            ->where('users.is_approved', '1') 
            ->get();   
        if($role == 'admin'){ 
            return view('admin.incentive.add_incentive')
            ->with('users', $users);
        }elseif($role == 'executive'){
            return view('executive.incentive.add_incentive')
            ->with('users', $users);
        }else{
            return redirect()->back();
        }
    }

    public function create_incentive(Request $request)
    {
        $role = Auth::user()->role;
        $inc_obj = \DB::table('incentives')  
                    ->where('incentives.status', 'open')
                    ->Where('incentives.user_id', $request->input('user_id'))->first();
        
        if($inc_obj == null) {
            
            $inc_obj = Incentive::create([
            'user_id' => $request->input('user_id'),
            'incentive_percentage' => $request->input('incentive_percentage'),
            'amount' => $request->input('amount'), 
            'status' => 'open',
            'date' => now(),
        ]);

        $notification = array(
            'message' => 'Add SucessFully', 
            'alert-type' => 'success'
        ); 
            if($role == 'admin'){ 
                return redirect('admin/incentive_list')->with($notification);
            }elseif($role == 'executive'){
                return redirect('executive/incentive_list')->with($notification);
            }else{
                return redirect()->back();
            }
         
        }else{
            $notification = array(
                'message' => 'Duplicate Entry', 
                'alert-type' => 'error'
            ); 
            if($role == 'admin'){ 
                return redirect('admin/add_incentive')->with($notification);
            }elseif($role == 'executive'){
                return redirect('executive/add_incentive')->with($notification);
            }else{
                return redirect()->back();
            }
        }           
            
    }

    public function incentive_list()
    {
        $role = Auth::user()->role;
          
        $incentive_list = \DB::table('incentives')
                    ->leftjoin('users', 'users.id', '=', 'incentives.user_id')
                    ->Select('incentives.incentive_percentage','incentives.amount', 'users.first_name','users.last_name', 'incentives.id')
                    ->where('incentives.status', 'open')
                    ->get();
        
        $data['incentive_list'] = $incentive_list;

        if($role == 'admin'){ 
            return view('admin.incentive.incentive_list')->with($data);
        }elseif($role == 'executive'){
            return view('executive.incentive.incentive_list')->with($data);
        }else{
            return redirect()->back();
        }
        
         
    }

    public function delete_incentive($id)
    {
        $role = Auth::user()->role;
        $delete_banners = DB::select("update incentives 
                                     set status = 'close'
                                     where id = '".$id."' ");
        $notification = array('message' => 'Delete SucessFully', 
                             'alert-type' => 'success' );
        if($role == 'admin'){ 
            return redirect()->route('incentive_list')->with($notification);
        }elseif($role == 'executive'){
            return redirect()->route('incentive_list')->with($notification);
        }else{
            return redirect()->back();
        } 
    }

    public function update_incentive($id)
    { 
        $role = Auth::user()->role;
        $edit_incentive = Incentive::find($id); 
        $users = \DB::table('users')  
            ->Select('users.id', 'users.first_name','users.last_name' )
            ->where('users.is_approved', '1') 
            ->get(); 
        if($role == 'admin'){ 
            return view('admin.incentive.edit_incentive') 
           ->with('edit_incentive', $edit_incentive)
           ->with('users', $users);
        }elseif($role == 'executive'){
            return view('executive.incentive.edit_incentive') 
            ->with('edit_incentive', $edit_incentive)
            ->with('users', $users);
        }else{
            return redirect()->back();
        }

        
    }

    public function complete_incentive(Request $request, $id)
    {
        $role = Auth::user()->role;
        $user_id = Auth::user()->id;  
        DB::table('incentives')->where('id', $id)
                                    ->update(['user_id' => $request->input('user_id'),
                                    'incentive_percentage' => $request->input('incentive_percentage'),
                                    'amount' => $request->input('amount'), 
                                    'status' => 'open',
                                    'date' => now()]);
       
        
        $notification = array(
            'message' => 'Update SucessFully', 
            'alert-type' => 'success'
        );

        if($role == 'admin'){ 
            return redirect('admin/incentive_list')->with($notification);
        }elseif($role == 'executive'){
            return redirect('executive/incentive_list')->with($notification);
        }else{
            return redirect()->back();
        }
 
    }
    
    public function incentive_report()
    {
        $role = Auth::user()->role;
        $data['page_title'] = "All Student";
        $data['page_description'] = "Welcome to Admin Dashboard";
        if($role == 'admin'){
            return view('admin.incentive.report.incentive_report')->with($data);
        }elseif($role == 'executive'){
            return redirect('executive.incentive.report.incentive_report')->with($notification);
        }else{
            return redirect()->back();
        }
        
    }


    public function incentive_reporting(Request $request)
    {
        $role = Auth::user()->role;
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
       
        $incentive_report = DB::select("SELECT us.first_name, us.last_name,incen.incentive_percentage,incen.amount, FORMAT(sum(dn.rupees), 0) as total, 
                          (CASE WHEN sum(dn.rupees) >incen.amount THEN FORMAT(sum(dn.rupees)*incen.incentive_percentage/100, 0) ELSE 0 END) percentage 
                          from donations dn INNER join incentives incen on dn.user_id = incen.user_id 
                          INNER join users us on dn.user_id = us.id and incen.user_id = us.id 
                          where dn.enter_date between '".$from_date."'  And  '".$to_date."'
                          group by us.first_name, us.last_name,incen.incentive_percentage, incen.amount ");
       
        $data['incentive_report'] = $incentive_report;
        if($role == 'admin'){
            return view('admin.incentive.report.report1')->with($data)
            ->with( 'from_date', $from_date)
            ->with('to_date', $to_date);
        }elseif($role == 'executive'){
            return view('executive.incentive.report.report1')->with($data)->with( 'from_date', $from_date)->with('to_date', $to_date);
        }else{
            return redirect()->back();
        }
    }
    
   
    
    //Report 2
    
    public function collection_report()
    {
        $role = Auth::user()->role;
        $data['page_title'] = "All Student";
        $data['page_description'] = "Welcome to Admin Dashboard";
        if($role == 'admin'){
            return view('admin.incentive.report.collection_report')->with($data);
        }elseif($role == 'executive'){
            return redirect('executive.incentive.report.collection_report')->with($notification);
        }else{
            return redirect()->back();
        }
        
    }


    public function collection_reporting(Request $request)
    {
        $role = Auth::user()->role;
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
       
        $collection_report = DB::select(" select dn.receipt,dn.enter_date, cm.name, (CASE WHEN us.id = '34' THEN FORMAT(dn.rupees,0) else 0 end) as saima,
                            (CASE WHEN us.id = '35' THEN FORMAT(dn.rupees,0) else 0 end) as Sami,
                            (CASE WHEN us.id = '36' THEN FORMAT(dn.rupees,0) else 0 end) as Saqib,
                            (CASE WHEN us.id = '37' THEN FORMAT(dn.rupees,0) else 0 end) as Zeeshan,
                            (CASE WHEN us.id = '38' THEN FORMAT(dn.rupees,0) else 0 end) as Babar,
                            (CASE WHEN us.id = '39' THEN FORMAT(dn.rupees,0) else 0 end) as Javeria,
                            (CASE WHEN us.id = '40' THEN FORMAT(dn.rupees,0) else 0 end) as Asif,
                            (CASE WHEN us.id = '41' THEN FORMAT(dn.rupees,0) else 0 end) as Luqman from donations dn
                            inner join customers cm on dn.name = cm.id
                            inner join users us on dn.user_id = us.id
                            where cm.status = '1'
                            and dn.enter_date between '".$from_date."'  And  '".$to_date."'
                            and dn.status = 'Complete' ");
       
        $data['collection_report'] = $collection_report;
        if($role == 'admin'){
            return view('admin.incentive.report.report2')->with($data)->with( 'from_date', $from_date)->with('to_date', $to_date);
        }elseif($role == 'executive'){
            return view('executive.incentive.report.report2')->with($data)->with( 'from_date', $from_date)->with('to_date', $to_date);
        }else{
            return redirect()->back();
        }
    }
}
