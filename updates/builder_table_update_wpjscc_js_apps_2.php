<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsApps2 extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_apps', function($table)
        {
            $table->string('name', 255)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_apps', function($table)
        {
            $table->string('name', 255)->nullable(false)->change();
        });
    }
}
