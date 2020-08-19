<?php

namespace App\Http\Controllers;
use App\Product;
use App\Customer;
use App\City;
use App\Product_Location;
use App\Billing;
use App\Statement;
use App\Product_Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class BillingController extends Controller
{

    public function customer_list()
    {
        $role = Auth::user()->role;  
        $city_list = \DB::table('cities')->where('status', '=', '1')->get();
        $customer_list = DB::select(" select cs.id, cs.name as cust_name,cs.company_name as company,
                                        cs.phone_no as ph_num, ct.name as city_name, cs.address as address  from customers cs  
                                        inner join cities ct on cs.city_id = ct.id
                                        where cs.status = '1'
                                        order by cs.name "); 
       
        $notification = array(
            'message' => 'Add Customer Successfully',
            'alert-type' => 'success'
        );
           
        if($role == 'admin'){
            return view('admin.customer.add_customer')
                   ->with('customer_list', $customer_list)
                   ->with('city_list', $city_list); 
        }elseif($role == 'clerk1'){
           return redirect('clerk1/city')->with($notification);
        }
        else{
            return redirect()->back();
        }
    }
    public function delete_customer(Request $request,$id){
        $role = Auth::user()->role; 
        $del_customer = Customer::find($id);
        $del_customer->status = '0';
        $del_customer->save();
        
        $notification = array(
            'message' => 'Delete Successfully',
            'alert-type' => 'success'
        );
       
        if($role == 'admin'){
              return redirect("admin/customer_list")->with($notification);
        }elseif($role == 'clerk1'){
            return redirect("clerk1/customer_list")->with($notification);
        }
        else{
            return redirect()->back();
        }
    }

    public function update_customer($id)
    {   
        $role = Auth::user()->role; 
        $update_customer_detail = Customer::find($id);
        $city = DB::select(" select id,name  from cities  
                                  where status = '1'    "); 
        if($role == 'admin'){
              return view('admin.customer.update_customer')
             ->with('update_customer_detail', $update_customer_detail)
             ->with('city_list', $city);
        }elseif($role == 'clerk1'){
            return view('clerk1.city.update_city')
        ->with('update_customer_detail', $update_customer_detail);
        }
        else{
            return redirect()->back();
        }
       
    }

    public function edit_customer(Request $request, $id){
        $role = Auth::user()->role; 
        $update_customer = DB::table('customers')->where('id', $id)
                            ->update(['name'=> $request->input('name'),
                            'company_name'=> $request->input('company_name'),
                            'phone_no'=> $request->input('phone_no'),
                            'city_id'=> $request->input('city_id'),
                            'address'=> $request->input('address'),
                                   ]);
        
        
        $notification = array(
                                    'message' => 'Update Successfully',
                                    'alert-type' => 'success'
                                );
        if($role == 'admin'){
            return redirect("admin/customer_list")->with($notification);
        }elseif($role == 'clerk1'){
            return redirect("admin/customer_list");
        }
        else{
            return redirect()->back();
        }
        
    }


    public function city()
    {
        $role = Auth::user()->role;
        $data['page_title'] = "Add City";
        $city = \DB::table('cities')
                    ->where('status', '=', '1')          
                    ->get();  
        if($role == 'admin'){
            return view('admin.city.add_city')->with($data)->with('city',$city);
        }elseif($role == 'clerk1'){
          return view('clerk1.city.add_city')->with($data)->with('city',$city);
        
        }
        else{
            return redirect()->back();
        }
        
    }

    
    public function add_city(Request $request)
    {
        $role = Auth::user()->role;  
        City::create([
            'name' => $request->input('name'), 
            'date' => now(),
            'status' => '1',
        ]);
       
        $notification = array(
            'message' => 'Add City Successfully',
            'alert-type' => 'success'
        );
           
        if($role == 'admin'){
             return redirect('admin/city')->with($notification);
        }elseif($role == 'clerk1'){
           return redirect('clerk1/city')->with($notification);
        }
        else{
            return redirect()->back();
        }
    }


    public function update_city($id)
    {   
        $role = Auth::user()->role; 
        $update_city_detail = City::find($id);
        $city = DB::select(" select id,name  from cities  
                                  where status = '1'  
                                  and id = $update_city_detail->id "); 
        if($role == 'admin'){
              return view('admin.city.update_city')
        ->with('update_city_detail', $update_city_detail);
        }elseif($role == 'clerk1'){
            return view('clerk1.city.update_city')
        ->with('update_city_detail', $update_city_detail);
        }
        else{
            return redirect()->back();
        }
       
    }

    public function edit_city(Request $request, $id){
        $role = Auth::user()->role; 
        $update_city = DB::table('cities')->where('id', $id)
                            ->update(['name'=> $request->input('name')
                                   ]);
        
        if($role == 'admin'){
              return redirect("admin/city");
        }elseif($role == 'clerk1'){
            return redirect("clerk1/city");
        }
        else{
            return redirect()->back();
        }
        
    }

    public function delete_city(Request $request,$id){
        $role = Auth::user()->role; 
        $del_city = City::find($id);
        $del_city->status = '0';
        $del_city->save();
        
       
        if($role == 'admin'){
              return redirect("admin/city");
        }elseif($role == 'clerk1'){
            return redirect("clerk1/city");
        }
        else{
            return redirect()->back();
        }
    }

    public function invoice()
    {
        $role = Auth::user()->role;
        $data['page_title'] = "Create Invoice"; 
        $date = now(); 
        $invoice = new Billing();
        $lastInvoiceID = $invoice->orderBy('id', 'DESC')->pluck('id')->first();
        $newInvoiceID = $lastInvoiceID + 1; 
        $product_list = \DB::table('products')
                        ->where('products.status', '=', '1')
                        ->get();  
        $customer_list = \DB::table('customers')
                        ->leftjoin('cities', 'customers.city_id', '=', 'cities.id') 
                        ->Select('customers.id','customers.name', 'customers.company_name', 'cities.name')
                        ->where('customers.status','=', '1')
                        ->OrderBy('customers.name', 'ASC')->get();
        $city_list = \DB::table('cities')->where('status', '=', '1')->get();
        if($role == 'admin'){
            return view('admin.billing.invoice')->with($data)
                                                    ->with('customer_list', $customer_list) 
                                                    ->with('product_list', $product_list)
                                                    ->with('city_list', $city_list)
                                                    ->with('date', $date)
                                                    ->with('invoice_number', $newInvoiceID)
                                                    ->with('bill_num', $lastInvoiceID);
        }elseif($role == 'clerk1'){
             return view('admin.billing.invoice')->with($data)
             ->with('customer_list', $customer_list) 
             ->with('product_list', $product_list)
             ->with('bill_num', $bill_num);
        }else{
            return redirect()->back();
        }
    }

    public function add_customer(Request $request)
    {
         
        Customer::create([
            'name' => $request->input('name'),
            'phone_no' => $request->input('phone_number'),
            'alt_ph_no' => $request->input('alt_ph_no'),
            'company_name' => $request->input('company_name'),
            'address' => $request->input('address'),
            'city_id' => $request->input('city_id'),
            'status' => '1',
            'date' => now() 
        ]); 
        $data = DB::table('customers')->latest('id')->first(); 
        return response()->json(array($data->name, $data->id, $data->company_name),200);
    }

    public function show_product(Request $request)
    {
        
        $products_lists = \DB::table('products')
                        ->leftjoin('order_receiveds', 'products.id', '=', 'order_receiveds.product_id') 
                        ->Select('products.*', 'order_receiveds.rate')
                        ->where('products.id', $request->input('item_name'))
                        ->OrderBy('order_receiveds.rate', 'DESC')->get();

        // $products_lists = \DB::table('products')
        //                 ->leftjoin('order_receiveds', 'products.id', '=', 'order_receiveds.product_id') 
        //                 ->leftjoin('product_locations', 'products.id', '=', 'product_locations.product_id') 
        //                 ->Select('products.*', 'order_receiveds.rate', 'product_locations.quantity as qty')
        //                 ->where('products.id', $request->input('item_name'))
        //                 ->where('product_locations.location', '=', 'WH')
        //                 ->groupBy('order_receiveds.rate')
        //                 ->OrderBy('order_receiveds.rate', 'DESC')->get();
         
        return response()->json($products_lists);
         
    }


    public function get_product_qty(Request $request)
    {
        
        $products_qty = \DB::table('product_locations') 
                        ->Select('quantity')
                        ->where('product_id', $request->input('item_name'))
                        ->where('location', 'WH')->get();
 
         
        return response()->json($products_qty);
         
    }

    public function create_invoice(Request $request){
        
        $role = Auth::user()->role; 
        $product_discount = 0;
        $product_discounted_amount = 0;
        $product_total_value = 0;
        $wh_product_qty = 0;
        $sl_product_qty = 0;

        $originalDate = now();
        $newDate = date("Ymd", strtotime($originalDate));
        $invoice = new Billing();

        $lastInvoiceID = $invoice->orderBy('id', 'DESC')->pluck('id')->first();
        $newInvoiceID = $lastInvoiceID + 1; 

        foreach($request->input('product_id') as $key => $product_id){
            $product_discount += $request->input('discount')[$key];
            $product_discounted_amount += $request->input('discounted_amount')[$key];
            $product_total_value += $request->input('total_value')[$key];

            $wh_product_detail = \DB::table('product_locations')->where('location', '=', 'WH')
                                    ->where('product_id', $request->input('product_id')[$key])                      
                                    ->first();
                 
            $wh_qty = $wh_product_detail->quantity; 
            $wh_product_detail->quantity = (int)$wh_qty - (int)$request->input('qty')[$key];
            DB::table('product_locations')
                    ->where('location', '=', 'WH')
                    ->where('product_id', $request->input('product_id')[$key])
                    ->update(['quantity' => $wh_product_detail->quantity]);

            $sl_product_detail = \DB::table('product_locations')->where('location', '=', 'SL')
                                ->where('product_id', $request->input('product_id')[$key])                      
                                ->first();
 
            $sl_qty = $sl_product_detail->quantity; 
            $sl_product_detail->quantity = (int)$sl_qty + (int)$request->input('qty')[$key];
            DB::table('product_locations')
                ->where('location', '=', 'SL')
                ->where('product_id', $request->input('product_id')[$key])
                ->update(['quantity' => $sl_product_detail->quantity]);
             
        }
        
        $paid = number_format($request->input('paid'), 2, '.', '');//floatval();
        
        $remaining_balance =  $product_discounted_amount - ($paid == null ? 0 : $paid);
        $payment_type = "Cash";
        
        if($paid == null || $paid == 0){
            $payment_type = "Credit";
        }else if($remaining_balance > 0){
            $payment_type = "Partial";
        }
        
        $bill_id = Billing::create([
            'customer_id' => $request->input('customer_id'),
            'bill_number' => $newDate.'-'.$newInvoiceID,
            'date' => now(),
            'total_amount' => $product_total_value,
            'total_discount' => $product_discount,
            'discounted_amount' => $product_discounted_amount,
            'payment_type' => $payment_type,
            'paid' => $paid,
            'remaining_balance' => $remaining_balance,
            'status' => '1' 
        ]); 
        
        $bill_num = $bill_id->id;
        foreach($request->input('product_id') as $key => $product_id){
            $product_sale = new Product_Sale;
                $product_sale->bill_id = $bill_num;
                $product_sale->product_id = $request->input('product_id')[$key];
                $product_sale->qty = $request->input('qty')[$key];
                $product_sale->selling_price = $request->input('selling_price')[$key];
                $product_sale->cost = $request->input('cost')[$key];
                $product_sale->discount = $request->input('discount')[$key];
                $product_sale->discounted_amount =  $request->input('discounted_amount')[$key];
                $product_sale->total_value =  $request->input('total_value')[$key]; 
                $product_sale->save();
        }

        $customer = Customer::find($request->input('customer_id'));

        
        // Debit
        // $debit = $request->input('paid') == null ? 0 : $request->input('paid');
        $debit = $product_discounted_amount;
        // $credit = $remaining_balance;
        $balance = $customer->balance - $debit;
        $statement = Statement::create([
            'type' => "Invoice",
            'document_number' => $newDate.'-'.$newInvoiceID,
            'company_name' => $customer->company_name,
            'debit' => $debit,
            'credit' => '0.00',
            'balance' => $balance,
        ]);

        $customer->balance = $balance;
        $customer->save();

        // Credit
        $credit = $request->input('paid') == null ? 0 : $request->input('paid');
        if($credit > 0){
            $balance = $customer->balance + $credit;
            $statement = Statement::create([
                'type' => "Invoice",
                'document_number' => $newDate.'-'.$newInvoiceID,
                'company_name' => $customer->company_name,
                'debit' => '0.00',
                'credit' => $credit,
                'balance' => $balance,
            ]);
            $customer->balance = $balance;
            $customer->save();
        }

        $notification = array(
            'message' => 'Bill Create Successfully!',
            'alert-type' => 'success'
        ); 
        if($role == 'admin'){
            return redirect('admin/invoice')->with($notification);
        }elseif($role == 'clerk1'){ 
            return  redirect("clerk1/invoice");
        }
        else{
            return redirect()->back();
        }
        
    }

    public function get_invoice(Request $request){
        $invoice_id  =  $request->input('id');
        $total_invoice = \DB::table('billings')
                        ->leftjoin('customers', 'billings.customer_id', '=', 'customers.id') 
                        ->Select('billings.*', 'customers.name','customers.phone_no','customers.address')
                        ->where('billings.status', '=', '1')  
                        ->where('billings.id', '=', $invoice_id)->get();   
         
        return response()->json($total_invoice);
    }

    public function get_product_invoice(Request $request){
        $invoice_id  =  $request->input('id');
        $product_invoice = \DB::table('product_sales')
                    ->leftjoin('products', 'product_sales.product_id', '=', 'products.id')
                    ->Select( 'products.id','products.code','products.product_name', 'product_sales.qty', 'product_sales.selling_price',
                             'product_sales.total_value')
                    ->where('product_sales.bill_id', '=', $invoice_id)->get(); 
         
        return response()->json($product_invoice);
    }

    public function invoice_list(){
        $role = Auth::user()->role; 
        $invoice_list = \DB::table('billings')
                        ->leftjoin('customers', 'billings.customer_id', '=', 'customers.id') 
                        ->Select('billings.*', 'customers.name')
                        ->where('billings.status', '=', '1') 
                        ->OrderBy('billings.id', 'DESC')->get();  
        
        if($role == 'admin'){
            return view('admin.billing.invoice_list')->with('invoice_list', $invoice_list);
        }elseif($role == 'clerk1'){ 
            return  redirect("clerk1/invoice");
        }
        else{
            return redirect()->back();
        }
    }

    public function view_invoice($id){
        $role = Auth::user()->role; 
        $total_invoice = \DB::table('billings')
                        ->leftjoin('customers', 'billings.customer_id', '=', 'customers.id') 
                        ->Select('billings.*', 'customers.name', 'customers.company_name')
                        ->where('billings.status', '=', '1')  
                        ->where('billings.id', '=', $id)->first();
                        
        $product_invoice = \DB::table('product_sales')
                          ->leftjoin('products', 'product_sales.product_id', '=', 'products.id')
                          ->Select('products.product_name','products.code', 'product_sales.*')
                          ->where('product_sales.bill_id', '=', $id)->get(); 
        if($role == 'admin'){
            return view('admin.billing.view_invoice')
                   ->with('total_invoice', $total_invoice)
                   ->with('product_invoice', $product_invoice);
        }elseif($role == 'clerk1'){ 
            return  redirect("clerk1/invoice");
        }
        else{
            return redirect()->back();
        }
    }


    public function delete_invoice(Request $request,$id){
        $role = Auth::user()->role; 
        $del_bill = Billing::find($id);
        $del_bill->status = '0';
        $del_bill->save();
        
       
        if($role == 'admin'){
              return redirect("admin/invoice_list");
        }elseif($role == 'clerk1'){
            return redirect("clerk1/invoice_list");
        }
        else{
            return redirect()->back();
        }
    }

}
