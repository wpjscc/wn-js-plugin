<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsIframes extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_iframes', function($table)
        {
            $table->dropColumn('css');
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_iframes', function($table)
        {
            $table->text('css')->nullable();
        });
    }
}
