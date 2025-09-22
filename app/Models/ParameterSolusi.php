<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterSolusi extends Model
{
    use HasFactory;
    protected $table = 'tb_parameter_Solusi';
    protected $fillable = [
                           'header_p1','detail_p1','detail_1_2','bobot_p1',
                           'header_p2','detail_p2_1','detail_p2_2','detail_p2_3','detail_p2_4','bobot_p2'
                          ];
}