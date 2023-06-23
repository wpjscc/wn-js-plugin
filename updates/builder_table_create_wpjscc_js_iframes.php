<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateWpjsccJsIframes extends Migration
{
    public function up()
    {
        Schema::create('wpjscc_js_iframes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('name', 255)->nullable();
            $table->text('js')->nullable();
            $table->text('css')->nullable();
            $table->string('tags', 255);
            $table->string('identifier', 100);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('wpjscc_js_iframes');
    }
}
