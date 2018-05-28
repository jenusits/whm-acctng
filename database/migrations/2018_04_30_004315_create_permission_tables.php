<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('permission_id');
            $table->morphs('model');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'model_id', 'model_type']);
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->morphs('model');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->primary(['role_id', 'model_id', 'model_type']);
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);

            app('cache')->forget('spatie.permission.cache');
        });


        // create permissions
        Permission::create(['name' => 'users']);
        Permission::create(['name' => 'roles']);
        Permission::create(['name' => 'permissions']);
        Permission::create(['name' => 'view settings']);

        Permission::create(['name' => 'view charts']);
        Permission::create(['name' => 'create charts']);
        Permission::create(['name' => 'update charts']);
        Permission::create(['name' => 'delete charts']);

        /* Permission::create(['name' => 'view request_funds']);
        Permission::create(['name' => 'create request_funds']);
        Permission::create(['name' => 'update request_funds']);
        Permission::create(['name' => 'delete request_funds']);
        Permission::create(['name' => 'approve request_funds']); */
        
        Permission::create(['name' => 'view bank']);
        Permission::create(['name' => 'create bank']);
        Permission::create(['name' => 'update bank']);
        Permission::create(['name' => 'delete bank']);

        Permission::create(['name' => 'view expenses']);
        Permission::create(['name' => 'create expenses']);
        Permission::create(['name' => 'update expenses']);
        Permission::create(['name' => 'delete expenses']);
        Permission::create(['name' => 'approve expenses']);

        Permission::create(['name' => 'view payment_method']);
        Permission::create(['name' => 'create payment_method']);
        Permission::create(['name' => 'update payment_method']);
        Permission::create(['name' => 'delete payment_method']);

        Permission::create(['name' => 'view payee']);
        Permission::create(['name' => 'create payee']);
        Permission::create(['name' => 'update payee']);
        Permission::create(['name' => 'delete payee']);

        Permission::create(['name' => 'view bill']);
        Permission::create(['name' => 'create bill']);
        Permission::create(['name' => 'update bill']);
        Permission::create(['name' => 'delete bill']);
        Permission::create(['name' => 'approve bill']);

        Permission::create(['name' => 'view check']);
        Permission::create(['name' => 'create check']);
        Permission::create(['name' => 'update check']);
        Permission::create(['name' => 'delete check']);
        Permission::create(['name' => 'approve check']);
        
        $role = Role::create(['name' => 'super-admin']);
        // Create a User and Set it to Admin
        $super_admin = \App\User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@test.com',
            'password' => \Hash::make('superadmin'),
        ]);
        $user_id = $super_admin->id;
        $sa = \App\User::find($user_id);
        $sa->assignRole('super-admin');
        $role->syncPermissions(Permission::all());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}
