<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $account = User::all();
        return view('admin.index', compact('account'));
    }

    public function store(Request $request)
    {
        // バリデーション済みデータの取得
        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            User::create([
              'name' => $inputs['name'],
              'email' => $inputs['email'],
              'password' => Hash::make($inputs['password']),
            ]);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        return redirect(route('account.index'));
    }

    public function update(Request $request)
    {
        $inputs = $request->all();

        \DB::beginTransaction();
        try {
            $user = User::find($inputs['id']);
            $user->fill([
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            'password' => $inputs['password'],
            'role' => $inputs['role'],
            'is_active' => $inputs['is_active'],
            ]);
            $user->save();
             \DB::commit();

        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }
        return redirect(route('account.index'))->with('flash_message', '更新しました');
    }


}
