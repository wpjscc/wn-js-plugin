<?php namespace Wpjscc\Js\Models;

use Model;

/**
 * Model
 */
class JsApp extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'wpjscc_js_apps';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [
        'tags'
    ];

    public $belongsToMany = [

        'jss' => [
            'Wpjscc\Js\Models\Js',
            'table' => 'wpjscc_js_app_jss',
            'key' => 'app_id',
            'otherKey' => 'js_id'
        ],

        'csss' => [
            'Wpjscc\Js\Models\Css',
            'table' => 'wpjscc_js_app_csss',
            'key' => 'app_id',
            'otherKey' => 'css_id',
        ]
    ];


    public function beforeCreate()
    {
        if (!$this->identifier) {
            $this->identifier = \Str::random(10);
        }
    }
}
