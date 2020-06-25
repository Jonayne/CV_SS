<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtracurricularCoursesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('extracurricular_courses', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_curso');
            $table->string('anio');
            $table->string('documento_obtenido');
            $table->boolean('es_curso_tecnico');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('extracurricular_courses');
    }
}
