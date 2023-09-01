<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use DataTables;

use Hash;

class AccountController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
  
            $data = User::latest()->get();
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editUser">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('superadmin.content.account');
    }

    
    public function store(Request $request)
    {
        User::updateOrCreate([
                    'id' => $request->user_id
                ],
                [
                    'name' => $request->name, 
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => $request->role_id,
                ]);        
     
        return response()->json(['success'=>'User saved successfully.']);
    }
    
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }
    
    
    public function destroy($id)
    {
        User::find($id)->delete();
      
        return response()->json(['success'=>'User deleted successfully.']);
    }
}
