<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('deliveryman_id');
            $table->foreign('deliveryman_id')
                    ->references('id')
                    ->on('deliverymans')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            $table->string('empresa')->nullable();      
            $table->string('bloco');
            $table->string('apartamento');
            $table->char('status', 1);
            $table->dateTime('saida')->nullable();
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
        Schema::dropIfExists('records');
    }
}
