<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsApps extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_apps', function($table)
        {
            $table->text('config')->nullable()->change();
            $table->text('js')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_apps', function($table)
        {
            $table->text('config')->nullable(false)->change();
            $table->text('js')->nullable(false)->change();
        });
    }
}
