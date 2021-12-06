<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionablesTable extends Migration
{
    public function up(): void
    {
        Schema::create('positionables', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('index')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('positionables');
    }
}
