<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Harian;
use App\Models\Mingguan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class MmController extends Controller
{
    public function index()
    {
        // Existing calculations
        $totalUsers = User::count();
        $reportsSubmitted = Harian::count() + Mingguan::count();
        $pendingTasks = Harian::where('status', 0)->count() + Mingguan::where('status', 0)->count();
        $acceptedTasks = Harian::where('status', 1)->count() + Mingguan::where('status', 1)->count();
        $rejectedTasks = Harian::where('status', 2)->count() + Mingguan::where('status', 2)->count();

        // Recent activities
        $recentActivities = DB::table('harian')
            ->select(
                'harian.date',
                'harian.id_marketing as user_id',
                DB::raw('CASE WHEN harian.status = 1 THEN "Uploaded" ELSE "Submitted Report" END as action'),
                'harian.status',
                'users.name as user_name'
            )
            ->join('users', 'users.id', '=', 'harian.id_marketing')
            ->union(
                DB::table('mingguan')
                    ->select(
                        'mingguan.periode as date',
                        'mingguan.id_marketing as user_id',
                        DB::raw('CASE WHEN mingguan.status = 1 THEN "Uploaded" ELSE "Created Task" END as action'),
                        'mingguan.status',
                        'users.name as user_name'
                    )
                    ->join('users', 'users.id', '=', 'mingguan.id_marketing')
            )
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        // Check if all reports for each user have been uploaded
        $uploadedStatus = DB::table('users')
            ->leftJoin('harian', 'users.id', '=', 'harian.id_marketing')
            ->leftJoin('mingguan', 'users.id', '=', 'mingguan.id_marketing')
            ->select('users.id', 'users.name')
            ->selectRaw('COUNT(harian.id) as total_harian')
            ->selectRaw('COUNT(mingguan.id) as total_mingguan')
            ->selectRaw('SUM(CASE WHEN harian.status = 1 THEN 1 ELSE 0 END) as uploaded_harian')
            ->selectRaw('SUM(CASE WHEN mingguan.status = 1 THEN 1 ELSE 0 END) as uploaded_mingguan')
            ->groupBy('users.id', 'users.name')
            ->get()
            ->mapWithKeys(function ($user) {
                return [$user->id => $user->total_harian + $user->total_mingguan == $user->uploaded_harian + $user->uploaded_mingguan ? 'Uploaded All' : 'Sudah Upload'];
            });

        // Prepare data for the performance chart
        $performanceData = User::with([
            'harian' => function ($query) {
                $query->selectRaw('id_marketing, status, COUNT(*) as count')
                    ->groupBy('id_marketing', 'status');
            },
            'mingguan' => function ($query) {
                $query->selectRaw('id_marketing, status, COUNT(*) as count')
                    ->groupBy('id_marketing', 'status');
            }
        ])
            ->where('role', 'marketing')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'accepted' => $user->harian->where('status', 1)->sum('count') + $user->mingguan->where('status', 1)->sum('count'),
                    'rejected' => $user->harian->where('status', 2)->sum('count') + $user->mingguan->where('status', 2)->sum('count'),
                    'total' => $user->harian->sum('count') + $user->mingguan->sum('count')
                ];
            });

        $marketingUsers = User::where('role', 'marketing')->get();

        return view('mm.dashboard', [
            'totalUsers' => $totalUsers,
            'reportsSubmitted' => $reportsSubmitted,
            'pendingTasks' => $pendingTasks,
            'acceptedTasks' => $acceptedTasks,
            'rejectedTasks' => $rejectedTasks,
            'recentActivities' => $recentActivities,
            'uploadedStatus' => $uploadedStatus,
            'performanceData' => $performanceData,
            'marketingUsers' => $marketingUsers
        ]);
    }


    public function marketing()
    {
        $pengguna = DB::table('users')->where('role', 'marketing')->get();

        $data = [
            'users' => $pengguna,
        ];

        return view('mm.marketing', $data);
    }

    public function harian()
    {
        return view('mm.harian.index');
    }
    public function hariansakinah()
    {

        $harianData = Harian::where('project', 'sakinah')->where('status', 0)->with('marketing')->get();

        return view('mm.harian.area.sakinah', compact('harianData'));
    }

    public function hariansavill()
    {
        $harianData = Harian::where('project', 'savill')->where('status', 0)->with('marketing')->get();

        return view('mm.harian.area.savill', compact('harianData'));
    }

    public function hariantriehans()
    {
        $harianData = Harian::where('project', 'triehans')->where('status', 0)->with('marketing')->get();

        return view('mm.harian.area.triehans', compact('harianData'));
    }

    public function happrove($id)
    {
        $enkId = Crypt::decrypt($id);
        $harian = Harian::find($enkId);

        if ($harian->status == 0) {
            $harian->status = 1;
            $harian->save();

            return redirect()->back()->with('success', 'Data approved successfully.');
        }

        return redirect()->back()->with('info', 'Data is already approved.');
    }

    public function hreject($id)
    {
        $enkId = Crypt::decrypt($id);
        $harian = Harian::find($enkId);

        if ($harian->status == 0) {
            $harian->status = 2;
            $harian->save();

            return redirect()->back()->with('success', 'Data approved successfully.');
        }

        return redirect()->back()->with('info', 'Data is already approved.');
    }

    public function mingguan()
    {
        return view('mm.mingguan.index');
    }

    public function mingguansakinah()
    {
        $mingguanData = Mingguan::where('projectArea', 'sakinah')->where('status', 0)->with('marketing')->get();

        return view('mm.mingguan.area.sakinah', compact('mingguanData'));
    }

    public function mingguansavill()
    {
        $mingguanData = Mingguan::where('projectArea', 'savill')->where('status', 0)->with('marketing')->get();

        return view('mm.mingguan.area.savill', compact('mingguanData'));
    }

    public function mingguantriehans()
    {
        $mingguanData = Mingguan::where('projectArea', 'triehans')->where('status', 0)->with('marketing')->get();

        return view('mm.mingguan.area.triehans', compact('mingguanData'));
    }

    public function mapprove($id)
    {
        $enkId = Crypt::decrypt($id);
        $mingguan = Mingguan::find($enkId);

        if ($mingguan->status == 0) {
            $mingguan->status = 1;
            $mingguan->save();

            return redirect()->back()->with('success', 'Data approved successfully.');
        }

        return redirect()->back()->with('info', 'Data is already approved.');
    }

    public function mreject($id)
    {
        $enkId = Crypt::decrypt($id);
        $mingguan = Mingguan::find($enkId);

        if ($mingguan->status == 0) {
            $mingguan->status = 2;
            $mingguan->save();

            return redirect()->back()->with('success', 'Data approved successfully.');
        }

        return redirect()->back()->with('info', 'Data is already approved.');
    }
}
