<?php namespace Wpjscc\Js\Models;

use Model;

/**
 * Model
 */
class Css extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    use \Winter\Storm\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'wpjscc_js_csss';

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



    public function beforeCreate()
    {
        if (!$this->identifier) {
            $this->identifier = \Str::random(10);
        }
    }
}
