<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysRolePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('role_permissions', function (Blueprint $table) {
            $table->foreign('role_id', 'role_permissions_role_id_foreign')->references('id')->on('roles');
            $table->foreign('permission_id', 'role_permissions_permission_id_foreign')->references('id')->on('permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_permissions', function (Blueprint $table) {
            $table->dropForeign('role_permissions_role_id_foreign');
            $table->dropForeign('role_permissions_permission_id_foreign');
        });
    }
}
