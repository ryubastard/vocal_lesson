<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Information;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction(); // トランザクションを開始する

        try {
            // リクエストから画像ファイルを取得する
            $images = [];

            for ($i = 1; $i <= 3; $i++) {
                $image = $request->file("image{$i}");
                if ($image) {
                    $extension = $image->getClientOriginalExtension(); // 拡張子を取得する
                    $filename = time() . "_{$i}." . $extension; // 拡張子を含めたファイル名を作成する
                    $image->storeAs('public/images', $filename);
                    $images["image{$i}"] = $filename;
                } else {
                    $images["image{$i}"] = null;
                }
            }

            // 保存処理
            $information = Information::first();
            $information->information = $request->input('information');

            foreach ($images as $key => $value) {
                if ($request->has("delete_{$key}")) {
                    $information->{$key} = null; // 画像を削除する場合は、nullを設定する
                } elseif ($value) {
                    $information->{$key} = $value;
                }
            }

            $information->save();

            DB::commit(); // すべての処理が正常に完了した場合はコミットする

            session()->flash('status', '更新完了');
            return to_route('information.show'); //名前付きルート

        } catch (Exception $e) {
            DB::rollback(); // エラーが発生した場合はロールバックする
            session()->flash('status', '更新に失敗しました。');
            return back()->withErrors(['update' => $e->getMessage()]);
        }
    }
}
