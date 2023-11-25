<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;

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
}
