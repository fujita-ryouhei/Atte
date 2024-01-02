<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

class AttendanceController extends Controller
{
    public function index() {
        $user = Auth::user();
        $latestAttendance = Attendance::where('user_id', $user->id)->latest()->first();
        $currentDate = Carbon::now();

        // 前日の勤怠が終了していない場合
        if ($latestAttendance && !$latestAttendance->end_time) {
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

    public function attendance($today = null, Request $request)
    {
        if ($today){
            $dates = $today;
        }else{
            $dates = date("Y-m-d");
        }

        $attendances = Attendance::with('user')
            ->join('rests', 'attendances.id', '=', 'rests.attendance_id')
            ->join('users', 'users.id', '=', 'attendances.user_id')
            ->select(
                'users.name',
                'attendances.start_time',
                'attendances.end_time',
                DB::raw('SUM(COALESCE(rests.rest_duration, 0)) as total_rest'),
                DB::raw('(UNIX_TIMESTAMP(attendances.end_time) - UNIX_TIMESTAMP(attendances.start_time)) - SUM(COALESCE(rests.rest_duration, 0)) as working_hours')
            )
            ->whereDate('attendances.created_at', $dates)
            ->groupBy('users.id', 'attendances.id') // users.idとattendances.idで関連するデータをグループ化
            ->orderBy('users.name') // users.nameを基準にソート
            ->paginate(5);

        return view('attendance', ['dates' => $dates, 'attendances' => $attendances]);
    }

    /**
     * 前日の勤怠取得API
     * <ボタンを押したとき、日付を一日減らして値を返す
     * @param $dates
     * return $today, $attendances
     */
    public function subDay(Request $request)
    {
        $dates = $request->only('dates')['dates'];

        $carbonDate = Carbon::parse($dates);

        $today = $carbonDate->subDay()->format("Y-m-d");

        if ($today){
            $dates = $today;
        }else{
            $dates = date("Y-m-d");
        }

        $attendances = Attendance::with('user')
            ->join('rests', 'attendances.id', '=', 'rests.attendance_id')
            ->join('users', 'users.id', '=', 'attendances.user_id')
            ->select(
                'users.name',
                'attendances.start_time',
                'attendances.end_time',
                DB::raw('SUM(COALESCE(rests.rest_duration, 0)) as total_rest'),
                DB::raw('(UNIX_TIMESTAMP(attendances.end_time) - UNIX_TIMESTAMP(attendances.start_time)) - SUM(COALESCE(rests.rest_duration, 0)) as working_hours')
            )
            ->whereDate('attendances.created_at', $dates)
            ->groupBy('users.id', 'attendances.id') // users.idとattendances.idで関連するデータをグループ化
            ->orderBy('users.name') // users.nameを基準にソート
            ->paginate(5);

        return view('attendance', ['dates' => $today, 'attendances' => $attendances]);
    }

    /**
     * 翌日の勤怠取得API
     * >ボタンを押したとき、日付を一日増やして値を返す
     * @param $dates
     * return $today, $attendances
     */
    public function addDay(Request $request)
    {
        $dates = $request->only('dates')['dates'];

        $carbonDate = Carbon::parse($dates);

        $today = $carbonDate->addDay()->format("Y-m-d");

        if ($today){
            $dates = $today;
        }else{
            $dates = date("Y-m-d");
        }

        $attendances = Attendance::with('user')
            ->join('rests', 'attendances.id', '=', 'rests.attendance_id')
            ->join('users', 'users.id', '=', 'attendances.user_id')
            ->select(
                'users.name',
                'attendances.start_time',
                'attendances.end_time',
                DB::raw('SUM(COALESCE(rests.rest_duration, 0)) as total_rest'),
                DB::raw('(UNIX_TIMESTAMP(attendances.end_time) - UNIX_TIMESTAMP(attendances.start_time)) - SUM(COALESCE(rests.rest_duration, 0)) as working_hours')
            )
            ->whereDate('attendances.created_at', $dates)
            ->groupBy('users.id', 'attendances.id') // users.idとattendances.idで関連するデータをグループ化
            ->orderBy('users.name') // users.nameを基準にソート
            ->paginate(5);

        return view('attendance', ['dates' => $today, 'attendances' => $attendances]);
    }

    public function users()
    {
        // 現在の日付を取得
        $today = Carbon::today();

        // 1週間分の日付を生成
        $weekDates = [];
        for ($i = 0; $i < 7; $i++) {
            $weekDates[] = $today->copy()->addDays($i);
        }

        // ユーザー一覧を取得
        $userName = User::paginate(5);
        $users = User::all();

        // ユーザーごとに1週間分の勤怠を取得
        $attendanceData = [];
        foreach ($users as $user) {
            $attendanceData[$user->id] = Attendance::where('user_id', $user->id)
                ->where('created_at', '>=', $today)
                ->where('created_at', '<', $today->copy()->addDays(7))
                ->get();
        }

        return view('users', ['users' => $users, 'userName' => $userName, 'weekDates' => $weekDates, 'attendanceData' => $attendanceData]);
    }
}
