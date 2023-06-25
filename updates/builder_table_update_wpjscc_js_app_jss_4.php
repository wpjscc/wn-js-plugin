<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsAppJss4 extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_app_jss', function($table)
        {
            $table->smallInteger('is_preload')->nullable()->default(0);
            $table->dropColumn('sort_order');
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_app_jss', function($table)
        {
            $table->dropColumn('is_preload');
            $table->integer('sort_order')->nullable()->default(100);
        });
    }
}
