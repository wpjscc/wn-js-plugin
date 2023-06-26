<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateWpjsccJsAppServices extends Migration
{
    public function up()
    {
        Schema::create('wpjscc_js_app_services', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('appable_id')->default(0);
            $table->string('appable_type', 100);
            $table->integer('service_id')->default(0);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('wpjscc_js_app_services');
    }
}
