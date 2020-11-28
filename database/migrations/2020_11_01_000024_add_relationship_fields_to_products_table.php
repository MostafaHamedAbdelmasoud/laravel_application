<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProductsTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('trader_id')->nullable();
            $table->foreign('trader_id', 'trader_fk_2504438')->references('id')->on('traders');
        });
        Schema::enableForeignKeyConstraints();
    }
}
