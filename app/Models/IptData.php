<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IptData extends Model
{
    protected $table = 'ipt';
    protected $primaryKey = 'an';
    public $incrementing = true;


    public function scopeThisMonth($query)
    {
        return $query->whereBetween('regdate', [now()->startOfMonth(), now()]);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('regdate', now());
    }

    public static function countSexipd()
    {
        // ดึงเฉพาะ field ที่ต้องใช้
        $data = self::leftJoin('an_stat as s', 's.hn', '=', 'ipt.hn')
            ->where('ipt.regdate', '<>', '')
            ->where(fn($q) => $q->where('ipt.dchdate', '=', '')->orWhereNull('ipt.dchdate'))
            ->get(['ipt.hn', 's.sex']);

        // นับแยกชาย-หญิงด้วย Collection
        $maleCount = $data->where('sex', '1')->unique('hn')->count();
        $femaleCount = $data->where('sex', '2')->unique('hn')->count();

        return [
            'male' => $maleCount,
            'female' => $femaleCount,
        ];
    }


    public static function bedward()
    {
        return self::whereNull('ipt.dchdate')
            ->join('ward as w', 'w.ward', '=', 'ipt.ward')
            ->groupBy('w.ward', 'w.name', 'w.bedcount')
            ->select('w.ward', 'w.name', 'w.bedcount')
            ->selectRaw('COUNT(ipt.an) as admitnow') // ตรงนี้ยังต้อง selectRaw
            ->orderBy('w.ward', 'ASC')
            ->get();
    }


    public static function countPttipd()
    {
        return DB::table('ipt as i')
            ->leftJoin('pttype as pt', 'i.pttype', '=', 'pt.pttype')
            ->leftJoin('pcode as p', 'pt.pcode', '=', 'p.code')
            ->where('i.regdate', '<>', '')
            ->where(function ($q) {
                $q->where('i.dchdate', '=', '')
                    ->orWhereNull('i.dchdate');
            })
            ->selectRaw("
            COUNT(CASE WHEN pt.pcode = 'UC' THEN i.an END) AS uc,
            COUNT(CASE WHEN pt.pcode IN ('A1','A2') THEN i.an END) AS mo,
            COUNT(
                CASE WHEN p.code IS NULL 
                     OR (pt.pcode <> 'UC' AND pt.pcode NOT IN ('A1','A2')) 
                THEN i.an END
            ) AS ot
        ")
            ->first();
    }
}
