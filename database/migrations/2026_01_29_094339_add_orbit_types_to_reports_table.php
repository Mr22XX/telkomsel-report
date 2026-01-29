<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->integer('sp_telkom')->default(0)->after('orbit');
            $table->integer('orbit_n1')->default(0)->after('sp_telkom');
            $table->integer('orbit_n2')->default(0)->after('orbit_n1');
            $table->integer('orbit_n2_new')->default(0)->after('orbit_n2');
            $table->integer('orbit_h2')->default(0)->after('orbit_n2_new');
            $table->integer('orbit_h2_np01')->default(0)->after('orbit_n2_new');
            $table->integer('orbit_h3')->default(0)->after('orbit_h2_np01');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            //
        });
    }
};
