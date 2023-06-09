<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        //manage charges
        //create charges
        //edit charges
        Permission::create(['name' => 'manage charges']);
        Permission::create(['name' => 'create charges']);
        Permission::create(['name' => 'edit charges']);
        $role = Role::find(4);

        $companyPermissions = [
            ['name' => 'manage charges'],
            ['name' => 'create charges'],
            ['name' => 'edit charges'],

        ];

        $role->givePermissionTo($companyPermissions);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
};
