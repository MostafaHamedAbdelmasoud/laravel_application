<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->decimal('price')->nullable();
            $table->integer('count')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
