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

class InventoryController extends Controller
{

    public function product()
    {
        $role = Auth::user()->role;
        $data['page_title'] = "Add Driver";
        $category = \DB::table('product_categories')->get(); 
        $brand = \DB::table('brands')->where('status', '=', '1')->get();
        $product_list = DB::select(" select ip.id,ip.product_name as product_name,ip.code as code,
                                        ip.quantity as qty, ip.selling_price as price, pc.name as category,
                                        GROUP_CONCAT(pl.location,'=',pl.quantity) as wh , pb.name as brand
                                        from products ip, product_locations pl, product_categories pc, brands pb 
                                        where ip.status = '1'
                                        and ip.id = pl.product_id 
                                        and ip.category_id = pc.id
                                        and ip.brand_id = pb.id
                                        GROUP by ip.id, product_name, code,qty,price,category, brand
                                        order by ip.id asc");
        if($role == 'admin'){
            return view('admin.product.add_product')->with($data)
                                                    ->with('category', $category)
                                                    ->with('brand', $brand)
                                                    ->with('product_list', $product_list);
        }elseif($role == 'clerk1'){
             return view('clerk1.product.add_product')->with($data)
                                                    ->with('category', $category)
                                                    ->with('product_list', $product_list);
        }else{
            return redirect()->back();
        }
    }

    public function check_code(Request $request)
    {
        $a  =  $request->input('code');
        $code = DB::select(" select code from products 
                   where code = $a ");
        if($code!=[]){
           $response = "<span style='color: red;'>Duplicate Code.</span>";
        }else{
          $response = "<span style='color: green;'>New Code.</span>";
        }
        return response()->json($response);
         
        
    }

    public function add_product(Request $request)
    {
        $role = Auth::user()->role;  
        $product_detail_id = Product::create([
            'code' => $request->input('code'),
            'product_name' => $request->input('product_name'),
            'category_id' => $request->input('category_id'),
            'brand_id' => $request->input('brand_id'),
            'selling_price' => $request->input('selling_price'), 
            'date' => now(), 
            'quantity' => '0',
            'status' => '1',
        ]);
       Product_Location::create([
            'product_id' => $product_detail_id->id,
            'location' => 'WH',
            'quantity' => '0', 
        ]);
        Product_Location::create([
            'product_id' => $product_detail_id->id,
            'location' => 'SL',
            'quantity' => '0', 
        ]);
        $notification = array(
            'message' => 'Add Product Successfully!',
            'alert-type' => 'success'
        );
        if($role == 'admin'){
            return redirect('admin/product')->with($notification);
        }elseif($role == 'clerk1'){
           return redirect('clerk1/product');
        
        }
        else{
            return redirect()->back();
        }
    }

    public function update_product($id)
    {
        $role = Auth::user()->role;
        $view_product_detail = Product::find($id);
        $category = DB::select(" select pc.id, pc.name from product_categories pc
                                  where pc.status = '1'
                                  and pc.id = $view_product_detail->category_id ");
        $categories = \DB::table('product_categories')->get();
        if($role == 'admin'){
        return view('admin.product.update_product_detail')
        ->with('view_product_detail', $view_product_detail)
        ->with('category', $category)
        ->with('categories', $categories);
        }
        elseif($role == 'clerk1'){
           return view('clerk1.product.update_product_detail')
            ->with('view_product_detail', $view_product_detail)
            ->with('category', $category)
            ->with('categories', $categories);
        
        }
    }

    public function edit_product(Request $request, $id){
        $role = Auth::user()->role;
       // dd($role);
        $update_car_number = DB::table('products')->where('id', $id)
                            ->update(['code'=> $request->input('code'),
                                      'product_name'=> $request->input('product_name'),
                                      'category_id'=> $request->input('category_id'),
                                      'selling_price'=> $request->input('selling_price')     ]);
        
        if($role == 'admin'){
            return redirect('admin/product');
        }elseif($role == 'clerk1'){
           return redirect('clerk1/product');
        
        }
        else{
            return redirect()->back();
        }
        
    }
   
    public function delete_product(Request $request,$id){
        $role = Auth::user()->role;
        $del_product = Product::find($id);
        $del_product->status = '0';
        $del_product->save();
        
       
        if($role == 'admin'){
            return redirect('admin/product');
        }elseif($role == 'clerk1'){
           return redirect('clerk1/product');
        
        }
        else{
            return redirect()->back();
        }
    }
    
    public function category()
    {
        $role = Auth::user()->role;
        $data['page_title'] = "Add Category";
        $category = \DB::table('product_categories')->where('status', '=', '1')->get();
        if($role == 'admin'){
            return view('admin.product.add_category')->with($data)->with('category', $category);
        }elseif($role == 'clerk1'){
           return view('clerk1.product.add_category')->with($data)->with('category', $category);
        
        }
        else{
            return redirect()->back();
        }
        
    }

    public function add_category(Request $request)
    {
        Product_Categorie::create([
                'name' => $request->input('category'),
                'date' => now(), 
                'status' => '1', 
            ]);
        $data = DB::table('product_categories')->latest('id')->first(); 
        return response()->json(array($data->id, $data->name),200);
         
        
    }

    public function update_category($id)
    {
        $role = Auth::user()->role; 
        $view_category_detail = Product_Categorie::find($id);
        
       if($role == 'admin'){
           return view('admin.product.update_category_detail')
        ->with('view_category_detail', $view_category_detail);
        }elseif($role == 'clerk1'){
           return view('clerk1.product.update_category_detail')
        ->with('view_category_detail', $view_category_detail);
        
        }
        else{
            return redirect()->back();
        }
        
        
    }

    public function edit_category(Request $request,$id){
        $role = Auth::user()->role; 
        $update_category = DB::table('product_categories')->where('id', $id)
                            ->update(['name'=> $request->input('name')]);
        
        if($role == 'admin'){
           return redirect("admin/category");
        }elseif($role == 'clerk1'){
          return redirect("clerk1/category");
        
        }
        else{
            return redirect()->back();
        }
        
    }
    
    public function delete_category(Request $request,$id){
        $role = Auth::user()->role; 
        $del_category = Product_Categorie::find($id);
        $del_category->status = '0';
        $del_category->save();
        
       if($role == 'admin'){
           return redirect("admin/category");
        }elseif($role == 'clerk1'){
          return redirect("clerk1/category");
        
        }
        else{
            return redirect()->back();
        }
        
    }
    

    //add brand
     
    

    public function add_brand(Request $request)
    {
         
        Brand::create([
            'name' => $request->input('name'),
            'status' => '1', 
        ]);
        $data = DB::table('brands')->latest('id')->first(); 
        return response()->json(array($data->name, $data->id),200);
    }

    //Add Vendor

    public function vendor()
    {
        $role = Auth::user()->role;
        $data['page_title'] = "Add Driver";
        $vendor = \DB::table('vendors')
                    ->where('status', '=', '1')          
                    ->get();  
        if($role == 'admin'){
            return view('admin.vendor.add_vendor')->with($data)->with('vendor',$vendor);
        }elseif($role == 'clerk1'){
          return view('clerk1.vendor.add_vendor')->with($data)->with('vendor',$vendor);
        
        }
        else{
            return redirect()->back();
        }
        
    }

    public function add_vendor(Request $request)
    {
        $role = Auth::user()->role; 
        $date = str_replace('/', '-',$request->input('date') );
        $newDate = date("Y-m-d", strtotime($date));
        Vendor::create([
            'name' => $request->input('name'),
            'phone_no' => $request->input('phone_no'),
            'alt_phone_no' => $request->input('alt_phone_no'),
            'address' => $request->input('address'), 
            'date' => $newDate,
            'status' => '1',
        ]);
       
        $notification = array(
            'message' => 'Add Vendor Successfully',
            'alert-type' => 'success'
        );
           
        if($role == 'admin'){
             return redirect('admin/vendor')->with($notification);
        }elseif($role == 'clerk1'){
           return redirect('clerk1/vendor')->with($notification);
        }
        else{
            return redirect()->back();
        }
    }


    public function update_vendor($id)
    {   
        $role = Auth::user()->role; 
        $update_vendor_detail = Vendor::find($id);
        $vendor = DB::select(" select id,name, phone_no, alt_phone_no, address, date from vendors  
                                  where status = '1'  
                                  and id = $update_vendor_detail->id "); 
        if($role == 'admin'){
              return view('admin.vendor.update_vendor_detail')
        ->with('update_vendor_detail', $update_vendor_detail);
        }elseif($role == 'clerk1'){
            return view('clerk1.vendor.update_vendor_detail')
        ->with('update_vendor_detail', $update_vendor_detail);
        }
        else{
            return redirect()->back();
        }
       
    }

    public function edit_vendor(Request $request, $id){
        $role = Auth::user()->role; 
        $update_vendor = DB::table('vendors')->where('id', $id)
                            ->update(['name'=> $request->input('name'),
                                      'phone_no'=> $request->input('phone_no'),
                                      'alt_phone_no' => $request->input('alt_phone_no'),
                                        'address' => $request->input('address'), 
                                        'date' => $request->input('date')      ]);
        
        if($role == 'admin'){
              return redirect("admin/vendor");
        }elseif($role == 'clerk1'){
            return redirect("clerk1/vendor");
        }
        else{
            return redirect()->back();
        }
        
    }

    public function delete_vendor(Request $request,$id){
        $role = Auth::user()->role; 
        $del_vendor = Vendor::find($id);
        $del_vendor->status = '0';
        $del_vendor->save();
        
       
        if($role == 'admin'){
              return redirect("admin/vendor");
        }elseif($role == 'clerk1'){
            return redirect("clerk1/vendor");
        }
        else{
            return redirect()->back();
        }
    }
    
        //Add Place Order

    public function place_order()
    {
        $role = Auth::user()->role;
        $data['page_title'] = "Add Place Order";
        $product_list = \DB::table('products')->where('status', '=', '1')->get();
        $vendor = \DB::table('vendors')
                    ->where('status', '=', '1')          
                    ->get();  
        if($role == 'admin'){
            return view('admin.place_order.add_qty')->with($data)
            ->with('vendor',$vendor)
            ->with('product_list', $product_list);
        }elseif($role == 'clerk1'){
            return view('clerk1.place_order.add_qty')->with($data)
            ->with('vendor',$vendor)
            ->with('product_list', $product_list);
        }
        else{
            return redirect()->back();
        }
        
    }

    public function add_order_qty(Request $request)
    {
        $role = Auth::user()->role; 
        $data['page_title'] = "Add Qty";
        $payment = 0; 
        $qtys = 0;
        $total = 0;
        foreach($request->input('product_id') as $key => $product_id){
            $order_qty = new Order_Received;
                $order_qty->product_id = $request->input('product_id')[$key];
                $order_qty->vender_id = $request->input('vender_id')[$key];
                $order_qty->rate = $request->input('rate')[$key];
                $order_qty->received_qty = $request->input('received_qty')[$key];
                $order_qty->bill_no = $request->input('bill_no')[$key];
                $order_qty->date =  $request->input('date')[$key];
                $order_qty->status = '1';
                $order_qty->save();

                $product_detail = Product::find($request->input('product_id')[$key]);
                $qty = $product_detail->quantity;
                $product_detail->quantity = (int)$qty + (int)$request->input('received_qty')[$key];
                $product_detail->save();    
                
                $wh_product_detail = \DB::table('product_locations')->where('location', '=', 'WH')
                                    ->where('product_id', $request->input('product_id')[$key])                      
                                    ->first();
                 
                $wh_qty = $wh_product_detail->quantity;
                $wh_product_detail->quantity = (int)$wh_qty + (int)$request->input('received_qty')[$key];
                 
                DB::table('product_locations')
                    ->where('location', '=', 'WH')
                    ->where('product_id', $request->input('product_id')[$key])
                    ->update(['quantity' => $wh_product_detail->quantity]);
                
                $payment +=  $request->input('rate')[$key] * $request->input('received_qty')[$key]; 
                // $qtys += $request->input('received_qty')[$key];
                $vendor = $request->input('vender_id')[$key];
        } 
        
        Vendor_Payment::create([
            'payment' => $payment, 
            'vendor_id' => $vendor,
            'paid_payment' => 0, 
            'remaining_payment' => 0,
            'Payment_type' => '',
            'date' => now(),
            'payment_date' => now(),
            'status' => 'Pending',
        ]); 
        $notification = array(
            'message' => 'Add Quantity Successfully!',
            'alert-type' => 'success'
        );  
        if($role == 'admin'){
            return redirect('admin/place_order')->with($notification);
        }elseif($role == 'clerk1'){
           // dd($role);
            return  redirect("clerk1/place_order");
        }
        else{
            return redirect()->back();
        }
        
    }

    


    public function view_place_order()
    {
        $role = Auth::user()->role;
        $data['page_title'] = "Add Place Order";
         
        if($role == 'admin'){
            return view('admin.place_order.place_order_report')->with($data);
        }elseif($role == 'clerk1'){
            return view('clerk1.place_order.place_order_report')->with($data);
        }
        else{
            return redirect()->back();
        }
        
    }

    public function place_order_report(Request $request)
    {
        $role = Auth::user()->role; 

        $date = str_replace('/', '-',$request->input('from_date') );
        $from_date = date("Y-m-d", strtotime($date));

        $dates = str_replace('/', '-',$request->input('to_date') );
        $to_date = date("Y-m-d", strtotime($dates));

        $product_lists = DB::select("select ip.product_name as product_name, ip.code as code, 
                       vn.name as vendor_name, 
                        po.received_qty as qty,po.rate as cost, po.rate * po.received_qty as total, 
                         po.bill_no, DATE_FORMAT(po.date, '%d-%m-%Y') as date
                        from order_receiveds po
                        inner join vendors vn on po.vender_id = vn.id
                        inner join products ip on po.product_id = ip.id
                        where po.status = '1'
                        and ip.status = '1'
                        and po.date BETWEEN '".$from_date."'  And  '".$to_date."'
                        order by date DESC "); 
         
        $data['product_lists'] = $product_lists;
        
        if($role == 'admin'){
            return view('admin.place_order.view_place_order')->with($data);
        }elseif($role == 'clerk1'){
            return view('clerk1.place_order.view_place_order')->with($data);
        }
        else{
            return redirect()->back();
        }
        
    } 
    
    public function movement()
    {
        $role = Auth::user()->role;
        $data['page_title'] = "Add Place Order";
        $product_list = \DB::table('products')->get(); 
        $driver_list = \DB::table('drivers')->where('staff_type','=','Mechanic')->get();
        $car_list = \DB::table('car_nos')->get();
        if($role == 'admin'){
            return view('admin.movement.product_movement')->with($data) 
            ->with('product_list', $product_list)
            ->with('driver_list', $driver_list)
            ->with('car_list', $car_list);
        }elseif($role == 'clerk1'){
            return view('clerk1.movement.product_movement')->with($data) 
            ->with('product_list', $product_list)
            ->with('driver_list', $driver_list)
            ->with('car_list', $car_list);
        }
        else{
            return redirect()->back();
        }
        
    }

   
    
    
}
