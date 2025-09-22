<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterProses extends Model
{
    use HasFactory;
    protected $table = 'tb_parameter_proses';
    protected $fillable = ['header_parameter_pembuka','detail_p1','detail_p2','detail_p3','detail_p4','detail_p5','bobot_proses','header_parameter_verifikasi','detail_v1','bobot_verifikasi','header_parameter_penutup','detail_sp1','detail_sp2','bobot_penutup'];
    
    public function penilaianTappling()
    {
        return $this->belongsTo(PenilaianTappling::class);
    }
}