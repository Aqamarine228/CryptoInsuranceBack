<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        !config('admin.default_admin.email')
        && !config('admin.default_admin.password')
        && throw new RuntimeException('No default admin email or password provided.');

        DB::table('admins')->insert([
            'name' => 'Admin',
            'email' => config('admin.default_admin.email'),
            'password' => Hash::make(config('admin.default_admin.password')),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
