<?php namespace Wpjscc\Js\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Apps extends Controller
{
    public $implement = [        
        'Backend\Behaviors\ListController',        
        'Backend\Behaviors\FormController' ,
        'Backend\Behaviors\RelationController'  
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = [
        'wpjscc.jsapp.lists' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Wpjscc.Js', 'jsapp', 'jsapp');
    }
}
