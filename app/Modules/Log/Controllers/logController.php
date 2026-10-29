<?php

namespace App\Modules\Log\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Modules\Log\Models\log;
use Auth;



class logController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function log(Request $request)
    {
        
        $request->user();

      
        if($request->fitur){
            $log = log::where('fitur',$request->fitur)->get();
        } else {
            $log = log::all();

        }
       
        
        return view('log', compact('log'));
     
    }
}


