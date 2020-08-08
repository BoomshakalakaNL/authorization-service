<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysPermissionActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permission_activities', function (Blueprint $table) {
            $table->foreign('permission_id', 'permission_activities_permission_id_foreign')->references('id')->on('permissions');
            $table->foreign('activity_id', 'permission_activities_activity_id_foreign')->references('id')->on('activities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_activities', function (Blueprint $table) {
            $table->dropForeign('permission_activities_permission_id_foreign');
            $table->dropForeign('permission_activities_activity_id_foreign');
        });
    }
}
