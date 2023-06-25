<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsAppJss3 extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_app_jss', function($table)
        {
            $table->integer('sort_order')->nullable()->default(100);
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_app_jss', function($table)
        {
            $table->dropColumn('sort_order');
        });
    }
}
