<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterSikap extends Model
{
    use HasFactory;
    protected $table = 'tb_parameter_Sikap';
    protected $fillable = [
                           'header_p1','detail_1_1','detail_1_2','detail_1_3','bobot_p1',
                           'header_p2','detail_2_1','bobot_p2',
                           'header_p3','detail_3_1','detail_3_2','detail_3_3','detail_3_4','bobot_p3',
                           'header_p4','detail_4_1','detail_4_2','detail_4_3','bobot_p4',
                           'header_p5','detail_5_1','detail_5_2','detail_5_3','detail_5_4','detail_5_5','detail_5_6','detail_5_7','detail_5_8','detail_5_9','detail_5_10','bobot_p5',
                           'header_p6','detail_6_1','detail_6_2','detail_6_3','detail_6_4','detail_6_5','detail_6_6','bobot_p6',
                           'header_p7','detail_7_1','bobot_p7',
                           'header_p8','detail_8_1','bobot_p8',
                           'header_p9','detail_9_1','detail_9_2','detail_9_3','detail_9_4','detail_9_5','detail_9_6','detail_9_7','bobot_p9',
                           'header_p10','detail_10_1','detail_10_2','detail_10_3','detail_10_4','bobot_p10',
                           'header_p11','detail_11_1','detail_11_2','detail_11_3','bobot_p11'
                        ];
}