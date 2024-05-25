<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameTimeToPeriodInRecipesTable extends Migration
{
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            if (Schema::hasColumn('recipes', 'time')) {
                $table->renameColumn('time', 'period');
            } elseif (!Schema::hasColumn('recipes', 'period')) {
                $table->string('period')->after('category');
            }
        });
    }

    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            if (Schema::hasColumn('recipes', 'period')) {
                $table->renameColumn('period', 'time');
            } elseif (!Schema::hasColumn('recipes', 'time')) {
                $table->time('time')->after('category');
            }
        });
    }
}



