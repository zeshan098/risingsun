<?php

namespace App\Http\Controllers;
use App\Donate;
use App\SMS;
use App\Customer;
use App\Customer_Log;

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


class DonationsController extends Controller
{
    public function donation()
    {
        $role = Auth::user()->role;
        $user_id = Auth::user()->id;
        $invoice = new Donate();
        $lastInvoiceID = $invoice->orderBy('id', 'DESC')->pluck('id')->first(); 
        $newInvoiceID = $lastInvoiceID + 1; 
        $invoice_date = date("Ymd"); 
        $new_date = date("d-m-Y"); 
        if($role == 'admin'){ 
            $users = \DB::table('users')  
            ->Select('users.id', 'users.first_name','users.last_name' )
            ->where('users.is_approved', '1') 
            ->get();
        }
        else{
            $users = \DB::table('users')  
                ->Select('users.id', 'users.first_name','users.last_name' )
                ->where('users.is_approved', '1')
                ->where('users.id', $user_id)
                ->get();
        }
        
        $user2 = \DB::table('users')  
            ->Select('users.id', 'users.first_name','users.last_name' )
            ->where('users.is_approved', '1') 
            ->get();
        $customer_detail = \DB::table('customers')->where('status','1')->get();
        $data['page_title'] = "Create Student";
        $data['page_description'] = "Welcome to Admin Dashboard";   
        if($role == 'admin'){ 
            return view('admin.donation.add_donation')
            ->with('invoice_number', str_pad($newInvoiceID, 7, "0", STR_PAD_LEFT))
            ->with('invoice_date', $invoice_date )
            ->with('customer_detail', $customer_detail)
            ->with('new_date', $new_date )
            ->with('users', $users)
            ->with('user2', $user2)
            ->with($data);
        }elseif($role == 'executive'){
            return view('executive.donation.add_donation')
            ->with('invoice_number', str_pad($newInvoiceID, 7, "0", STR_PAD_LEFT))
            ->with('invoice_date', $invoice_date )
            ->with('customer_detail', $customer_detail)
            ->with('new_date', $new_date )
            ->with('users', $users)
            ->with('user2', $user2)
            ->with($data);
        }else{
            return redirect()->back();
        }
       
    }
    public function donation_submit(Request $request)
    { 
        $role_ph = Auth::user()->phone_no;
        $telnumber= $request->input('phone_no'); 
        if(preg_match('/^((?:00|\+)92)?(0?3(?:[0-46]\d|55)\d{7})$/', $telnumber) or $telnumber == '') 
        {
            Donate::create([
                'receipt' => $request->input('receipt'),
                'enter_date' => date('Y-m-d', strtotime($request->input('enter_date'))),
                'name' => $request->input('name'),
                'cust_name' => $request->input('cust_name'),
                'address' => $request->input('address'),
                'phone_no' => $request->input('phone_no'),
                'alt_phone_no' => $request->input('alt_phone_no'),
                'email' => $request->input('email'),
                'donar_status' => $request->input('donar_status'), 
                'amount_type' => $request->input('amount_type'),
                'payment_type' => $request->input('payment_type'),
                'rupees' => $request->input('rupees'),
                'currency' => $request->input('currency'),
                'sum_of_rupees' => $request->input('sum_of_rupees'),
                'draft_no' => $request->input('draft_no'),
                'draft_date' => $request->input('draft_date') ? date('Y-m-d', strtotime($request->input('draft_date'))) : $request->input('draft_date'),
                'drawn_on' => $request->input('drawn_on'),
                'sponser_child' => $request->input('sponser_child'),
                'donation_type' => $request->input('donation_type'),
                'no_of_children' => $request->input('no_of_children'),
                'from_date' => $request->input('from_date') ? date('Y-m-d', strtotime($request->input('from_date'))) : $request->input('from_date'), 
                'to_date' => $request->input('to_date') ? date('Y-m-d', strtotime($request->input('to_date'))) : $request->input('to_date'), 
                'remarks' => $request->input('remarks'),
                'refer_by' => $request->input('refer_by'),
                'assign_to' => $request->input('assign_to'),
                'user_id' => Auth::user()->id,
                'creation_date' => now(),
                'status' => 'Save'
                 
            ]);
            $refer_phone_number = \DB::table('users')  
                                    ->Select('users.phone_no' )
                                    ->where('users.id', $request->input('refer_by')) 
                                    ->first();
            
            $assign_phone_number = \DB::table('users')  
                                    ->Select('users.phone_no' )
                                    ->where('users.id', $request->input('assign_to')) 
                                    ->first(); 
            $donor_name = \DB::table('customers')  
                                    ->Select('customers.name', 'customers.address' )
                                    ->where('customers.id', $request->input('name')) 
                                    ->first();
        
            return response()->json(['success'=>'Form is successfully submitted!']);
            // $str = ltrim($role_ph, '0'); 
            // $phone = '92'.$str;
            // $phone_number = $phone;

            // $str1 = ltrim($refer_phone_number->phone_no, '0'); 
            // $phone1 = '92'.$str1;
            // $phone_number1 = $phone1; 
            // $str2 = ltrim($assign_phone_number->phone_no, '0'); 
            // $phone2 = '92'.$str2;
            // $phone_number2 = $phone2; 
            // // return response()->json($phone_number);
            // return $this->assign_sms($request->input('cust_name'), $request->input('address'),$request->input('receipt'),$phone_number,$request->input('rupees'),$phone_number1, $phone_number2, $request->input('phone_no') );
        } else 
        {
            return response()->json(['error'=>'Please Enter Correct Number(03*********)']);
        } 
        

        
    }
    
    
    

