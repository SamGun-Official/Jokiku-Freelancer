<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('revision', function (Blueprint $table) {
            $table->foreign('service_id','fk_revision_to_service')->references('id')->on('service')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('users_id','fk_revision_users_to_users')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('freelancer_id','fk_revision_freelancer_to_users')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('revision', function (Blueprint $table) {
            $table->dropForeign('fk_revision_to_service');
            $table->dropForeign('fk_revision_users_to_users');
            $table->dropForeign('fk_revision_freelancer_to_users');
        });
    }
};
