<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->unique(['name','subject_id']);
            $table->string("name");
            $table->string("type");
            $table->boolean("required");
            $table->boolean("unique");
            $table->boolean("hidden");
            $table->boolean("is_display_name");
            $table->boolean("identifier");
            $table->string("function_name")->nullable();
            $table->string("default")->nullable();
            $table->integer("relation")->nullable();
            $table->string("relation_type")->nullable();
            $table->string("enum")->nullable();
            $table->foreignId('creator_id');
            $table->foreignId("subject_id")->constrained();
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
        Schema::dropIfExists('attributes');
    }
}
