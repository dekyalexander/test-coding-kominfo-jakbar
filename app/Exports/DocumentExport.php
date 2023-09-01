<?php

namespace App\Exports;

use App\Models\DokumenModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DocumentExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return DokumenModel::all();

        return DokumenModel::select("id", "title", "description")->get();
    }

    public function headings(): array
    {
        return ["ID", "Title", "Description"];
    }
}
