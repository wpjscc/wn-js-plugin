<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateWpjsccJsAppCsss extends Migration
{
    public function up()
    {
        Schema::create('wpjscc_js_app_csss', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('app_id')->default(0);
            $table->integer('css_id')->default(0);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('wpjscc_js_app_csss');
    }
}
