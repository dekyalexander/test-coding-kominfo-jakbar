<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DokumenModel;

use Illuminate\Support\Facades\Auth;

use DataTables;

use Hash;

use App\Exports\DocumentExport;

use Maatwebsite\Excel\Facades\Excel;

class DokumenController extends Controller
{
    public function index(Request $request){

        $role = Auth::user()->role_id;

        if($role == 1){

        if ($request->ajax()) {
  
            $data = DokumenModel::latest()->get();
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editDocument">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteDocument">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        
            return view('superadmin.content.document');
           
        }else{
            if ($request->ajax()) {
  
                $data = DokumenModel::latest()->get();
      
                return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function($row){
       
                               $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editDocument">Edit</a>';
       
                               $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteDocument">Delete</a>';
    
        
                                return $btn;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }
            
            return view('pegawai.content.document');
        }
        
    }

    public function store(Request $request)
    {
        DokumenModel::updateOrCreate([
                    'id' => $request->doc_id
                ],
                [
                    'title' => $request->title, 
                    'description' => $request->description,
                ]);        
     
        return response()->json(['success'=>'Document saved successfully.']);
    }
    
    public function edit($id)
    {
        $document = DokumenModel::find($id);
        return response()->json($document);
    }
    
    
    public function destroy($id)
    {
        DokumenModel::find($id)->delete();
      
        return response()->json(['success'=>'Document deleted successfully.']);
    }
    

    public function export() 
    {
        return Excel::download(new DocumentExport, 'document.xlsx');
    }
}
