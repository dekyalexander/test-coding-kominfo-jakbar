<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenModel extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'id',
        'title',
        'description',
    ];
}
