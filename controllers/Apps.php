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
    
    public $listConfig = [
        'list' => 'config_list.yaml',
        'iframe' => 'config_list_iframe.yaml',
    ];
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


    public function index()
    {
        // 在列表页创建关系
        if (post('_relation_field') && strlen(post('update_record_id'))>0){
            // link 的时候record_id 会和选中的ID重复
            $this->vars['updateRecordId'] = post('update_record_id');
            $model = $this->formFindModelObject(post('update_record_id'));
            $this->initRelation($model);
        }

        $this->asExtension('ListController')->index();
    }


    public function onUpdateForm()
    {

        if (post('context') == 'iframe') {
            $this->asExtension('ListController')->index();
        }

        $this->asExtension('FormController')->update(post('update_record_id'), post('context'));
        $this->vars['updateRecordId'] = post('update_record_id');
        return $this->makePartial('update_form');
    }

    public function onUpdate()
    {
        $this->asExtension('FormController')->update_onSave(post('update_record_id'), post('context'));

    

        $model = $this->formFindModelObject(post('update_record_id'));

        if ($redirect = $this->makeRedirect('update-close', $model)) {
            return $redirect;
        }
    }

    public function formExtendFields($formWidget, $fields)
    {
        $fieldKeys = array_keys($fields);
        $customFields = post('custom_fields', []);
        if ($customFields) {
            foreach ($fieldKeys as $fieldKey) {
                if (!in_array($fieldKey, $customFields)) {
                    $formWidget->removeField($fieldKey);
                }
            }
        }

    }

}
