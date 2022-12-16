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
        Schema::create('customers', function (Blueprint $table) {
            $table->engine = 'MyISAM';

            $table->string('dni', 45);
            $table->integer('id_reg');
            $table->integer('id_com');
            $table->string('email', 120);
            $table->string('name', 45);
            $table->string('last_name', 45);
            $table->string('address', 255);
            $table->dateTime('date_reg');
            $table->enum('status', array('A', 'I', 'trash'))->default('A');
            $table->timestamps();

            $table->primary(array('dni', 'id_reg', 'id_com'));
            $table->unique('email');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
