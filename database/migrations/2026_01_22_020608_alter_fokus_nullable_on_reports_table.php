<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->string('fokus_1')->nullable()->change();
            $table->string('fokus_2')->nullable()->change();
            $table->string('fokus_3')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->string('fokus_1')->nullable(false)->change();
            $table->string('fokus_2')->nullable(false)->change();
            $table->string('fokus_3')->nullable(false)->change();
        });
    }
};
