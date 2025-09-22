<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianTapping extends Model
{
    use HasFactory;
    protected $table = 'tb_penilaian_tapping';
    protected $fillable = ['periode','tanggal_recording','name_id','perner','login_id','site','peak','nama_checker','file','email_sent','detail_n1_1','detail_n1_2','detail_n1_3','detail_n1_4','detail_n1_5','total_n1','detail_n2_1','detail_n2_2','total_n2','detail_n3_1','detail_n3_2','total_n3','detail_n4_1','detail_n4_2','detail_n4_3','total_n4','detail_n5_1','total_n5','detail_n6_1','detail_n6_2','detail_n6_3','detail_n6_4','total_n6','detail_n7_1','detail_n7_2','detail_n7_3','total_n7','detail_n8_1','detail_n8_2','detail_n8_3','detail_n8_4','detail_n8_5','detail_n8_6','detail_n8_7','detail_n8_8','detail_n8_9','detail_n8_10','total_n8','detail_n9_1','detail_n9_2','detail_n9_3','detail_n9_4','detail_n9_5','detail_n9_6','detail_n9_5','detail_n9_6','total_n9','detail_n10_1','total_n10','detail_n11_1','total_n11','detail_n12_1','detail_n12_2','detail_n12_3','detail_n12_4','detail_n12_5','detail_n12_6','detail_n12_7','total_n12','detail_n13_1','detail_n13_2','detail_n13_3','detail_n13_4','total_n13','detail_n14_1','detail_n14_2','detail_n14_3','total_n14','detail_n15_1','total_n15','detail_n16_1','detail_n16_2','detail_n16_3','detail_n16_4','total_n16','total_proses','total_sikap','total_solusi','total_qm_p1','total_qm_p2','total_qm_p3','peak_1','peak_2','peak_3','peak_4','total_peak','keterangan'];

    public function parameterProses()
    {
        return $this->hasOne(ParameterProses::class);
    }

    public function parameterSikap()
    {
        return $this->hasOne(ParameterSikap::class);
    }

    public function parameterSolusi()
    {
        return $this->hasOne(ParameterSolusi::class);
    }
    public function user()
    {
        return $this->hasOne(User::class,'id','name_id');
    }
}