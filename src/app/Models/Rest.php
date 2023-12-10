<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;
use Auth;
use Illuminate\Support\Facades\Log;

class Rest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'attendance_id', 'start_break', 'end_break', 'rest_duration'];

    public function breakIn()
    {
        $this->start_break = now();
        $this->save();
    }

    public function breakOut()
    {
        $this->end_break = now();
        $this->save();
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function calculateAndSaveDuration()
    {
        $user = Auth::user();
        $Attendance = Attendance::where('user_id', $user->id)->latest()->first();

        $break = Rest::where('Attendance_id', $Attendance->id)->latest()->first();

        $start = \Carbon\Carbon::parse($break->start_break);
        $end = \Carbon\Carbon::parse($break->end_break);

        // 休憩時間（秒単位）を計算
        $duration = $start->diffInSeconds($end);

        // デバッグのために計算された休憩時間をログに出力
        Log::info("休憩時間（秒単位）: $duration");

        // 計算した休憩時間をデータベースに保存
        $break->update(['rest_duration' => $duration]);
    }
}
