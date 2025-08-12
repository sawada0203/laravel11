<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpdData extends Model
{
    //use HasFactory;
    protected $table = 'ovst'; // ชื่อตารางใน MySQL
    protected $primaryKey = 'vn'; // หรือ 'id' ถ้าใช้ id
    public $incrementing = false; // ถ้า primary key ไม่ใช่ auto increment
    protected $keyType = 'string'; // ถ้า primary key เป็น string เช่น hos_guid


    public function scopeThisMonth($query)
    {
        return $query->whereBetween('vstdate', [now()->startOfMonth(), now()]);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('vstdate', now());
    }

        public static function countPttopd()
    {
            return DB::table('vn_stat as vn')
            ->leftJoin('pttype as pt', 'vn.pttype', '=', 'pt.pttype')
            ->leftJoin('pcode as p', 'pt.pcode', '=', 'p.code')
            ->whereDate('vn.vstdate', now())
            ->selectRaw("
                COUNT(IF(pt.pcode = 'UC', vn.vn, NULL)) AS uc,
                COUNT(IF(pt.pcode IN ('A1','A2'), vn.vn, NULL)) AS mo,
                COUNT(
                    IF(
                        p.code IS NULL 
                        OR (pt.pcode <> 'UC' AND pt.pcode NOT IN ('A1','A2')),
                        vn.vn,
                        NULL
                    )
                ) AS ot
            ")
            ->first();
    }
}
