<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPreviousExperiencesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('previous_experiences', function (Blueprint $table) {
            $table->foreignId('user_id')->
                    constrained()->
                    onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('previous_experiences', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
}
