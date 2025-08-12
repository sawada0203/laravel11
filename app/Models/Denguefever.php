<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Denguefever extends Model
{
    protected $table = 'ovst';
    protected $primaryKey = 'vn';
    public $incrementing = false;
    protected $keyType = 'string';

    public static function getDengueStats($start = '2023-01-01', $end = '2025-12-31')
    {
        $codes = [
            'A484',
            'A91',
            'A910',
            'A911',
            'A919',
            'A96',
            'A960',
            'A961',
            'A968',
            'A969',
            'A97',
            'A970',
            'A971',
            'A972',
            'A98',
            'A980'
        ];

        return DB::table('ovst as o')
            ->leftJoin('ovstdiag as od', 'od.hn', '=', 'o.hn')
            ->leftJoin('icd101 as i', 'i.code', '=', 'od.icd10')
            ->whereIn('od.icd10', $codes)
            ->whereBetween('o.vstdate', [$start, $end])
            ->selectRaw('
            YEAR(o.vstdate) as year,
            MONTH(o.vstdate) as month,
            COUNT(*) as count
        ')
            ->groupBy(DB::raw('YEAR(o.vstdate)'), DB::raw('MONTH(o.vstdate)'))
            ->orderBy('year')
            ->orderBy('month')
            ->get();
    }
}
