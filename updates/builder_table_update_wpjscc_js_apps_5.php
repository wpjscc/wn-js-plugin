<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsApps5 extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_apps', function($table)
        {
            $table->renameColumn('slug', 'identifier');
            $table->dropColumn('config');
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_apps', function($table)
        {
            $table->renameColumn('identifier', 'slug');
            $table->text('config')->nullable();
        });
    }
}
