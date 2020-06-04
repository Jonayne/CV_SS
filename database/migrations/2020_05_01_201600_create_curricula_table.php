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
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('domicilio_calle');
            $table->string('domicilio_num_ext');
            $table->string('domicilio_num_int')->nullable();
            $table->string('domicilio_cp');
            $table->string('domicilio_colonia');
            $table->string('domicilio_delegacion');
            $table->string('fotografia'); 
            $table->string('ocupacion_actual')->nullable();
            $table->string('estudios_grado_maximo_estudios');
            $table->string('estudios_escuela');
            $table->string('estudios_carrera');
            $table->string('estudios_estatus');
            $table->string('estudios_documento_obtenido');
            $table->string('categoria_de_pago')->nullable();
            $table->text('certificaciones_obtenidas')->nullable();;
            $table->enum('tipo_contratacion', ['UNAM', 'Externo']);
            $table->string('num_proveedor_UNAM')->nullable();;
            $table->string('num_autorizacion_de_impresion')->nullable();
            $table->string('num_ife')->nullable();;
            $table->string('curp');
            $table->string('rfc');
            $table->text('dias_disponibles');
            $table->text('disponibilidad_horario');
            $table->date('fecha_nacimiento');
            $table->string('email_personal');
            $table->string('email_cursos_linea')->nullable();
            $table->string('nacionalidad');
            $table->string('celular')->nullable();
            $table->string('twitter')->nullable();
            $table->string('tel_casa')->nullable();
            $table->string('tel_oficina')->nullable();
            $table->string('tel_recado')->nullable();
            $table->string('registro_secretaria_de_trabajo_y_prevision_social')->nullable();
            $table->string('cursos_impartir_sdpc')->nullable();
            $table->string('cedula_profesional')->nullable();
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
