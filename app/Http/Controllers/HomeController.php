<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\OpdData;
use App\Models\IptData;
use App\Models\ERData;
use App\Models\Denguefever;
use App\Models\Followfever;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home');
    }

    public function datadash()
    {
        // ดึงข้อมูลจาก model
        // วันที่เริ่ม = 2 ปีย้อนหลัง ตั้งแต่ต้นปี
        $startDate = now()->subYears(2)->startOfYear()->toDateString();

        // วันที่สิ้นสุด = วันนี้ หรือสิ้นปีปัจจุบัน
        $endDate = now()->endOfYear()->toDateString();

        $dengueStats = Denguefever::getDengueStats($startDate, $endDate);

        // เตรียม labels (เดือน)
        $labels = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];

        // ดึงปีจากข้อมูลจริง
        $years = collect($dengueStats)->pluck('year')->unique()->map(function ($y) {
            return $y + 543; // แปลง ค.ศ. เป็น พ.ศ.
        })->sort()->values()->all();

        // สร้าง datasets
        $datasets = [];
        $colors = [
            'rgba(59, 130, 246, 0.7)',
            'rgba(34, 197, 94, 0.7)',
            'rgba(251, 191, 36, 0.7)'
        ];
        foreach ($years as $i => $year) {
            $data = array_fill(0, 12, 0);
            foreach ($dengueStats as $row) {
                if ((int)$row->year == $year - 543) {
                    $data[(int)$row->month - 1] += $row->count;
                }
            }
            $datasets[] = [
                'label' => 'ปี' . $year,
                'data' => $data,
                'backgroundColor' => $colors[$i % count($colors)],
            ];
        }

        $chartData = [
            'labels' => $labels,
            'datasets' => $datasets,
        ];

        // ตัวอย่างข้อมูลที่จะส่งให้ PieChart.vue
            // เรียกใช้ฟังก์ชันนับชายหญิง
        $sexStats = IptData::countSexipd();
        $chartData2 = [
            'labels' => ['ชาย', 'หญิง'],
            'data' => [$sexStats['male'], $sexStats['female']],
        ];


        // ========== OPD ==========
        $alldataOPD = [
            'ptm_opd_hn' => OpdData::thisMonth()->distinct()->count('hn'),
            'ptm_opd_vn' => OpdData::thisMonth()->distinct()->count('vn'),
            'pt_opd_today' => OpdData::today()->distinct()->count('vn'),
        ];

        // ========== IPD ==========
        $alldataIPD = [
            'ptm_ipd_hn' => IptData::thisMonth()->distinct()->count('hn'),
            'ptm_ipd_an' => IptData::thisMonth()->distinct()->count('an'),
            'pt_ipd_today' => IptData::today()->distinct()->count('an'),
        ];

        // ========== ER ==========
        $alldataER = [
            'ptm_er_hn' => ERData::ErPt()->thisMonth()->joinOvst()->distinct()->count('o.hn'),
            'ptm_er_vn' => ERData::ErPt()->thisMonth()->joinOvst()->distinct()->count('o.vn'),
            'pt_er_today' => ERData::ErPt()->today()->joinOvst()->distinct()->count('o.vn'),
        ];

        // =============== telemet ==================


        $today = now()->toDateString();
        $startOfMonth = now()->startOfMonth()->toDateString();

        $data = DB::table('ovst as o')
            ->leftJoin('patient as pt', 'pt.hn', '=', 'o.hn')
            ->where('o.ovstist', '09')
            ->selectRaw(
                '
        COUNT(DISTINCT CASE WHEN o.vstdate = ? THEN o.hn END) AS pt_hn_today,
        COUNT(DISTINCT CASE WHEN o.vstdate BETWEEN ? AND ? THEN o.hn END) AS pt_hn_month,
        COUNT(CASE WHEN o.vstdate BETWEEN ? AND ? THEN o.vn END) AS pt_vn_month',
                [$today, $startOfMonth, $today, $startOfMonth, $today]
            )
            ->first();

        $alldataTele = [
            'pt_hn_today' => $data->pt_hn_today,
            'pt_hn_month' => $data->pt_hn_month,
            'pt_vn_month' => $data->pt_vn_month,
        ];

        // ========== Ferver506 ==========

        $fever506Table = Followfever::query()
        ->join506()
        ->thisMonth()
        ->topFever506(6)
        ->get();

        // ========== bedward ==========
        $bedward = IptData::bedward();

        // ========== สิทธิ์IPD ==========
        $pttStats = IptData::countPttipd();
        $pttipd = [
            'uc' => $pttStats->uc ?? 0,
            'mo' => $pttStats->mo ?? 0,
            'ot' => $pttStats->ot ?? 0,
        ];

        // ========== สิทธิ์OPD ==========
        $pttStats2 = OpdData::countPttopd();
        $pttopd = [
            'uc' => $pttStats2->uc ?? 0,
            'mo' => $pttStats2->mo ?? 0,
            'ot' => $pttStats2->ot ?? 0,
        ];

        // ========== ส่งข้อมูลไปแสดง ==========

        return Inertia::render('DataDash', [
            'chartData' => $chartData,
            'chartData2' => $chartData2,
            'alldataOPD' => $alldataOPD,
            'alldataIPD' => $alldataIPD,
            'alldataER' => $alldataER,
            'alldataTele' => $alldataTele,
            'fever506Table' => $fever506Table,
            'bedward' => $bedward,
            'pttipd' => $pttipd,
            'pttopd' => $pttopd,
        ]);
    }


    public function table()
    {

        $users = User::paginate(10); //Table.vue

        return Inertia::render('Table', [
            'users' => $users
        ]);
    }
}
