<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ERData extends Model
{
    // กำหนดชื่อ table และ primary key
    protected $table = 'er_regist';
    protected $primaryKey = 'vn';
    public $incrementing = true;
    public $timestamps = false; // ปิด timestamps ถ้า table ไม่มี created_at, updated_at

    /**
     * Scope: กรองเฉพาะผู้ป่วยอุบัติเหตุ (accident_code = 'Y')
     */
    public function scopeErPt($query)
    {
        return $query->whereIn('er_regist.er_pt_type', function ($sub) {
            $sub->select('er_pt_type')
                ->from('er_pt_type')
                ->where('accident_code', 'Y');
        });
    }

    /**
     * Scope: ช่วงของเดือนนี้ (เริ่มต้นเดือน -> วันนี้)
     */
    public function scopeThisMonth($query)
    {
        return $query->whereBetween('er_regist.vstdate', [now()->startOfMonth(), now()]);
    }

    /**
     * Scope: เฉพาะข้อมูลของวันนี้
     */
    public function scopeToday($query)
    {
        return $query->whereDate('er_regist.vstdate', now());
    }

    public function scopeJoinOvst($query)
    {
        return $query->leftJoin('ovst as o', 'o.vn', '=', 'er_regist.vn');
    }
}
