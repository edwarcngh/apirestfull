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
        Schema::create('communes', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->integer('id_com');
            $table->integer('id_reg');
            $table->string('description', 90);
            $table->enum('status', array('A', 'I', 'trash'))->default('A');
            $table->timestamps();

            $table->primary(array('id_com', 'id_reg'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communes');
    }
};
