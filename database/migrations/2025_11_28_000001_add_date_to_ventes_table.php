<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ventes', function (Blueprint $table) {
            // date de la vente (nullable pour rétrocompatibilité)
            $table->dateTime('date')->nullable()->after('image');
        });
    }

    public function down()
    {
        Schema::table('ventes', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }
};
