<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('moto', function (Blueprint $table) {
            $table->string('cpf_usuario', 11)->after('ano');
        });
    }

    public function down(): void
    {
        Schema::table('moto', function (Blueprint $table) {
            $table->dropColumn('cpf_usuario');
        });
    }
};
