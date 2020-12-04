<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('phone_verified')->after('email_verified_at')->nullable();
            $table->unsignedBigInteger('city_id')->after('phone_verified')->nullable();
            $table->foreign('city_id')->references('id')
                ->on('cities')
                ->cascadeOnDelete();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('city_id');
            $table->dropColumn('phone_verified');
        });
        Schema::enableForeignKeyConstraints();
    }
}
