<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('detailed_title')->nullable();
            $table->longText('details')->nullable();
            $table->date('add_date')->nullable();
            $table->string('price')->nullable();
            $table->string('phone_number')->nullable();
            $table->boolean('approved')->default(0);
            $table->boolean('added_by_admin')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
