<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rest;

class Attendance extends Model
{
    use HasFactory;

    public function punchIn()
    {
        $this->start_time = now();
        $this->save();
    }

    public function punchOut()
    {
        $this->end_time = now();
        $this->save();
    }

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

    public function rests()
    {
        return $this->hasMany(Rest::class);
    }
}
