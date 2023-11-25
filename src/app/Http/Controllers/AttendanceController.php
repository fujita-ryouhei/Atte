<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Attendance;
use App\Models\Rest;

class AttendanceController extends Controller
{
    public function index() {
        $user = Auth::user();
        $latestAttendance = Attendance::where('user_id', $user->id)->latest()->first();
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

        if (!$Attendance || $Attendance->end_time) {
            return redirect('/')->with('error', '出勤情報が見つからないか、既に退勤済みです。');
        }

        $Attendance->punchOut();
        return redirect('/')->with('success', '退勤しました。');
    }

    public function breakIn()
    {
        $user = Auth::user();
        $Attendance = Attendance::where('user_id', $user->id)->latest()->first();

        if (!$Attendance || $Attendance->end_time) {
            return redirect('/')->with('error', '出勤情報が見つからないか、既に退勤済みです。');
        }

        $break = new Rest();
        $break->Attendance_id = $Attendance->id;
        $break->breakIn();
        return redirect('/')->with('success', '休憩を開始しました。');
    }

    public function breakOut()
    {
        $user = Auth::user();
        $Attendance = Attendance::where('user_id', $user->id)->latest()->first();

        if (!$Attendance || $Attendance->end_time) {
            return redirect('/')->with('error', '出勤情報が見つからないか、既に退勤済みです。');
        }

        $break = Rest::where('Attendance_id', $Attendance->id)->latest()->first();

    if (!$break || $break->break_end) {
        return redirect('/')->with('error', '休憩情報が見つからないか、既に休憩終了済みです。');
    }

        $break->breakOut();
        return redirect('/')->with('success', '休憩を終了しました。');
    }
}
