<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'tap',
        'nama_sales',
        'fokus_1',
        'fokus_2',
        'fokus_3',
        'perdana',
        'byu',
        'lite',
        'orbit',
        'cvm_byu',
        'super_seru',
        'digital',
        'roaming',
        'vf_hp',
        'vf_lite_byu',
        'lite_vf',
        'byu_vf',
        'my_telkomsel'
    ];

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // HELPER: total penjualan
    public function totalSelling()
    {
        return
            $this->perdana +
            $this->byu +
            $this->lite +
            $this->orbit +
            $this->cvm_byu +
            $this->super_seru +
            $this->digital +
            $this->roaming + 
            $this->vf_hp + 
            $this->vf_lite_byu + 
            $this->lite_vf + 
            $this->byu_vf + 
            $this->my_telkomsel ;
    }
}
