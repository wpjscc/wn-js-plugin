<?php

namespace Wpjscc\Js\Services;

use Wpjscc\Js\Models\Css;

class JsService
{

    use \System\Traits\AssetMaker;

    public function __construct($assetPath = '')
    {
        $this->assetPath = $assetPath;
    }


    public function downloadZip($identifier, $app = 'JsApp')
    {
        $this->validateApp($app);

        $dependencies = $this->getDependencies($identifier, $app);
        $temp_dir = sys_get_temp_dir(); 

        $zip = new \ZipArchive();
        $zipName = $identifier.'.zip';
        $zipPath = $temp_dir.'/'.$zipName;

        if ($zip->open($zipPath, \ZipArchive::CREATE) !== TRUE) {
            throw new \Exception("Cannot create zip file");
        }

        $script = '';
        foreach ($dependencies['preload_js'] as $js) {
            $zip->addFromString('preload/'.$js['name'], file_get_contents($js['url']));
            $script .= '<script src="preload/'.$js['name'].'"></script>'.PHP_EOL;
        }

        foreach ($dependencies['js'] as $js) {
            $zip->addFromString('js/'.$js['name'], file_get_contents($js['url']));
            $script .= '<script src="js/'.$js['name'].'"></script>'.PHP_EOL;
        }

        $styles = '';
        foreach ($dependencies['css'] as $css) {
            $zip->addFromString('css/'.$css['name'], file_get_contents($css['url']));
            $styles .= '<link rel="stylesheet" href="css/'.$css['name'].'">'.PHP_EOL;
        }

        foreach ($dependencies['action'] as $action) {
            $zip->addFromString('action/'.$action['name'], file_get_contents($action['url']));
            $script .= '<script src="action/'.$action['name'].'"></script>'.PHP_EOL;
        }

        $html = \Twig::parse(file_get_contents(plugins_path('wpjscc/js/assets/js/index.html')), [
            'html' => $this->getAppHtml($identifier, $app),
            'scripts' => $script,
            'styles' => $styles
        ]);

        $zip->addFromString('index.html', $html);


        $zip->close();

        return $zipPath;

    }



    public function getDependencies($identifier, $appType = 'JsApp')
    {
        $this->validateApp($appType);

        $class = '\Wpjscc\Js\Models\\'.$appType;

        $app = $class::where('identifier', $identifier)->firstOrFail();

        $serviceJss = $this->getJss($app->services);

        return [
            'preload_js' => $this->getJss($app->jss->where('pivot.is_preload', 1)),
            'js' => array_merge($this->getJss($app->jss->where('pivot.is_preload', 0)), $serviceJss),
            'css' => $this->getCsssByApp($app),
            'action' => $this->getActionsByApp($app, $appType)
        ];
    }



    protected function getJss($jssModels)
    {
        $jss = [];
        foreach($jssModels as $js) {
            if ($js->type == 'local') {
                $jss[] = [
                    'name' => $js->name,
                    'url' => $this->combineAssets([
                        $js->link
                    ], $this->getLocalPath($js->assetPath ?: $this->assetPath))
                ];
            } else if ($js->type == 'remote') {
                $jss[] = [
                    'name' => $js->name,
                    'url' => $js->link
                ];
            } else if ($js->type == 'database') {
                $classes = explode('\\', get_class($js));
                $type = array_pop($classes);
                $jss[] = [
                    'name' => $js->name,
                    'url' => \Url::to('backend/wpjscc/js/index/js/'.$js->identifier.'/'.$type)
                ];
            }
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
            $csss[] = [
                'name' => $localCs->name,
                'url' => $this->combineAssets([
                    $localCs->link
                ], $this->getLocalPath($localCs->assetPath ?: $this->assetPath))
            ];
        }

        foreach ($remoteCss as $remoteCs) {
            $csss[] = [
                'name' => $remoteCs->name,
                'url' => $remoteCs->link
            ];
        }

        foreach ($databaseCss as $databaseCs) {
            $csss[] = [
                'name' => $databaseCs->name,
                'url' => \Url::to('backend/wpjscc/js/index/css/'.$databaseCs->identifier)
            ];
        }

        return $csss;
    }

    public function getAppJs($identifier, $app = 'JsApp')
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
        return $appjs;
    }

    public function getJs($identifier = null, $type = 'Js')
    {
        $this->validateJsType($type);
        $class = '\Wpjscc\Js\Models\\'.$type;

        return  $class::where('identifier', $identifier)->first()->content ?? '';
    }

    public function getCss($identifier = null)
    {
       return Css::where('identifier', $identifier)->first()->content ?? '';
    }

    public function getAction($identifier, $app = 'JsApp')
    {
        $this->validateApp($app);

        $class = '\Wpjscc\Js\Models\\'.$app;

        $js = $class::where('identifier', $identifier)->first()->js ?? '';
        $js = str_replace('\'{{query}}\'', json_encode(request()->query()), $js);

        return $js;
    }
    public function getAppHtml($identifier, $app = 'JsApp')
    {
        $this->validateApp($app);

        $class = '\Wpjscc\Js\Models\\'.$app;

        return $class::where('identifier', $identifier)->first()->html ?? '';
    }


    protected function getActionsByApp($jsApp, $appType)
    {
        $query = http_build_query(request()->query());

        return [
            [
                'name' => $jsApp->name,
                'url' => \Url::to('backend/wpjscc/js/index/action/'.$jsApp->identifier.'/'.$appType. '?'.$query)
            ]
        ];
    }

    public function validateJsType($type)
    {
        if (!in_array($type, ['Js', 'Service'])) {
            throw new \Exception('Invalid js type');
        }
    }


    public function validateApp($app)
    {
        if (!in_array($app, ['JsApp', 'IframeApp'])) {
            throw new \Exception('Invalid app type');
        }
    }
}