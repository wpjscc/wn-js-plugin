<?php namespace Wpjscc\Js\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateWpjsccJsIframeApps extends Migration
{
    public function up()
    {
        Schema::rename('wpjscc_js_iframes', 'wpjscc_js_iframe_apps');
    }
    
    public function down()
    {
        Schema::rename('wpjscc_js_iframe_apps', 'wpjscc_js_iframes');
    }
}
