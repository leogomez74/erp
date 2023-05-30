<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddPermissionCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
    public function down()
    {
        
    }
}
