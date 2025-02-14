<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblDirectoryTypeAddColumnUserIdAndAddedDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_directories_type', function($table) {
            $table->integer('user_id')->nullable()->after('title');
            $table->date('document_added_date')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_directories_type', function($table) {
            $table->dropColumn('user_id');
            $table->dropColumn('document_added_date');
        });
    }
}
