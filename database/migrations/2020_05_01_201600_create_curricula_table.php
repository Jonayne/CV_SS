<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculaTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('curricula', function (Blueprint $table) {
            $table->id();    
            $table->timestamps();
            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('domicilio_calle')->nullable();
            $table->string('domicilio_num_ext')->nullable();
            $table->string('domicilio_num_int')->nullable();
            $table->string('domicilio_cp')->nullable();
            $table->string('domicilio_colonia')->nullable();
            $table->string('domicilio_delegacion')->nullable();
            $table->string('fotografia')->nullable();
            $table->string('ocupacion_actual')->nullable();
            $table->string('estudios_grado_maximo_estudios')->nullable();
            $table->string('estudios_escuela')->nullable();
            $table->string('estudios_carrera')->nullable();
            $table->string('estudios_estatus')->nullable();
            $table->string('estudios_documento_obtenido')->nullable();
            $table->string('categoria_de_pago')->nullable();
            $table->enum('tipo_contratacion', ['UNAM', 'Externo'])->nullable();
            $table->string('num_proveedor_UNAM')->nullable();
            $table->string('num_autorizacion_de_impresion')->nullable();
            $table->string('num_ife')->nullable();
            $table->string('curp')->nullable();
            $table->string('rfc')->nullable();
            $table->text('dias_disponibles')->nullable();
            $table->text('disponibilidad_horario')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('email_personal')->nullable();
            $table->string('email_cursos_linea')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('celular')->nullable();
            $table->string('twitter')->nullable();
            $table->string('tel_casa')->nullable();
            $table->string('tel_oficina')->nullable();
            $table->string('tel_recado')->nullable();
            $table->boolean('proyecto_sep')->nullable();
            $table->string('registro_secretaria_de_trabajo_y_prevision_social')->nullable();
            $table->text('cursos_impartir_sdpc')->nullable();
            $table->string('cedula_profesional')->nullable();
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::dropIfExists('curricula');
    }
}
