<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsCsss2 extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_csss', function($table)
        {
            $table->string('asset_path', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_csss', function($table)
        {
            $table->dropColumn('asset_path');
        });
    }
}
