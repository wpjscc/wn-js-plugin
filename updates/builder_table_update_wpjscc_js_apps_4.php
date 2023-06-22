<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsApps4 extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_apps', function($table)
        {
            $table->string('tags', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_apps', function($table)
        {
            $table->dropColumn('tags');
        });
    }
}
