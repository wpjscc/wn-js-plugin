<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsJss extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_jss', function($table)
        {
            $table->text('name');
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_jss', function($table)
        {
            $table->dropColumn('name');
        });
    }
}
