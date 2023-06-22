<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsApps3 extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_apps', function($table)
        {
            $table->string('slug', 100);
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_apps', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
