<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;

class UserController extends Controller
{
    public function index() {
        $data['tasks'] = [
                [
                        'name' => 'Design New Dashboard',
                        'progress' => '87',
                        'color' => 'danger'
                ],
                [
                        'name' => 'Create Home Page',
                        'progress' => '76',
                        'color' => 'warning'
                ],
                [
                        'name' => 'Some Other Task',
                        'progress' => '32',
                        'color' => 'success'
                ],
                [
                        'name' => 'Start Building Website',
                        'progress' => '56',
                        'color' => 'info'
                ],
                [
                        'name' => 'Develop an Awesome Algorithm',
                        'progress' => '10',
                        'color' => 'success'
                ]
        ];
        $data['page_title'] = "Dashboard";
        $data['page_description'] = "Welcome to Admin Dashboard";
        return view('admin.index')->with($data);
    }
    
    public function users(){
        $data['page_title'] = "Users List";
        $data['page_description'] = "Users List";
        $user_record = \DB::table('users')->where("is_deleted", "=" , 0)->where("is_approved", "=" , 1)->get();
        $data['users'] = $user_record;
        return view('admin.users') ->with($data);
    }
    
    public function add_user_view(){
        $data["users"] = array();
        $data['page_title'] = "Add User";
        $data['page_description'] = "Add User";
        return view('admin.add_user')->with($data);
    }

    public function delete_user($id){
        $user_delete_update = User::find($id);
        $user_delete_update->is_deleted = 1;
        $user_delete_update->save();
        return redirect()->route('list_users');
    }
    
    public function add_user_post(Request $request){
        //dd($request);
        $data["users"] = array();
        $data['page_title'] = "Add User";
        $data['page_description'] = "Add User";
        return view('admin.add_user')->with($data);
    }

    public function pending_user(){
        $data['page_title'] = "Pending User";
        $user_record = \DB::table('users')->where("is_deleted", "=" , 0)->where("is_approved", "=" , 0)->get();
        $data['users'] = $user_record;
        return view('admin.pending_user') ->with($data);
    }

    public function update_pending_user($id){
        $pending_user_update = User::find($id);
        $pending_user_update->is_approved = 1;
        $pending_user_update->save();
        return redirect()->route('pending_user');
    }

     //update password
    public function update_password($id){
        $user_pass = User::find($id); 
         
        return view('admin.update_password') 
        ->with('user_pass', $user_pass);
    }
    public function password(Request $request, $id){
        
        if(isset($_POST['submit'])){
            $update_password = DB::table('users')->where('id', $id)
                            ->update(['password'=> Hash::make($request->input('password')) 
                            ]);
        }
        $notification = array(
            'message' => 'Password Update', 
            'alert-type' => 'success'
        );
         
        return redirect('admin/users')->with($notification);
    }
}
