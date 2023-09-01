<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\MRCService;

class MRCController extends Controller
{
    public function data(Request $request){
        try {
            $mrcid = $this->$request->input('mrcid');
            $devstyleprojectname = $this->$request->input('devstyleprojectname');
            $dateofassesment = $this->$request->input('devstyleprojectname');
            $mrc = $this->Service->MRCService($mrcid, $devstyleprojectname, $dateofassesment);
            return response()->json($mrc);
        } catch (\Exception $e) {
           return response()->json(['erorr','Data Tidak Ditemukan / Eksekusi Data Gagal Dilakukan']);
        }
    }
}
