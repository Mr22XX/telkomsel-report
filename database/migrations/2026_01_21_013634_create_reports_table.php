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
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        $table->date('tanggal');
        $table->string('tap');
        $table->string('nama_sales');
        $table->string('fokus_1');
        $table->string('fokus_2');
        $table->string('fokus_3');
        $table->integer('perdana')->default(0);
        $table->integer('byu')->default(0);
        $table->integer('lite')->default(0);
        $table->integer('orbit')->default(0);
        $table->integer('cvm_byu')->default(0);
        $table->integer('super_seru')->default(0);
        $table->integer('digital')->default(0);
        $table->integer('roaming')->default(0);

        $table->integer('vf_hp')->default(0);
        $table->integer('vf_lite_byu')->default(0);
        $table->integer('lite_vf')->default(0);
        $table->integer('byu_vf')->default(0);
        
        $table->integer('my_telkomsel')->default(0);
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
