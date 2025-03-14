<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertPermissionsIntoPermissionsTable extends Migration
{
    public function up(): void
    {
        $permissions = [
            // Accounting Accounts
            ['name' => 'backoffice.accounting.accounting-accounts.created', 'guard_name' => 'sanctum'],
            ['name' => 'backoffice.accounting.accounting-accounts.updated', 'guard_name' => 'sanctum'],
            ['name' => 'backoffice.accounting.accounting-accounts.view', 'guard_name' => 'sanctum'],

            // Accounting Centers
            ['name' => 'backoffice.accounting.accounting-centers.create', 'guard_name' => 'sanctum'],
            ['name' => 'backoffice.accounting.accounting-centers.view', 'guard_name' => 'sanctum'],
            ['name' => 'backoffice.accounting.accounting-centers.update', 'guard_name' => 'sanctum'],

            // Companies
            ['name' => 'backoffice.companies.create', 'guard_name' => 'sanctum'],
            ['name' => 'backoffice.companies.update', 'guard_name' => 'sanctum'],
            ['name' => 'backoffice.companies.view', 'guard_name' => 'sanctum'],

            // Security Roles
            ['name' => 'backoffice.security.roles.create', 'guard_name' => 'sanctum'],
            ['name' => 'backoffice.security.roles.view', 'guard_name' => 'sanctum'],
            ['name' => 'backoffice.security.roles.update', 'guard_name' => 'sanctum'],

            // Users
            ['name' => 'backoffice.users.create', 'guard_name' => 'sanctum'],
            ['name' => 'backoffice.users.update', 'guard_name' => 'sanctum'],
            ['name' => 'backoffice.users.view', 'guard_name' => 'sanctum'],
        ];

        DB::table('permissions')->insert($permissions);
    }

    public function down(): void
    {
        DB::table('permissions')->whereIn('name', [
            'backoffice.accounting.accounting-accounts.created',
            'backoffice.accounting.accounting-accounts.updated',
            'backoffice.accounting.accounting-accounts.view',
            'backoffice.accounting.accounting-centers.create',
            'backoffice.accounting.accounting-centers.view',
            'backoffice.accounting.accounting-centers.update',
            'backoffice.companies.create',
            'backoffice.companies.update',
            'backoffice.companies.view',
            'backoffice.security.roles.create',
            'backoffice.security.roles.view',
            'backoffice.security.roles.update',
            'backoffice.users.create',
            'backoffice.users.update',
            'backoffice.users.view',
        ])->delete();
    }
}
