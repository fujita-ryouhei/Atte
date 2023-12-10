<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rests', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('Attendance_id');
            $table->timestamp('start_break')->nullable();
            $table->timestamp('end_break')->nullable();
            $table->integer('rest_duration')->nullable(); // 休憩時間（秒単位など）
            $table->timestamps();
            
            
            $table->foreign('Attendance_id')->references('id')->on('attendances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rests');
    }
}
