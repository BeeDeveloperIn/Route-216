<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblMkDirectoriesItemsAddColumnDirectoryTypeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('directories_items', function($table) {
            $table->integer('directory_type_id')->nullable()->after('directory_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('directories_items', function($table) {
            $table->dropColumn('directory_type_id');
        });
    }
}
