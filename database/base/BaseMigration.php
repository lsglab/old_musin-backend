<?php

namespace Database\Base;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

abstract class BaseMigration extends Migration
{

    protected $table;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table->table, function (Blueprint $table) {
            $columns = $this->table->getTableColumns();
            foreach($columns as $column){
                $column->createDBColumn($table);
            }

            $identifiers = $this->table->getColumnNames($this->table->getIdentifiers());
            if(count($identifiers) > 1){
                $table->unique($identifiers);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table->table);
    }
}
