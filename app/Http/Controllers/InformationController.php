<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $information = Information::first();
        return view('information', compact('information'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $information = Information::first();
        return view('manager.information.show', compact('information'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $information = Information::first();
        return view('manager.information.edit', compact('information'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatelessonRequest  $request
     * @param  \App\Models\lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // リクエストから画像ファイルを取得する
        $image = $request->file('image');

        if ($image) {
            $extension = $image->getClientOriginalExtension(); // 拡張子を取得する
            $filename = time() . '.' . $extension; // 拡張子を含めたファイル名を作成する
            $image->storeAs('public/images', $filename);
        }

        // 保存処理
        $information = Information::first();
        $information->information = $request['information'];

        if ($request->has('delete_image')) {
            $information->image = null; // 画像を削除する場合は、nullを設定する
        } elseif ($image) {
            $information->image = $filename;
        }
        $information->save();

        session()->flash('status', '更新完了');
        return to_route('information.show'); //名前付きルート
    }
}
