<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestSampleTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('test_sample_table')) {
            Schema::create('test_sample_table', function (Blueprint $table) {
                $table->id();
                $table->string('name', 20)
                    ->unique();
                $table->tinyInteger('age')
                    ->unsigned();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_sample_table');
    }
}
