<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateWpjsccJsJss extends Migration
{
    public function up()
    {
        Schema::create('wpjscc_js_jss', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('type', 10);
            $table->string('link', 255);
            $table->text('content')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('wpjscc_js_jss');
    }
}
