<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingAccountsTable extends Migration
{
    public function up(): void
    {
        Schema::create('backoffice__accounting__accounting_accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('name');
            $table->string('description')->nullable();
            $table->tinyInteger('type');
            $table->string('status')->default('active');
            $table->uuid('parent_id')->nullable();
            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('updater_id');
            $table->uuid('company_id');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('backoffice__accounting__accounting_accounts');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('updater_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('backoffice__accounting__accounting_accounts');
    }
}
