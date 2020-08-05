<?php

namespace App\Http\Controllers;

use App\Student_Detail;
use App\Student_Bus_Fare;
use App\Remaining_Bus_Fee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use DB; 

class AddStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_student()
    {
        $data['page_title'] = "Create Student";
        $data['page_description'] = "Welcome to Admin Dashboard";
        $st_route = \DB::table('routes')->get();
        return view('admin.add_student')->with($data)->with('st_route', $st_route);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $this->validate($request, [
            'image_path'  => 'required|mimes:doc,docx,pdf,jpeg,jpg,png|max:2048'
           ]);
        $image_path = $request->file('image_path');
 
        $new_name = rand() . '.' . $image_path->getClientOriginalExtension();
        if(Student_Detail::create([
            'st_name' => $request->input('st_name'),
            'father_name' => $request->input('father_name'),
            'email' => $request->input('email'),
            'roll_no' => $request->input('roll_no'),
            'st_class' => $request->input('st_class'),
            'route' => $request->input('route'),
            'address' => $request->input('address'),
            'st_phone_no' => $request->input('st_phone_no'),
            'father_phone_no' => $request->input('father_phone_no'),
            'image_path' => $image_path->move(('images'), $new_name),
        ])){
            return redirect('admin/add_student');
        }
    }

    public function update($id)
    {
        $view_studenty_detail = Student_Detail::find($id);
        $st_route = \DB::table('routes')->get();
        return view('admin.update_student')
        ->with('view_studenty_detail', $view_studenty_detail)
        ->with('st_route', $st_route);
    }

    public function update_record(Request $request, $id)
    {
        
            $update_zm_case = DB::table('student_details')->where('id', $id)
                            ->update(['st_name'=> $request->input('st_name'),
                                      'father_name'=> $request->input('father_name'),
                                      'email'=> $request->input('email'),
                                      'roll_no'=> $request->input('roll_no'),
                                      'st_class'=> $request->input('st_class'),
                                      'route'=> $request->input('route'),
                                      'address'=> $request->input('address'),
                                      'st_phone_no'=> $request->input('st_phone_no'),
                                      'father_phone_no'=> $request->input('father_phone_no'),]);
        
       
        return redirect("admin/student_list");
        
    }

    public function student_list()
    {
        $data['page_title'] = "All Student";
        $data['page_description'] = "Welcome to Admin Dashboard";
        
        $st_detail = \DB::table('student_details')->get();
        
        $data['st_detail'] = $st_detail;
        return view('admin.student_list')->with($data);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view_student($id)
    {
        $view_studenty_detail = Student_Detail::find($id);
        return view('admin.view_student_detail')
        ->with('view_studenty_detail', $view_studenty_detail);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_bus_fare()
    {
        $st_route = \DB::table('routes')->get();
        return view('admin.add_bus_fare')->with('st_route', $st_route);
    }
    

    public function show(Request $request)
    {
        
        
        
        $st_case = \DB::table('student_details')
        ->where('route', $request->input('route'))->get();
     
        return response()->json($st_case);
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store_bus_fare(Request $request)
    {

        
            // (Student_Bus_Fare::create([
            //     'student_detail_id' => $request->input('student_detail_id'),
            //     'bus_fare' => $request->input('bus_fare'),
            //     'pay_day' => $request->input('pay_day'),
            //     'remarks' => $request->input('remarks'),
            //     'remaining' => $request->input('remaining'),
            // ]));
            // (Remaining_Bus_Fee::create([
            //     'arrears' => $request->input('remaining'),
            //     'student_detail_id' => $request->input('student_detail_id'),
            //     'date' => $request->input('pay_day'),
            // ]));
            $sd_id = Student_Bus_Fare::create([
                'student_detail_id' => $request->input('student_detail_id'),
                'bus_fare' => $request->input('bus_fare'),
                'pay_day' => $request->input('pay_day'),
                'remarks' => $request->input('remarks'),
                'remaining' => $request->input('remaining'),
            ]);
            $fee_id = $sd_id->id;
            //dd($request->input('remaining'));
            $remaining_buss_fee = new Remaining_Bus_Fee;
            $remaining_buss_fee->arrears = $request->input('remaining');
            $remaining_buss_fee->student_detail_id = $request->input('student_detail_id');
            $remaining_buss_fee->date = $request->input('pay_day');
            $remaining_buss_fee->bus_fares_id  = $fee_id;
            $remaining_buss_fee->save();

      
        
        return redirect('admin/show_bus_fare');
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function monthly_report(Request $request)
    {
        //dd($request);
        $role = Auth::user()->role; 
        $data['page_title'] = "All Student";
        $data['page_description'] = "Welcome to Admin Dashboard";
        
        $st_route = \DB::table('routes')->get();
        if($role == 'admin'){ 
           return view('admin.monthwise_detail_report')->with('st_route', $st_route);
        }
        elseif($role == 'uper'){ 
           return view('upper_management.monthwise_detail_report')->with('st_route', $st_route);
        }
        else{
            return redirect()->back();
        }
        //return view('admin.monthwise_detail_report')->with('st_route', $st_route);
    }

    public function student_monthwise_report(Request $request)
    {
        $role = Auth::user()->role; 
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $route = $request->input('routes');
        //dd($route);
        $user_monthwise_reportrs = DB::select("select sd.st_name, sd.address, sd.roll_no, sd.st_class,
        sd.route, 
        sum(CASE WHEN sbf.pay_day between '2019-01-01' and '2019-01-31' THEN sbf.bus_fare ELSE 0 END) AS Jan_19, 
        sum(CASE WHEN sbf.pay_day between '2019-01-01' and '2019-01-31' THEN sbf.remaining ELSE 0 END) AS Jan_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-02-01' and '2019-02-28' THEN sbf.bus_fare ELSE 0 END) AS Feb_19,
        sum(CASE WHEN sbf.pay_day between '2019-02-01' and '2019-02-28' THEN sbf.remaining ELSE 0 END) AS Feb_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-03-01' and '2019-03-31' THEN sbf.bus_fare ELSE 0 END) AS March_19,
        sum(CASE WHEN sbf.pay_day between '2019-03-01' and '2019-03-31' THEN sbf.remaining ELSE 0 END) AS March_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-04-01' and '2019-04-30' THEN sbf.bus_fare ELSE 0 END) AS April_19,
        sum(CASE WHEN sbf.pay_day between '2019-04-01' and '2019-04-30' THEN sbf.remaining ELSE 0 END) AS April_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-05-01' and '2019-05-31' THEN sbf.bus_fare ELSE 0 END) AS May_19, 
        sum(CASE WHEN sbf.pay_day between '2019-05-01' and '2019-05-31' THEN sbf.remaining ELSE 0 END) AS May_19_rem, 
        sum(CASE WHEN sbf.pay_day between '2019-06-01' and '2019-06-30' THEN sbf.bus_fare ELSE 0 END) AS June_19,
        sum(CASE WHEN sbf.pay_day between '2019-06-01' and '2019-06-30' THEN sbf.remaining ELSE 0 END) AS June_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-07-01' and '2019-07-31' THEN sbf.bus_fare ELSE 0 END) AS July_19,
        sum(CASE WHEN sbf.pay_day between '2019-07-01' and '2019-07-31' THEN sbf.remaining ELSE 0 END) AS July_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-08-01' and '2019-08-31' THEN sbf.bus_fare ELSE 0 END) AS Aug_19,
        sum(CASE WHEN sbf.pay_day between '2019-08-01' and '2019-08-31' THEN sbf.remaining ELSE 0 END) AS Aug_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-09-01' and '2019-09-30' THEN sbf.bus_fare ELSE 0 END) AS Sep_19, 
        sum(CASE WHEN sbf.pay_day between '2019-09-01' and '2019-09-30' THEN sbf.remaining ELSE 0 END) AS Sep_19_rem, 
        sum(CASE WHEN sbf.pay_day between '2019-10-01' and '2019-10-31' THEN sbf.bus_fare ELSE 0 END) AS Oct_19,
        sum(CASE WHEN sbf.pay_day between '2019-10-01' and '2019-10-31' THEN sbf.remaining ELSE 0 END) AS Oct_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-11-01' and '2019-11-30' THEN sbf.bus_fare ELSE 0 END) AS Nov_19,
        sum(CASE WHEN sbf.pay_day between '2019-11-01' and '2019-11-30' THEN sbf.remaining ELSE 0 END) AS Nov_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-12-01' and '2019-12-31' THEN sbf.bus_fare ELSE 0 END) AS Dec_19,
        sum(CASE WHEN sbf.pay_day between '2019-12-01' and '2019-12-31' THEN sbf.remaining ELSE 0 END) AS Dec_19_rem
        from student_bus_fares sbf 
        left JOIN student_details sd on sbf.student_detail_id = sd.id
        where sbf.pay_day between  '".$from_date."'  And  '".$to_date."'
        and sd.route = '".$route."'
        group by sd.st_name, sd.address, sd.roll_no, sd.st_class, sd.route");
        //dd($user_monthwise_reportrs);
        $data['user_monthwise_reportrs'] = $user_monthwise_reportrs;
        if($role == 'admin'){
            return view('admin.report1')->with($data);
        }
        elseif($role == 'uper'){
            return view('upper_management.report1')->with($data);
        }
        else{
            return redirect()->back();
        }
        // return view('admin.report1')->with($data);
    }

    public function monthly_report_by_student(Request $request)
    {
        //dd($request);
        
        $data['page_title'] = "All Student";
        $data['page_description'] = "Welcome to Admin Dashboard";
        
        $st_route = \DB::table('routes')->get();
        return view('admin.monthly_report_by_student')->with('st_route', $st_route);
    }

    public function student_detail_report(Request $request)
    {
        //dd($request);
        $st_name = $request->input('st_name');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
       //dd($st_name);
        $student_detail_report = DB::select("select sd.st_name, sd.address, sd.roll_no, 
        sd.st_class,sd.image_path, sd.route, 
        sum(CASE WHEN sbf.pay_day between '2019-01-01' and '2019-01-31' THEN sbf.bus_fare ELSE 0 END) AS Jan_19, 
        sum(CASE WHEN sbf.pay_day between '2019-01-01' and '2019-01-31' THEN sbf.remaining ELSE 0 END) AS Jan_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-02-01' and '2019-02-28' THEN sbf.bus_fare ELSE 0 END) AS Feb_19,
        sum(CASE WHEN sbf.pay_day between '2019-02-01' and '2019-02-28' THEN sbf.remaining ELSE 0 END) AS Feb_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-03-01' and '2019-03-31' THEN sbf.bus_fare ELSE 0 END) AS March_19,
        sum(CASE WHEN sbf.pay_day between '2019-03-01' and '2019-03-31' THEN sbf.remaining ELSE 0 END) AS March_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-04-01' and '2019-04-30' THEN sbf.bus_fare ELSE 0 END) AS April_19,
        sum(CASE WHEN sbf.pay_day between '2019-04-01' and '2019-04-30' THEN sbf.remaining ELSE 0 END) AS April_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-05-01' and '2019-05-31' THEN sbf.bus_fare ELSE 0 END) AS May_19, 
        sum(CASE WHEN sbf.pay_day between '2019-05-01' and '2019-05-31' THEN sbf.remaining ELSE 0 END) AS May_19_rem, 
        sum(CASE WHEN sbf.pay_day between '2019-06-01' and '2019-06-30' THEN sbf.bus_fare ELSE 0 END) AS June_19,
        sum(CASE WHEN sbf.pay_day between '2019-06-01' and '2019-06-30' THEN sbf.remaining ELSE 0 END) AS June_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-07-01' and '2019-07-31' THEN sbf.bus_fare ELSE 0 END) AS July_19,
        sum(CASE WHEN sbf.pay_day between '2019-07-01' and '2019-07-31' THEN sbf.remaining ELSE 0 END) AS July_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-08-01' and '2019-08-31' THEN sbf.bus_fare ELSE 0 END) AS Aug_19,
        sum(CASE WHEN sbf.pay_day between '2019-08-01' and '2019-08-31' THEN sbf.remaining ELSE 0 END) AS Aug_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-09-01' and '2019-09-30' THEN sbf.bus_fare ELSE 0 END) AS Sep_19, 
        sum(CASE WHEN sbf.pay_day between '2019-09-01' and '2019-09-30' THEN sbf.remaining ELSE 0 END) AS Sep_19_rem, 
        sum(CASE WHEN sbf.pay_day between '2019-10-01' and '2019-10-31' THEN sbf.bus_fare ELSE 0 END) AS Oct_19,
        sum(CASE WHEN sbf.pay_day between '2019-10-01' and '2019-10-31' THEN sbf.remaining ELSE 0 END) AS Oct_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-11-01' and '2019-11-30' THEN sbf.bus_fare ELSE 0 END) AS Nov_19,
        sum(CASE WHEN sbf.pay_day between '2019-11-01' and '2019-11-30' THEN sbf.remaining ELSE 0 END) AS Nov_19_rem,
        sum(CASE WHEN sbf.pay_day between '2019-12-01' and '2019-12-31' THEN sbf.bus_fare ELSE 0 END) AS Dec_19,
        sum(CASE WHEN sbf.pay_day between '2019-12-01' and '2019-12-31' THEN sbf.remaining ELSE 0 END) AS Dec_19_rem
        from student_bus_fares sbf 
        left JOIN student_details sd on sbf.student_detail_id = sd.id
        where sbf.pay_day between  '".$from_date."'  And  '".$to_date."'
        and sd.st_name = '".$st_name."'
        group by sd.st_name, sd.address, sd.roll_no, sd.st_class, sd.image_path, sd.route");
        //dd($student_detail_report);
        $data['student_detail_report'] = $student_detail_report;
        return view('admin.report2')->with($data);
    }

    public function bus_fare_list()
    {
        $bus_fare_list = DB::select("Select sbf.id,sbf.pay_day, sd.st_name, sd.roll_no, sd.route, sbf.bus_fare, sbf.remarks,
        sbf.remaining
         from student_bus_fares sbf
        inner join student_details sd on sbf.student_detail_id = sd.id 
        order by 1 Desc");
        
        return view('admin.bus_fare_list')->with('bus_fare_list', $bus_fare_list);
    }

    public function generatePDF($id)
    {
        
        $bus_fare_record = Student_Bus_Fare::find($id);
        
        $student_detail = \DB::table('student_details')->where('id', $bus_fare_record->student_detail_id)->get();
        
       
        $pdf = PDF::loadView('admin/pdf_report', ['bus_fare_record'  => $bus_fare_record,
                                                  'student_detail'  => $student_detail]);    
        //dd($pdf);

        return $pdf->download('alitour.pdf');
        
    }

    public function remaining_fee(Request $request)
    {
        
        
        
        $remain_fee = \DB::table('remaining_bus_fees')
        ->whereMonth('date', '=', Carbon::now()->subMonth()->month)
        ->where('student_detail_id', $request->input('student_detail_id'))->get();
        
        return response()->json($remain_fee);
    }
    
    public function delete_fee($id)
    {
        //dd($id);
        $bus_fare_listss = DB::select("delete sbf.*, rbf.* from student_bus_fares sbf
                        inner join remaining_bus_fees rbf on rbf.bus_fares_id = sbf.id
                        where sbf.id = '".$id."' ");
        return redirect()->route('bus_fare_list');
    }
    
    // public function fgf()
    // {
    //     //return Excel::download(new UsersExport, 'users.xlsx');
    //  $student_data = DB::table('student_details')->get()->toArray();
    //  $student_array[] = array('Name', 'Address', 'Roll No', 'Class');
    //  foreach($student_data as $student)
    //  {
    //   $student_array[] = array(
    //    'Student Name'  => $student->st_name,
    //    'Address'   => $student->address,
    //    'Roll No'   => $student->roll_no,
    //    'Class'    => $student->st_class
    //   );
    //  }
    //  //return Excel::download($student_array, 'users.xlsx');
    //  Excel::download('Student Data', function($excel) use ($student_array){
    //   $excel->setTitle('Student Data');
    //   $excel->sheet('Student Data', function($sheet) use ($student_array){
    //    $sheet->fromArray($student_array);
    //   });
    //  })->download('xlsx');
    // }
}
