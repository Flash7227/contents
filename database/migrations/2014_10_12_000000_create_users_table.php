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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role')->default(0);
            $table->json('permissions');
            $table->string('storage_limit')->default("0");
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert(
            array(
                'name' => 'Administrator',
                'email' => 'admin@admin.admin',
                'permissions' => json_encode([]),
                'storage_limit' => '0',
                'password' =>  Hash::make('12345678'),
                'role' => 1
            )
        );
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
