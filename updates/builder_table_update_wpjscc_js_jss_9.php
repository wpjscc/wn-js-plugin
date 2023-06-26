<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsJss9 extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_jss', function($table)
        {
            $table->renameColumn('attributes', 'attrs');
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_jss', function($table)
        {
            $table->renameColumn('attrs', 'attributes');
        });
    }
}
