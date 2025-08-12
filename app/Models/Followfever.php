<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Followfever extends Model
{
    protected $table = 'surveil_member';
    protected $primaryKey = 'sv_number';
    public $incrementing = false;
    public $timestamps = false; // ปิด timestamps ถ้า table ไม่มี created_at, updated_at

// Join ข้อมูลโรค 506
    public function scopeJoin506($query)
    {
        return $query
            ->leftJoin('provis_code506 as p', 'p.code', '=', 'surveil_member.code506')
            ->leftJoin('name506 as n', 'n.code', '=', 'surveil_member.code506');
    }

    // เดือนปัจจุบัน
    public function scopeThisMonth($query)
    {
        return $query
            ->whereYear('surveil_member.vstdate', now()->year)
            ->whereMonth('surveil_member.vstdate', now()->month);
    }

    // Top N 506
    public function scopeTopFever506($query, $limit = 10)
    {
        return $query
            ->select(
                'n.code506',
                'p.name as namee',
                'n.name as namet',
                DB::raw('COUNT(*) as count506')
            )
            ->groupBy('n.code506', 'p.name', 'n.name')
            ->orderByDesc('count506')
            ->limit($limit);
    }

}
