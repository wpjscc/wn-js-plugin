<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsJss3 extends Migration
{
    public function up()
    {
        Schema::table('wpjscc_js_jss', function($table)
        {
            $table->string('name', 255)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('wpjscc_js_jss', function($table)
        {
            $table->text('name')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
