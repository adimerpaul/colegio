<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('carnet')->unique();
            $table->string('domicilio');
            $table->string('paterno');
            $table->string('materno');
            $table->string('nombres');
            $table->string('sexo');
            $table->string('celular')->nullable()->default('');
            $table->date('fechanac');
            $table->string('rude')->nullable()->default('');
//            $table->string('curso');
          //  $table->string('tipo')->default('NUEVO');
//            $table->string('paralelo');
            $table->date('fecha');
            $table->string('estado')->default('ACTIVO');
            $table->string('imagen')->default('user.png');
            $table->unsignedBigInteger('curso_id')->default(1);
            $table->foreign('curso_id')->references('id')->on('cursos');
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
        Schema::dropIfExists('estudiantes');
    }
}
