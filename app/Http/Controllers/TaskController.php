<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task; 
use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;

class TaskController extends Controller
{
    public function index(int $id)
    {
       // Folder モデルの all クラスメソッドですべてのフォルダデータをデータベースから取得
        $folders = Folder::all();
          // 選ばれたフォルダを取得する
        $current_folder = Folder::find($id);
        // 選ばれたフォルダに紐づくタスクを取得する
        //where 第一引数がカラム名で第二引数が比較する値
        //$tasks = Task::where('folder_id', $current_folder->id)->get();
        $tasks = $current_folder->tasks()->get();

        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $id,
            'tasks' => $tasks,
        ]);
    }

    public function showCreateForm(int $id)
    {
        return view('tasks/create',
    [
        'folder_id' => $id
    ]);
    }

    public function create(int $id ,request $request)
    {
        
        $current_folder = Folder::find($id);
        //TASKモデルのインスタンス
        $task = new Task();
        
        //入力された値をタイトルに代入
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        
        //データベースに書き込む $current_folder に紐づくタスクを作成
        $current_folder->tasks()->save($task);

        return redirect()->route('tasks.index',[
            'id' => $current_folder->id,
        ]);
    }

       public function showEditForm(int $id, int $task_id)
       {
           $task = Task::find($task_id);

           return view('tasks/edit', [
               'task' => $task,
           ]);

       }
       
       public function edit(int $id, int $task_id, EditTask $request)
       {

       $task = Task::find($task_id);

       $task->title = $request->title;
       $task->status = $request->status;
       $task->due_date = $request->due_date;
       $task->save();

       return redirect()->route('tasks.index',[
           'id' => $task->folder_id,
       ]);

       }

}
