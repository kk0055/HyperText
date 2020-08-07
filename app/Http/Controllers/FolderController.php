<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;
use App\Http\Requests\CreateFolder;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    public function create(CreateFolder $request)
    {
        
        //フォルダモデルのインスタンス
        $folder = new Folder();
        
        //入力された値をタイトルに代入
        $folder->title = $request->title;
        
        //データベースに書き込む
        $folder->save();

        return redirect()->route('tasks.index',[
            'id' => $folder->id,
        ]);
    }
}
