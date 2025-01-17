<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMethodsToolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('methods_tools', function (Blueprint $table) {
            $table->id();
            $table->string('CODE');
			$table->string('LABEL')->nullable();
			$table->integer('ETAT');
            $table->decimal('COST', 11, 3)->nullable();
			$table->string('PICTURE')->nullable();
			$table->date('END_DATE')->nullable();
			$table->text('COMMENT')->nullable();
			$table->integer('QTY');
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
        Schema::dropIfExists('methods_tools');
    }
}
