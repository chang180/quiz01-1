<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\Image;
use App\Models\Ad;
use App\Models\Mvim;
use App\Models\News;
use Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('main',$this->home());
    }

    public function home(){
        $this->sideBar();

        $mvims = Mvim::select('id', 'img')->where('sh', 1)->get()->map(function ($val, $idx) {
            $val->show = ($idx == 0) ? true : false;
            $val->img = asset("storage/" . $val->img);
            return $val;
        });
        $news = News::select('id', 'text')->where('sh', 1)->get()->filter(function ($val, $idx) {
            if ($idx > 4) {
                $this->view['news']['more'] = ['show'=>true,'href'=>'/news'];
            } else {
                $val->short = mb_substr(str_replace("\r\n", " ", $val->text), 0, 20, 'utf8') . "...";
                $val->text = str_replace("\r\n", " ", nl2br($val->text));
                $val->show=false;
                
                $this->view['news']['more'] = ['show'=>false];
                return $val;
            }
        });
        // dd($news);


        $this->view['mvims'] = $mvims;
        $this->view['news']['data'] = $news;


        return $this->view;
    }

    //把畫面両側功能的程式拉出来再做一個方法給別的controller継承
    protected function sideBar()
    {
        $ads = implode('　　', Ad::where('sh', 1)->get()->pluck('text')->all());
        
        $menus = Menu::select('id', 'text', 'href')->where('sh', 1)->get();
        // foreach($menus as $key=>$menu){
            //     $menu->subs=$menu->subs;
        // $menus[$key]=$menu;
        // }
        foreach ($menus as $menu) {
            $menu->subs = $menu->subs;
            $menu->show = false;
        }
        
        
        if (Auth::user()) {
            $this->view['user'] = Auth::user();
        }
        
        
        // dd($menus);
        
        $images = Image::select('id', 'img')->where('sh', 1)->get()->map(function ($val, $idx) {
            $val->img = asset("storage/" . $val->img);
            if ($idx > 2) {
                $val->show = false;
            } else {
                $val->show = true;
            }
            return $val;
        });
        $this->view['ads'] = $ads;
        $this->view['menus'] = $menus;
        $this->view['images'] = ['data'=>$images,'page'=>0];

        $this->view['site']=[
            'ads'=>$ads,
            'title'=>$this->view['title'],
            'total'=>$this->view['total'],
            'bottom'=>$this->view['bottom'],
        ];
        // dd($this->view);
    }
}
