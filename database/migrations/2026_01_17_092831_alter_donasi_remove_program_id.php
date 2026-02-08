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
    Schema::table('donasis', function (Blueprint $table) {
        $table->dropForeign(['program_id']);
        $table->dropColumn('program_id');
    });
}

public function down()
{
    Schema::table('donasis', function (Blueprint $table) {
        $table->foreignId('program_id')->constrained()->cascadeOnDelete();
    });
}

};
