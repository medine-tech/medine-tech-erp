<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('code');
            $table->string('description')->nullable();
            $table->string('status')->default('active');
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('updater_id');
        });
    }

    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['code', 'description', 'status', 'creator_id', 'updater_id']);
        });
    }

};
