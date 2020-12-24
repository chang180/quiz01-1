<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends HomeController
{
    public function vue($route)
    {
        switch ($route) {
            case "index":
                $news = News::select("id", "text")->where("sh", 1)->get()->filter(function ($val, $idx) {
                    if ($idx > 4) {
                        $this->view['news']['more'] = ['show' => true, 'href' => '/news'];
                    } else {
                        $val->short = mb_substr(str_replace("\r\n", " ", $val->text), 0, 20, 'utf8') . "...";
                        $val->text = str_replace("\r\n", " ", nl2br($val->text));
                        $val->show = false;
                        $this->view['news']['more'] = ['show' => false];
                        return $val;
                    }
                });
                break;
            case "all":
                $news = News::select("id", "text")->where("sh", 1)->get()->filter(function ($val, $idx) {
                    $val->short = mb_substr(str_replace("\r\n", " ", $val->text), 0, 20, 'utf8') . "...";
                    $val->text = str_replace("\r\n", " ", nl2br($val->text));
                    $val->show = false;
                    $this->view['news']['more'] = ['show' => false];
                    return $val;
                });
                break;
        }
        return $news;
    }

    public function list()
    {
        parent::sideBar();
        $this->view['news'] = News::where('sh', 1)->paginate(5);
        return view('news', $this->view);
    }

    public function index()
    {
        //
        $all = News::paginate(3);
        $cols = [
            '最新消息', '顯示', '刪除', '操作'
        ];

        $rows = [];

        foreach ($all as $a) {
            $tmp = [
                [
                    'tag' => '',
                    'text' => mb_substr($a->text, 0, 50, 'utf8'),
                ],
                [
                    'tag' => 'button',
                    'type' => 'button',
                    'btn_color' => 'btn-success',
                    'action' => 'show',
                    'id' => $a->id,
                    'text' => ($a->sh == 1) ? '顯示' : '隱藏'
                ],
                [
                    'tag' => 'button',
                    'type' => 'button',
                    'btn_color' => 'btn-danger',
                    'action' => 'delete',
                    'id' => $a->id,
                    'text' => '刪除'
                ],
                [
                    'tag' => 'button',
                    'type' => 'button',
                    'btn_color' => 'btn-info',
                    'action' => 'edit',
                    'id' => $a->id,
                    'text' => '編輯'
                ]
            ];
            $rows[] = $tmp;
        }

        // dd($rows);

        $this->view = array_merge($this->view, [
            'header' => '最新消息管理',
            'module' => 'News',
            'cols' => $cols,
            'rows' => $rows,
            'all' => $all
        ]);
        // dd($all);
        return view('backend.module', $this->view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $view = [
            'action' => '/admin/news',
            'modal_header' => '新增最新消息內容',
            'modal_body' => [
                [
                    'label' => '最新消息內容',
                    'tag' => 'textarea',
                    'style' => 'width:200px;height:100px',
                    'name' => 'text'
                ]
            ]
        ];
        return view('modals.base_modal', $view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $news = new News;

        $news->text = $request->input('text');
        $news->save();
        return redirect('/admin/news');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $news = News::find($id);
        $view = [
            'action' => '/admin/news/' . $id,
            'method' => 'patch',
            'modal_header' => '編輯最新消息內容',
            'modal_body' => [
                [
                    'label' => '最新消息內容',
                    'tag' => 'textarea',
                    'style' => 'width:200px,height:100px',
                    'name' => 'text',
                    'value' => $news->text
                ]
            ]
        ];
        return view('modals.base_modal', $view);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $news = News::find($id);
        if ($news->text !== $request->input('text')) {
            $text = $request->input('text');
            $news->text = $text;
        }

        $news->save();
        return redirect('/admin/news');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        News::destroy($id);
    }

    //改變資料的顯示狀態
    public function display($id)
    {
        $news = News::find($id);

        $news->sh = !($news->sh);
        $news->save();
    }
}
