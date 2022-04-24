<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{

    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->longText('location')->nullable();
            $table->integer('floor');
            $table->integer('n_rooms');
            $table->integer('n_beds');
            $table->integer('n_bathroom');
            $table->integer('price');
            $table->longText('des')->nullable();
            $table->enum('type', [1,2,3]);
            $table->enum('gender', [1,2,3])->nullable();
            $table->enum('upload_state', [1,2,3]);
            $table->enum('state', [1,2]);
            $table->enum('internet', [1,2])-> nullable();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('place_id');
            $table->foreign('owner_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('place_id')
                ->references('id')->on('places')->onDelete('cascade');
            $table->boolean('in_favourite')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('apartments');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
