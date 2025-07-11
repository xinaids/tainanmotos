<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('moto', function (Blueprint $table) {
        $table->string('cor', 30)->nullable();
    });
}

public function down()
{
    Schema::table('moto', function (Blueprint $table) {
        $table->dropColumn('cor');
    });
}

};
