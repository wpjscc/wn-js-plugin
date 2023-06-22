<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsCsss extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_csss', function($table)
        {
            $table->string('identifier', 10);
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_csss', function($table)
        {
            $table->dropColumn('identifier');
        });
    }
}
