<?php

namespace App\Http\Controllers;
use App\Product;
use App\Product_Categorie;
use App\Vendor;
use App\Order_Received;
use App\Product_Location; 
use App\Brand;
use App\Vendor_Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class VendorPaymentController extends Controller
{
    public function show(){
        $role = Auth::user()->role;
        $vendor = \DB::table('vendors')->get(); 
        if($role == 'admin'){
            return view('admin.vendor_payment.vendor_payment')
                                                    ->with('vendor', $vendor);
        }elseif($role == 'clerk1'){
            return view('admin.vendor_payment.vendor_payment')
            ->with('vendor', $vendor);
        }else{
            return redirect()->back();
        } 
    }

     

    public function vendor_pending_payment($id){
        
        $employees = Vendor_Payment::select('*')->where('vendor_id', $id)->where('status', 'Pending')->get(); 
         
         // Fetch all records
         $userData['data'] = $employees;
    
         echo json_encode($userData);
         exit;
      
    }
    public function edit_vendor_payment($id){
        $role = Auth::user()->role;  
        $vendor_record = \DB::table('vendor_payments')
                        ->leftjoin('vendors', 'vendor_payments.vendor_id', '=', 'vendors.id')
                        ->Select('vendors.name', 'vendor_payments.*')
                        ->where('vendor_payments.id', $id)->first();
        
        if($role == 'admin'){
            return view('admin.vendor_payment.edit_vendor_payment')
                    ->with('vendor_record', $vendor_record);
        }elseif($role == 'clerk1'){
            return view('admin.vendor_payment.edit_vendor_payment')
            ->with('vendor_record', $vendor_record);
        }else{
            return redirect()->back();
        } 
         
      
    }

    public function paid_payment(Request $request, $id){
        $role = Auth::user()->role; 
        $date = str_replace('/', '-',$request->input('payment_date') );
        $newDate = date("Y-m-d", strtotime($date));  
        $update_category = DB::table('vendor_payments')->where('id', $id)
                            ->update(['payment'=> $request->input('payment'),
                                      'paid_payment'=> $request->input('paid_payment'),
                                      'remaining_payment'=> $request->input('remaining_payment'),
                                      'payment_type'=> $request->input('payment_type'),
                                      'payment_person'=> $request->input('payment_person'),
                                      'bank_slip_no'=> $request->input('bank_slip_no'),
                                      'status'=>'Complete',
                                      'payment_date'=>$newDate,
                                      'remarks'=>$request->input('remarks')]);
         if($request->input('remaining_payment') == 0){
             
         }else{
            Vendor_Payment::create([ 'payment' => $request->input('remaining_payment'), 
            'vendor_id' => $request->input('vendor_id'),
             'paid_payment' => 0, 
             'remaining_payment' => 0,
             'Payment_type' => '',
             'date' => now(),
             'payment_date'=>now(),
             'status' => 'Pending',
             ]); 
         }
         
        
        if($role == 'admin'){
           return redirect("admin/show");
        }elseif($role == 'clerk1'){
          return redirect("clerk1/show");
        
        }
        else{
            return redirect()->back();
        }
      
    }

    public function vendor_payment_report()
    {
        $role = Auth::user()->role;
        $data['page_title'] = "Add Place Order";
        $vendor = \DB::table('vendors')->get(); 
        if($role == 'admin'){
            return view('admin.vendor_payment.vendor_payment_report')->with($data)->with('vendor', $vendor);
        }elseif($role == 'clerk1'){
            return view('clerk1.vendor_payment.vendor_payment_report')->with($data)->with('vendor', $vendor);
        }
        else{
            return redirect()->back();
        }
        
    }

    public function view_vendor_payment_report(Request $request)
    {
        $role = Auth::user()->role; 

        $date = str_replace('/', '-',$request->input('from_date') );
        $from_date = date("Y-m-d", strtotime($date));

        $dates = str_replace('/', '-',$request->input('to_date') );
        $to_date = date("Y-m-d", strtotime($dates));
        $vendor_id = $request->input('vendor_id');
        $vendor_name = Vendor::find($request->input('vendor_id'));
        $payment_lists = DB::select("select id,payment,paid_payment,remaining_payment,
                        DATE_FORMAT(date, '%d-%m-%Y') as date,
                        DATE_FORMAT(payment_date, '%d-%m-%Y') as payment_date,
                        payment_type,payment_person,bank_slip_no,status from vendor_payments
                        where date BETWEEN '".$from_date."'  And  '".$to_date."'
                        and vendor_id = $vendor_id
                        order by id ASC "); 
        //dd($payment_lists);
        if($role == 'admin'){
            return view('admin.vendor_payment.vendor_payment_report_detail')
            ->with('payment_lists', $payment_lists)
            ->with('vendor_name', $vendor_name);
        }elseif($role == 'clerk1'){
            return view('clerk1.place_order.vendor_payment_report_detail')->with($data);
        }
        else{
            return redirect()->back();
        }
        
    } 
    

}
