<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsAppJss extends Migration
{
    public function up()
    {
        Schema::rename('wpjscc_js_app_jsss', 'wpjscc_js_app_jss');
    }
    
    public function down()
    {
        Schema::rename('wpjscc_js_app_jss', 'wpjscc_js_app_jsss');
    }
}
