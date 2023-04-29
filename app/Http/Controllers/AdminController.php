<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', '=', 5)->get();
        return view('admin.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
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
                'information' => null,
                'image1' => null,
                'image2' => null,
                'image3' => null,
                'is_visible' => 0,
            ]);

            session()->flash('status', '登録しました。');

            if ($request->input('registration') === "1") {
                return back()->withInput();
            }

            session()->flush();

            DB::commit();
            return to_route('admin.index');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            dd('a');
            abort(404);
        } catch (\Exception $e) {
            session()->flash('status', '問題が発生しました。');
            DB::rollBack();
            return back()->withInput();
        }
    }
}
