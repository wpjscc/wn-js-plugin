<?php namespace Wpjscc\Js\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Wpjscc\Js\Models\JsApp;
use Wpjscc\Js\Models\Js;
use Wpjscc\Js\Models\Css;

class Index extends Controller
{
    public $implement = [    ];

    public $suppressLayout = true;

    protected $publicActions = [
        'html',
        'app',
        'index',
        'js',
        'css',
        'action',
    ];

    
    public function __construct()
    {
        parent::__construct();
    }

    public function html($identifier = null)
    {
        $this->vars['identifier'] = $identifier;
    }

    public function app($identifier = null)
    {
        $appjs = file_get_contents(plugins_path(
            'wpjscc/js/assets/js/app.js'
        ));
        $appjs = str_replace(
            '{{endpoint}}',
            \Url::to('backend/wpjscc/js/index/index/'.$identifier),
            $appjs
        );
        $appjs = str_replace(
            '{{endpoint_html}}',
            \Url::to('backend/wpjscc/js/index/html/'.$identifier),
            $appjs
        );
        return response(
            $appjs,
            200, 
            ['Content-Type' => 'text/javascript']
        );
    }


    public function index($identifier = null)
    {
        $jsApp = JsApp::where('identifier', $identifier)->firstOrFail();

        return response()->json([
            'js' => $this->getJssByJsApp($jsApp),
            'css' => $this->getCsssByJsApp($jsApp),
            'action' => $this->getActionsByJsApp($jsApp)
        ]);
    }

    public function js($identifier = null)
    {
        return response(
            Js::where('identifier', $identifier)->first()->content ?? '',
            200,
            ['Content-Type' => 'text/javascript']
        );
    }

    public function css($identifier = null)
    {
        return response(
            Css::where('identifier', $identifier)->first()->content ?? '',
            200,
            ['Content-Type' => 'text/css']
        );
    }


    public function action($identifier = null)
    {
        return response(
            JsApp::where('identifier', $identifier)->first()->js ?? '',
            200,
            ['Content-Type' => 'text/javascript']
        );
    }


    protected function getJssByJsApp($jsApp)
    {
        $jss = [];

        $localJss = $jsApp->jss->where('type', 'local');
        $remoteJss = $jsApp->jss->where('type', 'remote');
        $databaseJss = $jsApp->jss->where('type', 'database'); 

        foreach ($localJss as $localJs) {
            $jss[] = $this->combineAssets([
                $localJs->link
            ], $this->getLocalPath($localJs->assetPath ?: $this->assetPath));
        }

        foreach ($remoteJss as $remoteJs) {
            $jss[] = $remoteJs->link;
        }

        foreach ($databaseJss as $databaseJs) {
            $jss[] = \Url::to('backend/wpjscc/js/index/js/'.$databaseJs->identifier);
        }

        return $jss;
    }

    protected function getCsssByJsApp($jsApp)
    {
        $csss = [];
        $localCss = $jsApp->csss->where('type', 'local');
        $remoteCss = $jsApp->csss->where('type', 'remote');
        $databaseCss = $jsApp->csss->where('type', 'database');

        foreach ($localCss as $localCs) {
            $csss[] = $this->combineAssets([
                $localCs->link
            ], $this->getLocalPath($localCs->assetPath ?: $this->assetPath));
        }

        foreach ($remoteCss as $remoteCs) {
            $csss[] = $remoteCs->link;
        }

        foreach ($databaseCss as $databaseCs) {
            $csss[] = \Url::to('backend/wpjscc/js/index/css/'.$databaseCs->identifier);
        }

        return $csss;
    }

    protected function getActionsByJsApp($jsApp)
    {
        return [
            \Url::to('backend/wpjscc/js/index/action/'.$jsApp->identifier)
        ];
    }


}
