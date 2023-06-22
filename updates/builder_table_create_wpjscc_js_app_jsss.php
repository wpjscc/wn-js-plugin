<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateWpjsccJsAppJsss extends Migration
{
    public function up()
    {
        Schema::create('wpjscc_js_app_jsss', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('app_id')->default(0);
            $table->integer('js_id')->default(0);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('wpjscc_js_app_jsss');
    }
}
