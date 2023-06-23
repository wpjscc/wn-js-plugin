<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsAppCsss extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_app_csss', function($table)
        {
            $table->string('appable_type', 100);
            $table->renameColumn('app_id', 'appable_id');
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_app_csss', function($table)
        {
            $table->dropColumn('appable_type');
            $table->renameColumn('appable_id', 'app_id');
        });
    }
}
