<?php

namespace app\site\controller;

use app\admin\model\App;
use app\admin\model\Site;

class Index extends Base
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';
    protected $layout = '';

    public function index()
    {
        return $this->view->fetch($this->tpl);
    }

    public function shoulu()
    {
        return $this->view->fetch($this->tpl);
    }

    public function sitedetail($id)
    {
        $site = cache('site:'.$id);
        if(!$site){
            $site = Site::findOrFail($id);
            cache('site:'.$id, $site);
        }
        $ip = request()->ip();
        if (empty(cookie('click:' . $ip))) {
            $site->clicks = $site->clicks + 1;
            $site->dclicks = $site->dclicks + 1;
            $site->save();
            cookie('click:' . $ip, $ip);
        }
        return redirect($site->url);
    }

    public function appdetail($id)
    {
        $app = cache('appinfo:'.$id);
        if (!$app)
        {
            $app = App::findOrFail($id);
            cache('appinfo:'.$id, $app);
        }

        $ip = request()->ip();
        if (empty(cookie('click:' . $ip))) {
            $app->clicks = $app->clicks + 1;
            $app->dclicks = $app->dclicks + 1;
            $app->save();
            cookie('click:' . $ip, $ip);
        }
        return view($this->tpl,[
            'app' => $app
        ]);
    }
}