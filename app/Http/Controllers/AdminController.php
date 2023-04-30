<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Information;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\NewUserAndLessonRequest;
use App\Http\Requests\UpdatePasswordRequest;

class AdminController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', '=', 5)->get();
        $users = User::where('role', '=', 9)->get();
        return view('admin.index', compact('teachers', 'users'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(NewUserAndLessonRequest  $request)
    {
        try {
            DB::beginTransaction();

            $user_id = User::latest('id')->value('id') + 1;

            User::create([
                'id' => $user_id,
                'name' => $request->input('name'),
                'kana' => $request->input('kana'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role' => 5,
            ]);

            Information::create([
                'id' => Information::latest('id')->value('id') + 1,
                'user_id' => $user_id,
                'is_visible' => 0,
            ]);

            DB::commit();

            session()->flash('status', '登録しました。');
            return redirect()->route('admin.index');
        } catch (\Exception $e) {
            session()->flash('status', '問題が発生しました。');
            DB::rollBack();
            return back()->withInput();
        }
    }

    public function grant($id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $user->role = 5;
            $user->save();

            Information::create([
                'id' => Information::latest('id')->value('id') + 1,
                'user_id' => $user->id,
                'is_visible' => 0,
            ]);
            DB::commit();
        } catch (Exception $e) {
            session()->flash('error', 'エラーが発生しました。');
            DB::rollBack();
            return redirect()->route('admin.index');
        }

        session()->flash('status', '更新完了');
        return redirect()->route('admin.index');
    }

    public function password($id)
    {
        $user = User::findOrFail($id);
        return view('admin.password', compact('user'));
    }

    public function change_password(UpdatePasswordRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->password = Hash::make($request['password']);
        $user->save();

        session()->flash('status', '変更しました。');
        return redirect()->route('admin.index');
    }
}
