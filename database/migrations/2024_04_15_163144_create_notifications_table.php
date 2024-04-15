<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('group')->nullable();
            $table->string('banner_type')->nullable();
            $table->string('title')->nullable();
            $table->text('banner_text')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date', 'group', 'banner_type', 'title', 'banner_text']);
        });
    }
};
