<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index() {
        $user = Auth::user();
        $latestAttendance = Attendance::where('user_id', $user->id)->latest()->first();
        $currentDate = Carbon::now();

        if ($latestAttendance) {
            $lastAttendanceDate = Carbon::parse($latestAttendance->start_time);

            // 日付が異なる場合は新しい日の出勤情報を作成
            if (!$lastAttendanceDate->isSameDay($currentDate)) {
                //退勤処理
                $latestAttendance->punchOut();
                // 新しい日の出勤情報を作成
                $newAttendance = new Attendance();
                $newAttendance->user_id = auth()->id();
                $newAttendance->start_time = Carbon::now();
                $newAttendance->save();
            }
        }
        return view('index', ['latestAttendance' => $latestAttendance, 'user' => $user]);
    }

    public function login() {
        return view('login');
    }

    public function punchIn()
    {
        $user = Auth::user();
        $attendance = new Attendance();
        $attendance->user_id = $user->id;
        $attendance->punchIn();
        return redirect('/')->with('success', '出勤しました。');
    }

    public function punchOut()
    {
        $user = Auth::user();
        $Attendance = Attendance::where('user_id', $user->id)->latest()->first();

        $Attendance->punchOut();
        return redirect('/')->with('success', '退勤しました。');
    }

    public function breakIn()
    {
        $user = Auth::user();
        $Attendance = Attendance::where('user_id', $user->id)->latest()->first();

        $break = new Rest();
        $break->Attendance_id = $Attendance->id;
        $break->breakIn();
        return redirect('/')->with('success', '休憩を開始しました。');
    }

    public function breakOut()
    {
        $user = Auth::user();
        $Attendance = Attendance::where('user_id', $user->id)->latest()->first();

        $break = Rest::where('Attendance_id', $Attendance->id)->latest()->first();

        $break->breakOut();
        $break->calculateAndSaveDuration();
        return redirect('/')->with('success', '休憩を終了しました。');
    }

    public function attendance($today = null)
    {
        // $dates = Attendance::with('user')
        // ->leftJoin('rests', 'attendances.id', '=', 'rests.attendance_id')
        // ->leftJoin('users', 'users.id', '=', 'attendances.user_id')
        // ->select(
        //     'attendances.start_time'
        // )
        // ->groupBy('attendances.start_time')
        // ->paginate(1, ["*"], 'datePage');

        if ($today){
            $dates = $today;
        }else{
            $dates = date("Y-m-d");
        }

        DB::enableQueryLog();
        $attendances = Attendance::with('user')
        ->join('rests', 'attendances.id', '=', 'rests.attendance_id')
        ->Join('users', 'users.id', '=', 'attendances.user_id')
        ->select(
            'users.name',
            'attendances.start_time',
            'attendances.end_time',
            DB::raw('SUM(rests.rest_duration) as total_rest'),
            DB::raw('(SUM(UNIX_TIMESTAMP(attendances.end_time) - UNIX_TIMESTAMP(attendances.start_time)) - SUM(rests.rest_duration)) as working_hours')
        )
        ->whereDate('attendances.created_at', $dates)
        ->groupBy('users.id', 'attendances.id')
        ->orderBy('users.name');
        // ->paginate(5, ["*"], 'attendancePage');

        // dd(DB::getQueryLog());

        $attendances->each(function ($attendance) {
            $attendance->total_rest = $attendance->total_rest;
        });

        return view('attendance', ['dates' => $dates, 'attendances' => $attendances]);
    }
}
