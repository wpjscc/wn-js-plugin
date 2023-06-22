<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateWpjsccJsApps extends Migration
{
    public function up()
    {
        Schema::create('wpjscc_js_apps', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('name', 255);
            $table->text('config');
            $table->text('js');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('wpjscc_js_apps');
    }
}
