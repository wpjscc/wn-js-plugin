<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsJss2 extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_jss', function($table)
        {
            $table->string('identifier', 10);
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_jss', function($table)
        {
            $table->dropColumn('identifier');
        });
    }
}
