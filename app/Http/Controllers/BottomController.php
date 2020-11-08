<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bottom;

class BottomController extends Controller
{
    //
    public function index()
    {
        //
        $bottom = Bottom::first();
        $col = [
            '頁尾版權'
        ];

        $row = [
            [
                'text' => $bottom->bottom
            ],
            [
                'tag' => 'button',
                'type' => 'button',
                'btn_color' => 'btn-info',
                'action' => 'edit',
                'id' => $bottom->id,
                'text' => '編輯'
            ]
        ];

        $view = [
            'header' => '頁尾版權管理',
            'module' => 'Bottom',
            'col' => $col,
            'row' => $row
        ];
        // dd($all);
        return view('backend.module', $view);
    }

    public function edit($id)
    {
        //
        $bottom = Bottom::first();
        $view = [
            'action' => '/admin/bottom/' . $id,
            'method' => 'patch',
            'modal_header' => '編輯頁尾版權',
            'modal_body' => [
                [
                    'label' => '頁尾版權文字',
                    'tag' => 'input',
                    'type' => 'text',
                    'name' => 'bottom',
                    'value' => $bottom->bottom
                ]
            ]
        ];
        return view('modals.base_modal', $view);
    }

    public function update(Request $request, $id)
    {
        //
        $bottom = Bottom::first();

        if ($bottom->number !== $request->input('bottom')) {
            $bottom->bottom =$request->input('bottom');
        }

        $bottom->save();
        return redirect('/admin/bottom');
    }
}