    public function assign_sms($donor_name, $donor_address,$receipt,$phone_no,$rupees, $phone1,$phone2, $cust_phone_no)
    { 
        
         error_reporting(E_ALL);
         $type = "xml";
         $id = "rchrisingsunsc";
         $pass = "nuvenene";
         $lang = "English";
         $mask = "Rising Sun";
         $date = date("d-m-y H:i:s");
         $to = $phone1;
         $to1 = $phone2;
         $to2 = '923362227908';
         $to3 = $phone_no;
         $message = "This Track Id ".$receipt." has been assigned to you for ".$donor_name.",".$cust_phone_no." and ".$donor_address; 
         $message = urldecode($message);  
         $message1 = "This Track Id ".$receipt." has been assigned to you for ".$donor_name.",".$cust_phone_no." and ".$donor_address; 
         $message1 = urldecode($message1);
         $message2 = "This Track Id ".$receipt." has been assigned to you for ".$donor_name.",".$cust_phone_no." and ".$donor_address; 
         $message2 = urldecode($message2);
         $message3 = "This Track Id ".$receipt." has been assigned to you for ".$donor_name.",".$cust_phone_no." and ".$donor_address; 
         $message3 = urldecode($message2);
         $data = "id=".$id."&pass=".$pass."&msg=".$message."&to=".$to."&lang=".$lang."&mask=".$mask."&type=".$type;   
         $data1 = "id=".$id."&pass=".$pass."&msg=".$message1."&to=".$to1."&lang=".$lang."&mask=".$mask."&type=".$type;  
         $data2 = "id=".$id."&pass=".$pass."&msg=".$message2."&to=".$to2."&lang=".$lang."&mask=".$mask."&type=".$type; 
         $data3 = "id=".$id."&pass=".$pass."&msg=".$message3."&to=".$to3."&lang=".$lang."&mask=".$mask."&type=".$type; 
    
        
        $ch = curl_init('http://www.outreach.pk/api/sendsms.php/sendsms/url');
        curl_setopt_array($ch, array(  CURLOPT_RETURNTRANSFER =>true,
                                        CURLOPT_POST => true, 
                                        CURLOPT_POSTFIELDS => $data,
                                        ));

        // curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        // curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);

        $output = curl_exec($ch);

        if(curl_errno($ch)){
            echo 'error :'. curl_error($ch);
        }
        curl_close($ch);
        
        $ch1 = curl_init('http://www.outreach.pk/api/sendsms.php/sendsms/url');
        curl_setopt_array($ch1, array(  CURLOPT_RETURNTRANSFER =>true,
                                        CURLOPT_POST => true, 
                                        CURLOPT_POSTFIELDS => $data1,
                                        ));

        // curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        // curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);

        $output1 = curl_exec($ch1);

        if(curl_errno($ch1)){
            echo 'error :'. curl_error($ch1);
        }
        curl_close($ch1);
        
        $ch2 = curl_init('http://www.outreach.pk/api/sendsms.php/sendsms/url');
        curl_setopt_array($ch2, array(  CURLOPT_RETURNTRANSFER =>true,
                                        CURLOPT_POST => true, 
                                        CURLOPT_POSTFIELDS => $data2,
                                        ));

        // curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        // curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);

        $output2 = curl_exec($ch2);

        if(curl_errno($ch2)){
            echo 'error :'. curl_error($ch2);
        }
        curl_close($ch2);
        
        
        $ch3 = curl_init('http://www.outreach.pk/api/sendsms.php/sendsms/url');
        curl_setopt_array($ch3, array(  CURLOPT_RETURNTRANSFER =>true,
                                        CURLOPT_POST => true, 
                                        CURLOPT_POSTFIELDS => $data3,
                                        ));

        // curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        // curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);

        $output3 = curl_exec($ch3);

        if(curl_errno($ch3)){
            echo 'error :'. curl_error($ch3);
        }
        curl_close($ch3);
        
        return response()->json(['success'=>'Form is successfully submitted!']);
    }
    
    
    public function show_donation()
    { 
        $role = Auth::user()->role;
        $user_id = Auth::user()->id;
        

        if($role == 'admin'){ 
            $show_donation = \DB::table('donations')
            ->leftjoin('users', 'users.id', '=', 'donations.user_id')
            ->leftjoin('customers', 'customers.id', '=', 'donations.name')
            ->Select('donations.id', 'donations.receipt','donations.enter_date','donations.name',
             'donations.rupees', 'users.first_name', 'customers.name as custname',
             'donations.phone_no','donations.payment_type','donations.amount_type',  'donations.donation_type',
             'donations.status' ) 
            ->where('donations.status', 'Complete')
            ->get();
            $data['show_donation'] = $show_donation;
             return view('admin.donation.show_donation')->with($data);
        }elseif($role == 'executive'){
            $show_donation = \DB::table('donations')
            ->leftjoin('users', 'users.id', '=', 'donations.user_id')
            ->leftjoin('customers', 'customers.id', '=', 'donations.name')
            ->Select('donations.id', 'donations.receipt','donations.enter_date','donations.name',
             'donations.rupees', 'users.first_name', 'customers.name as custname',
             'donations.phone_no','donations.payment_type','donations.amount_type',  'donations.donation_type',
             'donations.status' )
            ->where('donations.status', 'Complete')
            ->where('user_id', $user_id)
            ->get();
            $data['show_donation'] = $show_donation;
            return view('executive.donation.show_donation')->with($data);
        }else{
            return redirect()->back();
        }
        

    }
    
