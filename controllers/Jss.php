<?php namespace Wpjscc\Js\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Jss extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'wpjscc.jsapp.lists' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Wpjscc.Js', 'jsapp', 'jsapp-js');
    }
}
