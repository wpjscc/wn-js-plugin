<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateWpjsccJsServices extends Migration
{
    public function up()
    {
        Schema::create('wpjscc_js_services', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('type', 10);
            $table->string('link', 255);
            $table->text('content');
            $table->string('name', 255);
            $table->string('identifier', 10);
            $table->string('asset_path', 255)->nullable();
            $table->string('tags', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('wpjscc_js_services');
    }
}
