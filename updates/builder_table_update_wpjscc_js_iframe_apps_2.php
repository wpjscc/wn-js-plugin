<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsIframeApps2 extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_iframe_apps', function($table)
        {
            $table->text('html');
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_iframe_apps', function($table)
        {
            $table->dropColumn('html');
        });
    }
}
