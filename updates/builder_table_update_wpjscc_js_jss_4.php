<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsJss4 extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_jss', function($table)
        {
            $table->string('asset_path', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_jss', function($table)
        {
            $table->dropColumn('asset_path');
        });
    }
}
