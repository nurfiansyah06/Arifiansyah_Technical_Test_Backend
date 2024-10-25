<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin', 'guard_name' => 'api']);
        $customerServiceRole = Role::firstOrCreate(['name' => 'customerservice', 'guard_name' => 'api']);
        $salesPersonRole = Role::firstOrCreate(['name' => 'salesperson', 'guard_name' => 'api']);
        $operationRole = Role::firstOrCreate(['name' => 'operation', 'guard_name' => 'api']);
        $clientRole = Role::firstOrCreate(['name' => 'client', 'guard_name' => 'api']);

        Permission::firstOrCreate(['name' => 'create-lead', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'update new_leads', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'delete-lead', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'read-lead', 'guard_name' => 'api']);   

        // sales
        Permission::firstOrCreate(['name' => 'update follow_up_leads', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'update deal', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'update follow_up_final', 'guard_name' => 'api']);

        // operation
        Permission::firstOrCreate(['name' => 'update survey_request', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'update survey_report', 'guard_name' => 'api']);

        $customerServiceRole->givePermissionTo(['update new_leads', 'create-lead', 'delete-lead', 'read-lead']);
        $salesPersonRole->givePermissionTo(['update follow_up_leads','update deal', 'update follow_up_final']);
        $operationRole->givePermissionTo(['update survey_request', 'update survey_report']);
        $superAdminRole->givePermissionTo(Permission::all());
    }
}
