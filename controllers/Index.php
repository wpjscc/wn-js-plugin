<?php namespace Wpjscc\Js\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Wpjscc\Js\Models\JsApp;
use Wpjscc\Js\Models\IframeApp;
use Wpjscc\Js\Models\Js;
use Wpjscc\Js\Models\Css;

class Index extends Controller
{
    public $implement = [    ];

    public $suppressLayout = true;

    protected $publicActions = [
        'html',
        'iframe',
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

    public function html($identifier, $app = 'JsApp')
    {
        $this->validateApp($app);
        $query = http_build_query(request()->query());

        $this->vars['url'] = \Url::to('backend/wpjscc/js/index/app/'.$identifier.'/'.$app).'?'.$query;

    }

    public function app($identifier, $app = 'JsApp')
    {
        $appjs = file_get_contents(plugins_path(
            'wpjscc/js/assets/js/app.js'
        ));
        $query = http_build_query(request()->query());
        $appjs = str_replace(
            '{{endpoint}}',
            \Url::to('backend/wpjscc/js/index/index/'.$identifier.'/'.$app).'?'.$query,
            $appjs
        );
        return response(
            $appjs,
            200, 
            ['Content-Type' => 'text/javascript']
        );
    }


    public function index($identifier, $appType = 'JsApp')
    {
        $this->validateApp($appType);

        $class = '\Wpjscc\Js\Models\\'.$appType;

        $app = $class::where('identifier', $identifier)->firstOrFail();

        return response()->json([
            'js' => $this->getJssByApp($app),
            'css' => $this->getCsssByApp($app),
            'action' => $this->getActionsByApp($app, $appType)
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


    public function action($identifier, $app = 'JsApp')
    {
        $this->validateApp($app);

        $class = '\Wpjscc\Js\Models\\'.$app;

        $js = $class::where('identifier', $identifier)->first()->js ?? '';
        $js = str_replace('\'{{query}}\'', json_encode(request()->query()), $js);
        return response(
            $js,
            200,
            ['Content-Type' => 'text/javascript']
        );
    }

    protected function validateApp($app)
    {
        if (!in_array($app, ['JsApp', 'IframeApp'])) {
            throw new \Exception('Invalid app type');
        }
    }


    protected function getJssByApp($jsApp)
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

    protected function getCsssByApp($jsApp)
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

    protected function getActionsByApp($jsApp, $appType)
    {
        $query = http_build_query(request()->query());

        return [
            \Url::to('backend/wpjscc/js/index/action/'.$jsApp->identifier.'/'.$appType. '?'.$query)
        ];
    }


}
