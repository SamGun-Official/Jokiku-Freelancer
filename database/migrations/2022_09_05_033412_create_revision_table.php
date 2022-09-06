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
        Schema::create('revision', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->index('fk_revision_to_service');
            $table->foreignId('users_id')->nullable()->index('fk_revision_users_to_users');
            $table->foreignId('freelancer_id')->nullable()->index('fk_revision_freelancer_to_users');
            $table->longText('description_revision')->nullable();
            $table->integer('revision_ke');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revision');
    }
};
