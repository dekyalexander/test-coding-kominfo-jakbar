<?php

namespace App\Repository\MRCRepository;

use App\Models\MRCModel;

class MRCRepository extends Repository
{
    public function data($mrcid, $devstyleprojectname, $dateofassesment){
        try {
            $mrc = MRCModel::all();
            return response()->json($mrc);
        } catch (\Exception $e) {
           return response()->json(['erorr','Data Tidak Ditemukan / Eksekusi Data Gagal Dilakukan']);
        }
    }
}