<?php

namespace App\Service\MRCService;

use App\Repository\MRCRepository;

class MRCService extends Service
{
    public function data($mrcid, $devstyleprojectname, $dateofassesment){
        try {
            return $this->Repository->MRCRepository($mrcid, $devstyleprojectname, $dateofassesment);
        } catch (\Exception $e) {
           return response()->json(['erorr','Data Tidak Ditemukan / Eksekusi Data Gagal Dilakukan']);
        }
    }
}
