<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;

class AdController extends Controller
{
    public function index()
    {
        //
        $all = Ad::all();
        $cols = [
            '動態文字廣告', '顯示', '刪除', '操作'
        ];

        $rows = [];

        foreach ($all as $a) {
            $tmp = [
                [
                    'tag' => '',
                    'text' => $a->text
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
            'header' => '動態廣告文字管理',
            'module' => 'Ad',
            'cols' => $cols,
            'rows' => $rows
        ]);
        // dd($all);
        return view('backend.module', $this->view);
    }

    public function create()
    {
        //
        $view = [
            'action' => '/admin/ad',
            'modal_header' => '新增動態廣告文字',
            'modal_body' => [
                [
                    'label' => '動態廣告文字',
                    'tag' => 'input',
                    'type' => 'text',
                    'name' => 'text'
                ]
            ]
        ];
        return view('modals.base_modal', $view);
    }
    //

    public function store(Request $request)
    {
        //
        // dd($request);
            $ad = new Ad;
            $text = $request->input('text');

            $ad->text = $text;
            $ad->save();
        return redirect('/admin/ad');
    }

    public function edit($id)
    {
        //
        $ad = Ad::find($id);
        $view = [
            'action' => '/admin/ad/' . $id,
            'method' => 'patch',
            'modal_header' => '編輯動態廣告文字',
            'modal_body' => [
                [
                    'label' => '動態廣告文字',
                    'tag' => 'input',
                    'type' => 'text',
                    'name' => 'text',
                    'value' => $ad->text
                ]
            ]
        ];
        return view('modals.base_modal', $view);
    }

    public function update(Request $request, $id)
    {
        //
        $ad = Ad::find($id);

        if ($ad->text !== $request->input('text')) {
            $text = $request->input('text');
            $ad->text = $text;
        }

        $ad->save();
        return redirect('/admin/ad');
    }

    public function destroy($id)
    {
        //
        Ad::destroy($id);
    }

    //改變資料的顯示狀態
    public function display($id)
    {
        $ad = Ad::find($id);
        // $ad->sh=($ad->sh+1)%2;
        $ad->sh=!($ad->sh);
        $ad->save();
    }
}
