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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 30)->nullable(false);
            $table->string('sobrenome', 30)->nullable(false);
            $table->string('telefone', 20)->nullable(false);
            $table->text('observacoes')->nullable(true);
            $table->string('bairro', 50)->nullable(false);
            $table->string('rua', 100)->nullable(false);
            $table->integer('numero')->nullable(false);
            $table->double('valor')->nullable(false);
            $table->boolean('status')->nullable(false);

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
        Schema::dropIfExists('pedidos');
    }
};
