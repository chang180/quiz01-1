<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    //
    public function index()
    {
        //
        $all = Admin::all();
        $cols = [
            '帳號', '密碼', '刪除', '操作'
        ];

        $rows = [];

        foreach ($all as $a) {
            $tmp = [
                [
                    'tag' => '',
                    'text' => $a->acc
                ],
                [
                    'tag' => '',
                    'type'=>'password',
                    'text' => str_repeat("*",strlen($a->pw))
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
            'header' => '管理者帳號管理',
            'module' => 'Admin',
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
            'action' => '/admin/admin',
            'modal_header' => '新增管理者帳號',
            'modal_body' => [
                [
                    'label' => '帳號',
                    'tag' => 'input',
                    'type' => 'text',
                    'name' => 'acc'
                ],
                [
                    'label' => '密碼',
                    'tag' => 'input',
                    'type' => 'password',
                    'name' => 'pw'
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
            $admin = new Admin;
            $acc = $request->input('acc');
            $pw = $request->input('pw');

            $admin->acc = $acc;
            $admin->pw = $pw;
            $admin->save();
        return redirect('/admin/admin');
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
        $admin = Admin::find($id);
        $view = [
            'action' => '/admin/admin/' . $id,
            'method' => 'patch',
            'modal_header' => '更換密碼',
            'modal_body' => [
                [
                    'label' => '新密碼',
                    'tag' => 'input',
                    'type' => 'password',
                    'name' => 'pw',
                    'value' => $admin->pw
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
        $admin = Admin::find($id);

        if ($admin->pw !== $request->input('pw')) {
            $admin->pw = $request->input('pw');
        }

        $admin->save();
        return redirect('/admin/admin');
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
        Admin::destroy($id);
    }

}
