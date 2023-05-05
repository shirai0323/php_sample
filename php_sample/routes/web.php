<?php

use Illuminate\Support\Facades\Route;
use App\Models\Task;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('tasks', [
        'tasks' => App\Models\Task::latest()->get()
    ]);
});

Route::post('/task', function (Request $request) {
    request()->validate(
        // バリデーションの定義
        [
            'name' => 'required|unique:tasks|min:3|max:255'
        ],
        // エラーメッセージの定義
        [
            'name.required' => 'タスク内容を入力してください',
            'name.unique' => 'そのタスクは既に追加されています',
            'name.min' => '3文字以上で入力してください',
            'name.max' => '255文字以内で入力してください'
        ]
    );
    $task = new Task(); //Taskモデルから新しいインスタンスを作成し変数$taskに代入
    $task->name = request('name'); //HTTPリクエストのパラメータからタスクの名前を取得し変数$taskに割り当て
    $task->save(); //$taskをDBに保存
    return redirect('/'); //アプリのホーム'/'にリダイレクトする
});

Route::delete('/task/{task}', function (Task $task) {
    $task->delete();
    return redirect('/');
});