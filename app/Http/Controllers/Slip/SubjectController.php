<?php

namespace App\Http\Controllers\Slip;

use App\Model\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    /**
     * ログインチェック
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 一覧表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subject = Subject::all();

        return view('subject.index', ['subject' => $subject]);
    }

    /**
     * 登録フォーム表示
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subject.new');
    }

    /**
     * 登録処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        Subject::create($inputs);

        return redirect(route('subject.create'))->with('flash_message', '登録しました');
    }

    /**
     * 更新処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->all();

        $subject = Subject::find($inputs['id']);
        $subject->fill([
            'subject_name' => $inputs['subject_name'],
            'calculation' => $inputs['calculation'],
        ]);
        $subject->save();

        return redirect(route('subject.index'))->with('flash_message', '登録しました');
    }

    /**
     * 削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (empty($id)) {
            return redirect(route('subject.index'))->with('flash_message', 'データがありません');
        }
        try {
            $slip = Subject::destroy($id);
        } catch (\Throwable $e) {
            abort(500);
        }
        return redirect(route('subject.index'))->with('flash_message', '削除しました');
    }
}
