<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('username', 60)->unique();
            $table->string('password', 36);
            $table->string('name', 80)->nullable();
            $table->string('email')->nullable();
            $table->text('avatar')->nullable();
            $table->integer('role_id')->unsigned()->nullable();
            $table->string('api_token')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function($table) {
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
