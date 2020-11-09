<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mvim;

class MvimController extends Controller
{
    //
    public function index()
    {
        //
        $all = Mvim::all();
        $cols = [
            '動畫圖片', '顯示', '刪除', '操作'
        ];

        $rows = [];

        foreach ($all as $a) {
            $tmp = [
                [
                    'tag' => 'embed',
                    'src' => $a->img,
                    'style' => 'width:100px;height:68px;'
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

        $this->view = array_merge($this->view,[
            'header' => '動畫圖片管理',
            'module' => 'Mvim',
            'cols' => $cols,
            'rows' => $rows
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
            'action' => '/admin/mvim',
            'modal_header' => '新增動畫圖片',
            'modal_body' => [
                [
                    'label' => '動畫圖片',
                    'tag' => 'input',
                    'type' => 'file',
                    'name' => 'img'
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
        if ($request->hasfile('img') && $request->file('img')->isValid()) {
            $mvim = new Mvim;
            $filename = $request->file('img')->getClientOriginalName();
            $request->file('img')->storeAs('public', $filename);

            $mvim->img = $filename;
            $mvim->save();
        }
        return redirect('/admin/mvim');
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
        $mvim = Mvim::find($id);
        $view = [
            'action' => '/admin/mvim/' . $id,
            'method' => 'patch',
            'modal_header' => '編輯動畫圖片',
            'modal_body' => [
                [
                    'label' => '目前圖片',
                    'tag' => 'embed',
                    'src' => $mvim->img,
                    'style' => 'width:100px;height:68px;',
                    // 'class' => 'modal_img'
                ],

                [
                    'label' => '更換動畫圖片',
                    'tag' => 'input',
                    'type' => 'file',
                    'name' => 'img'
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
        $mvim = Mvim::find($id);
        if ($request->hasfile('img') && $request->file('img')->isValid()) {
            $filename = $request->file('img')->getClientOriginalName();
            $request->file('img')->storeAs('public', $filename);
            $mvim->img = $filename;
        }


        $mvim->save();
        return redirect('/admin/mvim');
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
        Mvim::destroy($id);
    }

    //改變資料的顯示狀態
    public function display($id)
    {
        $mvim = Mvim::find($id);

        $mvim->sh=!($mvim->sh);
        $mvim->save();
    }
}
