<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    //
    public function displayUser()
    {
        $data = User::all();
        return view('admin.data-user',compact(['data']));
    }

    public function displayUserDatatable(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select(['user_id', 'fullname', 'jeniskelamin', 'tanggallahir', 'alamat', 'roles', 'email', 'nomortelepon']);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($user){
     
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.data-user');
    }
    
}
