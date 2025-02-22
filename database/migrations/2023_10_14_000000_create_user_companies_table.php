<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCompaniesTable extends Migration
{
    public function up(): void
    {
        Schema::create('user_companies', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->uuid('company_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('uuid')->on('companies')->onDelete('cascade');
            $table->primary(['user_id', 'company_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_companies');
    }
}
