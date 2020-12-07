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
        $this->sideBar();
   
        $mvims = Mvim::where('sh', 1)->get();
$news=News::where('sh',1)->get()->filter(function($val,$idx){
if($idx>4){
$this->view['more']='/news';
}else{
    return $val;
}
});
// dd($news);

      
        $this->view['mvims'] = $mvims;
        $this->view['news']=$news;


        return view('main', $this->view);
    }

    //把畫面両側功能的程式拉出来再做一個方法給別的controller継承
    protected function sideBar()
    {
        $ads = implode('　　', Ad::where('sh', 1)->get()->pluck('text')->all());
        $this->view['ads'] = $ads;
        
        $menus = Menu::where('sh', 1)->get();
        // foreach($menus as $key=>$menu){
        //     $menu->subs=$menu->subs;
        // $menus[$key]=$menu;
        // }
        foreach ($menus as $menu) {
            $menu->subs = $menu->subs;
        }


        if(Auth::user()){
            $this->view['user']=Auth::user();
        }
        // dd($menus);
        $this->view['menus'] = $menus;

        $images = Image::where('sh', 1)->get();
        $this->view['images'] = $images;
    }
}
