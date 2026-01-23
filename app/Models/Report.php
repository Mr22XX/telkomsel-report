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

    
    // =========================
    // TOTAL QTY (UNIT)
    // =========================
    public function totalQty()
    {
        return ($this->perdana ?? 0)
             + ($this->byu ?? 0)
             + ($this->lite ?? 0)
             + ($this->orbit ?? 0);
    }

    // =========================
    // TOTAL REVENUE (RUPIAH)
    // =========================
    public function totalRevenue()
    {
        return ($this->cvm_byu ?? 0)
             + ($this->super_seru ?? 0)
             + ($this->digital ?? 0)
             + ($this->roaming ?? 0)
             + ($this->vf_hp ?? 0)
             + ($this->vf_lite_byu ?? 0)
             + ($this->lite_vf ?? 0)
             + ($this->byu_vf ?? 0)
             + ($this->my_telkomsel ?? 0);
    }
}



