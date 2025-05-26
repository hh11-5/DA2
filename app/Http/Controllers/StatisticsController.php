<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use App\Models\KhachHang;
use App\Models\SanPham;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    private function checkAccess() {
        if (!auth()->check()) {
            return redirect()->route('admin.loginForm');
        }
        return null;
    }

    public function index(Request $request)
    {
        if ($response = $this->checkAccess()) {
            return $response;
        }

        $type = $request->get('type', 'daily');

        // Format dates properly for PostgreSQL
        $startDate = $request->get('start_date')
            ? Carbon::parse($request->get('start_date'))->startOfDay()->format('Y-m-d H:i:s')
            : Carbon::now()->subMonth()->startOfDay()->format('Y-m-d H:i:s');

        $endDate = $request->get('end_date')
            ? Carbon::parse($request->get('end_date'))->endOfDay()->format('Y-m-d H:i:s')
            : Carbon::now()->endOfDay()->format('Y-m-d H:i:s');

        // Get data based on type
        switch($type) {
            case 'daily':
                $data = $this->getDailyStats($startDate, $endDate);
                break;
            case 'monthly':
                $data = $this->getMonthlyStats($startDate, $endDate);
                break;
            case 'quarterly':
                $data = $this->getQuarterlyStats($startDate, $endDate);
                break;
            case 'yearly':
                $data = $this->getYearlyStats($startDate, $endDate);
                break;
            case 'customer':
                $data = $this->getCustomerStats($startDate, $endDate);
                break;
            case 'product':
                $data = $this->getProductStats($startDate, $endDate);
                break;
            default:
                $data = $this->getDailyStats($startDate, $endDate);
        }

        return view('admin.statistics.index', compact('data', 'type', 'startDate', 'endDate'));
    }

    private function checkEmployeeAccess()
    {
        if (!auth()->check() || !auth()->user()->nhanVien || auth()->user()->phanQuyen->idqh != 2) {
            return redirect()->route('index')->with('error', 'Bạn không có quyền truy cập trang này');
        }
        return null;
    }

    public function employeeIndex(Request $request)
    {
        if ($response = $this->checkEmployeeAccess()) {
            return $response;
        }

        $type = $request->get('type', 'daily');

        $startDate = $request->get('start_date')
            ? Carbon::parse($request->get('start_date'))->startOfDay()->format('Y-m-d H:i:s')
            : Carbon::now()->subMonth()->startOfDay()->format('Y-m-d H:i:s');

        $endDate = $request->get('end_date')
            ? Carbon::parse($request->get('end_date'))->endOfDay()->format('Y-m-d H:i:s')
            : Carbon::now()->endOfDay()->format('Y-m-d H:i:s');

        switch($type) {
            case 'daily':
                $data = $this->getDailyStats($startDate, $endDate);
                break;
            case 'monthly':
                $data = $this->getMonthlyStats($startDate, $endDate);
                break;
            case 'quarterly':
                $data = $this->getQuarterlyStats($startDate, $endDate);
                break;
            case 'yearly':
                $data = $this->getYearlyStats($startDate, $endDate);
                break;
            case 'product':
                $data = $this->getProductStats($startDate, $endDate);
                break;
            default:
                $data = $this->getDailyStats($startDate, $endDate);
        }

        return view('employee.statistics.index', compact('data', 'type', 'startDate', 'endDate'));
    }

    private function getDailyStats($start, $end)
    {
        $query = DonHang::where('trangthai', 3)
            ->whereBetween('ngaydathang', [$start, $end])
            ->select(
                DB::raw("DATE(ngaydathang) as date"),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(tongtien) as revenue')
            )
            ->groupBy(DB::raw('DATE(ngaydathang)'))
            ->orderBy('date');

        return $query->get();
    }

    private function getMonthlyStats($start, $end)
    {
        return DonHang::where('trangthai', 3)
            ->whereBetween('ngaydathang', [$start, $end])
            ->select(
                DB::raw('EXTRACT(YEAR FROM ngaydathang) as year'),
                DB::raw('EXTRACT(MONTH FROM ngaydathang) as month'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(tongtien) as revenue')
            )
            ->groupBy(
                DB::raw('EXTRACT(YEAR FROM ngaydathang)'),
                DB::raw('EXTRACT(MONTH FROM ngaydathang)')
            )
            ->orderBy('year')
            ->orderBy('month')
            ->get();
    }

    private function getQuarterlyStats($start, $end)
    {
        return DonHang::where('trangthai', 3)
            ->whereBetween('ngaydathang', [$start, $end])
            ->select(
                DB::raw('EXTRACT(YEAR FROM ngaydathang) as year'),
                DB::raw('EXTRACT(QUARTER FROM ngaydathang) as quarter'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(tongtien) as revenue')
            )
            ->groupBy(
                DB::raw('EXTRACT(YEAR FROM ngaydathang)'),
                DB::raw('EXTRACT(QUARTER FROM ngaydathang)')
            )
            ->orderBy('year')
            ->orderBy('quarter')
            ->get();
    }

    private function getYearlyStats($start, $end)
    {
        return DonHang::where('trangthai', 3)
            ->whereBetween('ngaydathang', [$start, $end])
            ->select(
                DB::raw('EXTRACT(YEAR FROM ngaydathang) as year'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(tongtien) as revenue')
            )
            ->groupBy(DB::raw('EXTRACT(YEAR FROM ngaydathang)'))
            ->orderBy('year')
            ->get();
    }

    private function getCustomerStats($start, $end)
    {
        return DonHang::where('trangthai', 3)
            ->whereBetween('ngaydathang', [$start, $end])
            ->with('khachHang')
            ->select(
                'idkh',
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(tongtien) as total_spent')
            )
            ->groupBy('idkh')
            ->orderByDesc('total_spent')
            ->limit(10)
            ->get();
    }

    private function getProductStats($start, $end)
    {
        return ChiTietDonHang::whereHas('donHang', function($query) use ($start, $end) {
            $query->where('trangthai', 3)
                  ->whereBetween('ngaydathang', [$start, $end]);
        })
        ->with('sanPham')
        ->select(
            'idsp',
            DB::raw('SUM(soluong) as total_quantity'),
            DB::raw('SUM(thanhtien) as total_revenue')
        )
        ->groupBy('idsp')
        ->orderByDesc('total_revenue')
        ->limit(10)
        ->get();
    }
}