    public function assign_list()
    { 
        $role = Auth::user()->role;
        $user_id = Auth::user()->id;
        

        if($role == 'admin'){ 
            $assign_list = DB::select(" SELECT dn.id, dn.receipt,dn.enter_date,dn.name,dn.rupees, us.first_name, dn.cust_name as custname,
                        dn.phone_no,dn.payment_type,dn.amount_type,  dn.donation_type,
                        dn.status FROM  donations dn 
                        left join customers cs on cs.id = dn.name
                        left join users us on us.id = dn.user_id
                        WHERE  dn.status = 'Save' " );
            $data['assign_list'] = $assign_list;
             return view('admin.donation.assign_list')->with($data);
        }elseif($role == 'executive'){ 
            $assign_list = DB::select(" SELECT dn.id, dn.receipt,dn.enter_date,dn.name,dn.rupees, us.first_name, dn.cust_name as custname,
                        dn.phone_no,dn.payment_type,dn.amount_type,  dn.donation_type,
                        dn.status FROM  donations dn 
                        left join customers cs on cs.id = dn.name
                        left join users us on us.id = dn.user_id
                        WHERE (dn.user_id = $user_id and dn.status = 'Save') or (dn.assign_to = $user_id and dn.status = 'Save') " );
            $data['assign_list'] = $assign_list; 
            return view('executive.donation.assign_list')->with($data);
        }else{
            return redirect()->back();
        }
        

    }

    public function edit_donation($id){
        $role = Auth::user()->role;
        $user_id = Auth::user()->id;
        
        if($role == 'admin'){ 
            $users = \DB::table('users')  
            ->Select('users.id', 'users.first_name','users.last_name' )
            ->where('users.is_approved', '1') 
            ->get();
        }
        else{
            $users = \DB::table('users')  
                ->Select('users.id', 'users.first_name','users.last_name' )
                ->where('users.is_approved', '1')
                ->where('users.id', $user_id)
                ->get();
        }
        $user2 = \DB::table('users')  
            ->Select('users.id', 'users.first_name','users.last_name' )
            ->where('users.is_approved', '1') 
            ->get();
        $customer_detail = \DB::table('customers')->where('status','1')->get();
        $edit_donation = \DB::table('donations')
            ->leftjoin('users', 'users.id', '=', 'donations.user_id')
            ->leftjoin('customers', 'customers.id', '=', 'donations.name')
            ->Select('donations.*',  'customers.name as custname'  )
            ->where('donations.status', 'Save')
            ->where('donations.id', $id)
            ->first();
         
        if($role == 'admin'){
            return view('admin.donation.edit_donation')
            ->with('edit_donation', $edit_donation)
            ->with('customer_detail', $customer_detail) 
            ->with('users', $users)
            ->with('user2', $user2);
        } 
        elseif($role == 'executive'){
            return view('executive.donation.edit_donation')
            ->with('edit_donation', $edit_donation)
            ->with('customer_detail', $customer_detail) 
            ->with('users', $users)
            ->with('user2', $user2);
        }else{
            return redirect()->back();
        }
    }
    
    public function view_donation($id){
        $role = Auth::user()->role;
        // $view_donation = Donate::find($id);
        $view_donation = \DB::table('donations')
            ->leftjoin('users', 'users.id', '=', 'donations.user_id')
            ->leftjoin('customers', 'customers.id', '=', 'donations.name')
            ->Select('donations.*',  'customers.name as custname'  ) 
            ->where('donations.id', $id)
            ->first();
        // dd($view_donation); 
        if($role == 'admin'){
            return view('admin.donation.view_donation')
            ->with('view_donation', $view_donation);
        } 
        elseif($role == 'executive'){
            return view('executive.donation.view_donation')
            ->with('view_donation', $view_donation);
        }else{
            return redirect()->back();
        }
    }
    
    
    // public function update_donation(Request $request, $id)
    // {
    //     $role = Auth::user()->role;
    //     DB::table('donations')->where('id', $id)
    //                         ->update([
    //                         'name' => $request->input('name'),
    //                         'address' => $request->input('address'),
    //                         'phone_no' => $request->input('phone_no'),
    //                         'alt_phone_no' => $request->input('alt_phone_no'),
    //                         'email' => $request->input('email'),
    //                         'donar_status' => $request->input('donar_status'), 
    //                         'amount_type' => $request->input('amount_type'),
    //                         'payment_type' => $request->input('payment_type'),
    //                         'rupees' => $request->input('rupees'),
    //                         'sum_of_rupees' => $request->input('sum_of_rupees'),
    //                         'draft_no' => $request->input('draft_no'),
    //                         'draft_date' => $request->input('draft_date'),
    //                         'drawn_on' => $request->input('drawn_on'),
    //                         'sponser_child' => $request->input('sponser_child'),
    //                         'donation_type' => $request->input('donation_type'),
    //                         'no_of_children' => $request->input('no_of_children'),
    //                         'from_date' => $request->input('from_date'), 
    //                         'to_date' => $request->input('to_date'), 
    //                         'remarks' => $request->input('remarks'),
    //                         'refer_by' => $request->input('refer_by'),
    //                         'assign_to' => $request->input('assign_to'),
    //                         'update_by' => Auth::user()->id,
    //                         'update_date' => now(),
    //                         'status' => 'Complete']);
    //     // $notification = array('message' => 'Update SucessFully', 'alert-type' => 'success' );
    //         $str = ltrim($request->input('phone_no'), '0'); 
    //         $phone = '92'.$str;
    //         $phone_number = $phone;
    //         // return $this->send_sms($phone_number, $request->input('name'), $request->input('rupees'),$request->input('amount_type'),$request->input('donation_type'), $request->input('draft_date'), $request->input('draft_no'), $request->input('drawn_on'));
    //     if($role == 'admin'){ 
    //         return redirect()->route('show_donation')->with($notification);
    //     }elseif($role == 'executive'){
    //         return redirect()->route('executive.show_donation')->with($notification);
    //     }else{
    //         return redirect()->back();
    //     } 
    // }
    
    
    public function update_donation(Request $request, $id)
    {
        $role = Auth::user()->role; 
        if(isset($_POST["submits"])){ 
            DB::table('donations')->where('id', $id)
                            ->update([
                            'name' => $request->input('name'),
                            'cust_name' => $request->input('cust_name'),
                            'address' => $request->input('address'),
                            'phone_no' => $request->input('phone_no'),
                            'alt_phone_no' => $request->input('alt_phone_no'),
                            'email' => $request->input('email'),
                            'donar_status' => $request->input('donar_status'), 
                            'amount_type' => $request->input('amount_type'),
                            'payment_type' => $request->input('payment_type'),
                            'rupees' => $request->input('rupees'),
                            'currency' => $request->input('currency'),
                            'sum_of_rupees' => $request->input('sum_of_rupees'),
                            'draft_no' => $request->input('draft_no'),
                            'draft_date' => $request->input('draft_date'),
                            'drawn_on' => $request->input('drawn_on'),
                            'sponser_child' => $request->input('sponser_child'),
                            'donation_type' => $request->input('donation_type'),
                            'no_of_children' => $request->input('no_of_children'),
                            'from_date' => $request->input('from_date'), 
                            'to_date' => $request->input('to_date'), 
                            'remarks' => $request->input('remarks'),
                            'refer_by' => $request->input('refer_by'),
                            'assign_to' => $request->input('assign_to'),
                            'update_by' => Auth::user()->id,
                            'update_date' => now(),
                            'status' => 'Complete']);
            $notification = array('message' => 'Update SucessFully', 'alert-type' => 'success' );
            // $str = ltrim($request->input('phone_no'), '0'); 
            // $phone = '92'.$str;
            // $phone_number = $phone;
            // return $this->send_sms($phone_number, $request->input('name'), $request->input('rupees'),$request->input('amount_type'),$request->input('donation_type'), $request->input('draft_date'), $request->input('draft_no'), $request->input('drawn_on'));
        }else if(isset($_POST["save"])){
            // dd("Zeshan1");
            DB::table('donations')->where('id', $id)
                            ->update([
                            'name' => $request->input('name'),
                            'cust_name' => $request->input('cust_name'),
                            'address' => $request->input('address'),
                            'phone_no' => $request->input('phone_no'),
                            'alt_phone_no' => $request->input('alt_phone_no'),
                            'email' => $request->input('email'),
                            'donar_status' => $request->input('donar_status'), 
                            'amount_type' => $request->input('amount_type'),
                            'payment_type' => $request->input('payment_type'),
                            'rupees' => $request->input('rupees'),
                            'currency' => $request->input('currency'),
                            'sum_of_rupees' => $request->input('sum_of_rupees'),
                            'draft_no' => $request->input('draft_no'),
                            'draft_date' => $request->input('draft_date'),
                            'drawn_on' => $request->input('drawn_on'),
                            'sponser_child' => $request->input('sponser_child'),
                            'donation_type' => $request->input('donation_type'),
                            'no_of_children' => $request->input('no_of_children'),
                            'from_date' => $request->input('from_date'), 
                            'to_date' => $request->input('to_date'), 
                            'remarks' => $request->input('remarks'),
                            'refer_by' => $request->input('refer_by'),
                            'assign_to' => $request->input('assign_to'),
                            'update_by' => Auth::user()->id,
                            'update_date' => now(),
                            'status' => 'Save']);
        $notification = array('message' => 'Save SucessFully', 'alert-type' => 'success' );
         
            
        }
         
        if($role == 'admin'){  
            return redirect()->route('assign_list')->with($notification);
        }elseif($role == 'executive'){ 
            return redirect()->route('executive.assign_list')->with($notification);
        }else{
            return redirect()->back();
        } 
    }
    
    
    public function send_sms($phone, $name, $rupees, $amount_type, $donation_type, $dated, $draft_no, $drown_on)
    { 
         $role = Auth::user()->role;
         error_reporting(E_ALL);
         $type = "xml";
         $id = "rchrisingsunsc";
         $pass = "nuvenene";
         $lang = "English";
         $mask = "Rising Sun";
         $date = date("d-m-y H:i:s");
         $to = $phone;
         
         if($amount_type == 'Cash'){
            $message = \DB::table('smscreations')->where('donation_type', $donation_type)
                        ->where('payment_type', $amount_type)
                        ->where('status', '1')->first();
            $replaced = Str::replaceArray('Rs', ['Rs '. $rupees], $message->sms_text); 
            $message = urldecode($replaced);  
            $data = "id=".$id."&pass=".$pass."&msg=".$message."&to=".$to."&lang=".$lang."&mask=".$mask."&type=".$type; 
            
            $to1 = "923331211038";   
            $data1 = "id=".$id."&pass=".$pass."&msg=".$message."&to=".$to1."&lang=".$lang."&mask=".$mask."&type=".$type;
            
            $to2 = "923362227908";  
            $data2 = "id=".$id."&pass=".$pass."&msg=".$message."&to=".$to2."&lang=".$lang."&mask=".$mask."&type=".$type; 
             
         }else if($amount_type == 'Cheque'){
            $message = \DB::table('smscreations')->where('donation_type', $donation_type)
                        ->where('payment_type', $amount_type)
                        ->where('status', '1')->first(); 
            $replace = ['Rs' => 'Rs '.$rupees,'dated' => 'Dated '.$dated, '#' => '# '.$draft_no, 'Name----'=>$drown_on];   
            $replaced =  str_replace(array_keys($replace), $replace, $message->sms_text);
            $message = urldecode($replaced);  
            $data = "id=".$id."&pass=".$pass."&msg=".$message."&to=".$to."&lang=".$lang."&mask=".$mask."&type=".$type; 
            
            $to1 = "923331211038";   
            $data1 = "id=".$id."&pass=".$pass."&msg=".$message."&to=".$to1."&lang=".$lang."&mask=".$mask."&type=".$type;
            
            $to2 = "923362227908";  
            $data2 = "id=".$id."&pass=".$pass."&msg=".$message."&to=".$to2."&lang=".$lang."&mask=".$mask."&type=".$type; 
         }else{
            $replaced = "This Type of SMS is not avaible in System Please add this.";
            $message = urldecode($replaced); 
            $to1 = "923331211038";   
            $data1 = "id=".$id."&pass=".$pass."&msg=".$message."&to=".$to1."&lang=".$lang."&mask=".$mask."&type=".$type;
            
            $to2 = "923362227908";  
            $data2 = "id=".$id."&pass=".$pass."&msg=".$message."&to=".$to2."&lang=".$lang."&mask=".$mask."&type=".$type; 
         }
         
         
        
         $ch = curl_init('http://www.outreach.pk/api/sendsms.php/sendsms/url');
         curl_setopt_array($ch, array(  CURLOPT_RETURNTRANSFER =>true,
                                        CURLOPT_POST => true, 
                                        CURLOPT_POSTFIELDS => $data,
                                        ));

            
    
        
         $ch1 = curl_init('http://www.outreach.pk/api/sendsms.php/sendsms/url');
         curl_setopt_array($ch1, array(  CURLOPT_RETURNTRANSFER =>true,
                                        CURLOPT_POST => true, 
                                        CURLOPT_POSTFIELDS => $data1,
                                        ));
         
              
    
        
         $ch2 = curl_init('http://www.outreach.pk/api/sendsms.php/sendsms/url');
         curl_setopt_array($ch2, array(  CURLOPT_RETURNTRANSFER =>true,
                                        CURLOPT_POST => true, 
                                        CURLOPT_POSTFIELDS => $data2,
                                        ));
                                        
                                        
         $output = curl_exec($ch);

         if(curl_errno($ch)){
            echo 'error :'. curl_error($ch);
         }
         curl_close($ch);
         
         

         

         $output1 = curl_exec($ch1);

         if(curl_errno($ch1)){
            echo 'error :'. curl_error($ch1);
         }
         curl_close($ch1);
          

         $output2 = curl_exec($ch2);

         if(curl_errno($ch2)){
            echo 'error :'. curl_error($ch2);
         }
         curl_close($ch2);
        $notification = array(
            'message' => 'Update SucessFully', 
            'alert-type' => 'success'
        ); 
        if($role == 'admin'){ 
            return redirect()->route('show_donation')->with($notification);
        }elseif($role == 'executive'){
            return redirect()->route('executive.show_donation')->with($notification);
        }else{
            return redirect()->back();
        } 
    }
    
    public function generatePDF($id)
    {
        
        // $donation_record = Donate::find($id);
        $donation_record = \DB::table('donations')
            ->leftjoin('users', 'users.id', '=', 'donations.user_id')
            ->leftjoin('customers', 'customers.id', '=', 'donations.name')
            ->Select('donations.*',  'customers.name as custname'  )
            ->where('donations.status', 'Complete')
            ->where('donations.id', $id)
            ->first();
         
        // dd($donation_record);
        $pdf = PDF::loadView('admin/donation/pdf_report', ['donation_record'  => $donation_record ]);    
        //dd($pdf);

        return $pdf->download('rising_sun.pdf');
        
    }
    
    public function delete_donation($id)
    {
        $role = Auth::user()->role;
        $delete_banners = DB::select("update donations 
                                     set status = 'Delete'
                                     where id = '".$id."' ");
        $notification = array('message' => 'Delete SucessFully', 
                             'alert-type' => 'success' );
        if($role == 'admin'){ 
            return redirect()->route('show_donation')->with($notification);
        }elseif($role == 'executive'){
            return redirect()->route('show_donation')->with($notification);
        }else{
            return redirect()->back();
        } 
    }
    
    public function add_sms()
    { 
        $role = Auth::user()->role;
        $data['page_title'] = "Add banner Info";
        $data['page_description'] = "Welcome to Admin Dashboard"; 
        if($role == 'admin'){ 
            return view('admin.sms.add_sms')->with($data);
        }elseif($role == 'executive'){
            return view('executive.sms.add_sms')->with($data);
        }else{
            return redirect()->back();
        }
        

    }

    public function sms_submit(Request $request)
    {
        $role = Auth::user()->role;
        SMS::create([
            'payment_type' => $request->input('payment_type'),
            'sms_text' => $request->input('sms_text'), 
            'donation_type' => $request->input('donation_type'), 
            'user_id' => Auth::user()->id,
            'date_con' => now(),
            'status' => '1'
        ]);
        $notification = array(
            'message' => 'SMS Add SucessFully', 
            'alert-type' => 'success'
        );
        if($role == 'admin'){ 
            return redirect('admin/add_sms')->with($notification);
        }elseif($role == 'executive'){
            return redirect('executive/add_sms')->with($notification);
        }else{
            return redirect()->back();
        }  
       
    }

    public function sms_list()
    {
        $role = Auth::user()->role;
          
        $sms_list = \DB::table('smscreations')
        ->leftjoin('users', 'users.id', '=', 'smscreations.user_id')
        ->Select('smscreations.payment_type', 'smscreations.sms_text', 'smscreations.donation_type', 'users.first_name', 'smscreations.id')
        ->where('smscreations.status', '1')
        ->get();
        
        $data['sms_list'] = $sms_list;

        if($role == 'admin'){ 
            return view('admin.sms.sms_list')->with($data);
        }elseif($role == 'executive'){
            return view('executive.sms.sms_list')->with($data);
        }else{
            return redirect()->back();
        }
        
         
    }

    public function delete_sms($id)
    {
        $role = Auth::user()->role;
        $delete_banners = DB::select("update smscreations 
                                     set status = '0'
                                     where id = '".$id."' ");
        $notification = array('message' => 'Banner SMS SucessFully', 
                             'alert-type' => 'success' );
        if($role == 'admin'){ 
            return redirect()->route('sms_list')->with($notification);
        }elseif($role == 'executive'){
            return redirect()->route('sms_list')->with($notification);
        }else{
            return redirect()->back();
        } 
    }

    public function update_sms($id)
    { 
        $role = Auth::user()->role;
        $edit_sms = SMS::find($id); 

        if($role == 'admin'){ 
            return view('admin.sms.edit_sms') 
           ->with('edit_sms', $edit_sms);
        }elseif($role == 'executive'){
            return view('executive.sms.edit_sms') 
            ->with('edit_sms', $edit_sms);
        }else{
            return redirect()->back();
        }

        
    }

    public function sms(Request $request, $id)
    {
        $role = Auth::user()->role;
        $user_id = Auth::user()->id;  
        DB::table('smscreations')->where('id', $id)
                                    ->update(['payment_type' => $request->input('payment_type'), 
                                    'donation_type' => $request->input('donation_type'), 
                                    'sms_text' => $request->input('sms_text'), 
                                    'user_id' => $user_id,
                                    'date_con' => now(),
                                    'status' => '1']);
       
        
        $notification = array(
            'message' => 'Update SucessFully', 
            'alert-type' => 'success'
        );

        if($role == 'admin'){ 
            return redirect('admin/sms_list')->with($notification);
        }elseif($role == 'executive'){
            return redirect('executive/sms_list')->with($notification);
        }else{
            return redirect()->back();
        }
 
    }
    
    
    public function customer_add(Request $request)
    {  
        $cust_obj = \DB::table('customers') 
                    ->Select('customers.phone_no')
                    ->where('customers.status', '1')
                    ->Where('customers.phone_no', $request->input('phone_no'))->first();
         
         
        if($cust_obj  == null or $cust_obj->phone_no == null){
            
            $cust_obj = Customer::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone_no' => $request->input('phone_no'),
            'alt_phone_no' => $request->input('alt_phone_no'), 
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'status' => '1',
            'date' => now(),
        ]);
        $cust_log = Customer_Log::create([
            'cust_id' => $cust_obj->id,
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone_no' => $request->input('phone_no'),
            'alt_phone_no' => $request->input('alt_phone_no'), 
            'email' => $request->input('email'), 
            'status' => 'New',
            'user_id' => Auth::user()->id, 
            'date' => now(),
        ]); 
        return response()->json([$cust_obj->id,$cust_obj->name, $cust_obj->address,
                     $cust_obj->phone_no, $cust_obj->email, $cust_obj->alt_phone_no, 'success']); 
        }else{
            
            return response()->json(['error'=>'Duplicate Number']); 
        }           
            
    }
    
    public function search_customer(Request $request)
    {   

        $cust_obj = \DB::table('customers') 
                    ->Select('customers.*')
                    ->where('customers.status', '1')
                    ->Where('customers.id', $request->input('customer_id'))->get();   
        return response()->json($cust_obj);             
    }
    
    public function customer_list()
    {
        $role = Auth::user()->role;
          
        $customer_list = \DB::table('customers') 
                    ->Select('customers.*')
                    ->where('customers.status', '1')
                    ->get();
        
        $data['customer_list'] = $customer_list;

        if($role == 'admin'){ 
            return view('admin.customer.customer_list')->with($data);
        }elseif($role == 'executive'){
            return view('executive.customer.customer_list')->with($data);
        }else{
            return redirect()->back();
        }
        
         
    }

    public function customer_detail($id)
    { 
        $role = Auth::user()->role;
        $edit_customer = Customer::find($id); 

        if($role == 'admin'){ 
            return view('admin.customer.edit_customer') 
           ->with('edit_customer', $edit_customer);
        }elseif($role == 'executive'){
            return view('executive.customer.edit_customer') 
            ->with('edit_customer', $edit_customer);
        }else{
            return redirect()->back();
        }

        
    }
    
    public function update_detail(Request $request, $id)
    {
        $role = Auth::user()->role; 
        DB::table('customers')->where('id', $id)
            ->update(['name' => $request->input('name'), 
            'phone_no' => $request->input('phone_no'), 
            'alt_phone_no' => $request->input('alt_phone_no'),
            'email' => $request->input('email'), 
            'address' => $request->input('address'),   
            'date' => now(),
            'status' => '1']);
            
        $cust_log = Customer_Log::create([
                'cust_id' => $id,
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'phone_no' => $request->input('phone_no'),
                'alt_phone_no' => $request->input('alt_phone_no'), 
                'email' => $request->input('email'), 
                'status' => 'Update',
                'user_id' => Auth::user()->id, 
                'date' => now(),
        ]);  

        $notification = array(
            'message' => 'Update SucessFully', 
            'alert-type' => 'success'
            );
            
        if($role == 'admin'){ 
            return redirect('admin/customer_list')->with($notification);
        }elseif($role == 'executive'){
                return redirect('executive/customer_list')->with($notification);
        }else{
                return redirect()->back();
        }
       
    }
        

        
 
   
    

    // public function update_detail(Request $request, $id)
    // {
    //     $role = Auth::user()->role;
    //     $telnumber= $request->input('phone_no');

    //     if(preg_match('/^((?:00|\+)92)?(0?3(?:[0-46]\d|55)\d{7})$/', $telnumber)){
    //         DB::table('customers')->where('id', $id)
    //         ->update(['name' => $request->input('name'), 
    //         'phone_no' => $request->input('phone_no'), 
    //         'alt_phone_no' => $request->input('alt_phone_no'),
    //         'email' => $request->input('email'), 
    //         'address' => $request->input('address'),   
    //         'date' => now(),
    //         'status' => '1']);
            
    //         $cust_log = Customer_Log::create([
    //             'cust_id' => $id,
    //             'name' => $request->input('name'),
    //             'address' => $request->input('address'),
    //             'phone_no' => $request->input('phone_no'),
    //             'alt_phone_no' => $request->input('alt_phone_no'), 
    //             'email' => $request->input('email'), 
    //             'status' => 'Update',
    //             'user_id' => Auth::user()->id, 
    //             'date' => now(),
    //         ]);  

    //         $notification = array(
    //         'message' => 'Update SucessFully', 
    //         'alert-type' => 'success'
    //         );
    //         if($role == 'admin'){ 
    //         return redirect('admin/customer_list')->with($notification);
    //         }elseif($role == 'executive'){
    //             return redirect('executive/customer_list')->with($notification);
    //         }else{
    //             return redirect()->back();
    //         }
    //     } else{
    //         $notification = array(
    //             'message' => 'Please Enter Correct Number(03*********)', 
    //             'alert-type' => 'error'
    //             );
    //         if($role == 'admin'){ 
    //         return redirect('admin/customer_list')->with($notification);
    //         }elseif($role == 'executive'){
    //             return redirect('executive/customer_list')->with($notification);
    //         }else{
    //             return redirect()->back();
    //         }
    //     }
        

        
 
    // }
    
    public function delete_donor($id)
    {
        
        $role = Auth::user()->role;
        $view_donor_detail = DB::table('customers')->where('id', $id)
                            ->update(['status'=> '0' ]);
        
        $notification = array(
            'message' => 'Delete SucessFully', 
            'alert-type' => 'success'
            );
        $cust_detail = Customer::find($id); 
        $cust_log = Customer_Log::create([
                'cust_id' => $id,
                'name' => $cust_detail->name,
                'address' => $cust_detail->address,
                'phone_no' => $cust_detail->phone_no,
                'alt_phone_no' => $cust_detail->alt_phone_no, 
                'email' => $cust_detail->email, 
                'status' => 'Delete',
                'user_id' => Auth::user()->id, 
                'date' => now(),
            ]);  
            
        if($role == 'admin'){ 
            return redirect('admin/customer_list')->with($notification);
        }elseif($role == 'executive'){
            return redirect('executive/customer_list')->with($notification);
        }else{
            return redirect()->back();
        }
    }
    
   public function add_donar(){

        $role = Auth::user()->role;
           
        if($role == 'admin'){ 
            return view('admin.customer.add_donar');
        }elseif($role == 'executive'){
            return view('executive.customer.add_donar');
        }else{
            return redirect()->back();
        }
    }

 
    
    public function create_donar(Request $request)
    {   
         
        $role = Auth::user()->role;
        $cust_obj = \DB::table('customers') 
                    ->Select('customers.phone_no')
                    ->where('customers.status', '1')
                    ->Where('customers.phone_no', $request->input('phone_no'))->first();
        
         
        if($cust_obj  == null or $cust_obj->phone_no == null){
            $cust_obj = Customer::create([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'phone_no' => $request->input('phone_no'),
                'alt_phone_no' => $request->input('alt_phone_no'), 
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'status' => '1',
                'date' => now(),
          
            ]);
            
            $cust_log = Customer_Log::create([
                'cust_id' => $cust_obj->id,
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'phone_no' => $request->input('phone_no'),
                'alt_phone_no' => $request->input('alt_phone_no'), 
                'email' => $request->input('email'), 
                'status' => 'New',
                'user_id' => Auth::user()->id, 
                'date' => now(),
            ]); 
        
        $notification = array(
            'message' => 'Add SucessFully', 
            'alert-type' => 'success'
        ); 
        
            if($role == 'admin'){ 
                    return redirect('admin/customer_list')->with($notification);
            }elseif($role == 'executive'){
                    return redirect('executive/customer_list')->with($notification);
            }else{
                    return redirect()->back();
            }
         
        }else{
            $notification = array(
            'message' => 'Duplicate Number', 
            'alert-type' => 'error'
        ); 
            return redirect()->back()->with($notification);
        }      
             
                   
            
    }
    
    // public function send_alert(){
    //     $alert_val = DB::select(" SELECT * FROM donations WHERE TO_DAYS(to_date)=To_DAYS(NOW())+3 " );
    //     dd($alert_val);
    // }
    
     
   
}