<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('displayName');
            $table->string('description');
            $table->string('type');
            $table->boolean('authenticatable');
            // -> this variable determines whether the subject is editable
            // this is mostly used for native subjects like role or user because
            // they should not be edited once created not even by super admins
            $table->boolean('editable');
            $table->string('model')->unique();
            $table->string('table')->unique();
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
        Schema::dropIfExists('subjects');
    }
}
