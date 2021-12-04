<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupedPositionablesTable extends Migration
{
    public function up(): void
    {
        Schema::create('grouped_positionables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->tinyInteger('position');
            $table->timestamps();

            $table->index(['type', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grouped_positionables');
    }
}
