<?php namespace Wpjscc\Js\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Wpjscc\Js\Models\JsApp;
use Wpjscc\Js\Models\IframeApp;
use Wpjscc\Js\Models\Js;
use Wpjscc\Js\Services\JsService;

class Index extends Controller
{
    public $implement = [    ];

    public $suppressLayout = true;

    protected $jsService;

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

        $this->jsService = new JsService($this->assetPath);
    }


    public function download($identifier, $app = 'JsApp')
    {

        $zipPath = $this->jsService->downloadZip($identifier, $app);

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function html($identifier, $app = 'JsApp')
    {
        $this->jsService->validateApp($app);
        $query = http_build_query(request()->query());

        $this->vars['url'] = \Url::to('backend/wpjscc/js/index/app/'.$identifier.'/'.$app).'?'.$query;
        $this->vars['html'] = $this->jsService->getAppHtml($identifier, $app);
        $this->vars = array_merge($this->vars, $this->jsService->getJssAndCssTags($identifier, $app));
        

    }

    public function app($identifier, $app = 'JsApp')
    {
       
        return response(
            $this->jsService->getAppJs($identifier, $app),
            200, 
            ['Content-Type' => 'text/javascript']
        );
    }


    public function index($identifier, $appType = 'JsApp')
    {
        return response()->json($this->jsService->getDependencies($identifier, $appType));
    }

    public function js($identifier = null, $type = 'Js')
    {
        return response(
            $this->jsService->getJs($identifier, $type),
            200,
            ['Content-Type' => 'text/javascript']
        );
    }

    public function css($identifier = null)
    {
        return response(
            $this->jsService->getCss($identifier),
            200,
            ['Content-Type' => 'text/css']
        );
    }


    public function action($identifier, $app = 'JsApp')
    {
        return response(
            $this->jsService->getAction($identifier, $app),
            200,
            ['Content-Type' => 'text/javascript']
        );
    }

}
