<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    public function tasks()
    {
        //フォルダクラスのインスタンスから紐づくタスククラスのリストを取得 フォルダテーブルとタスクテーブルの一対多の関連性
        //第一引数が関連するモデル名（namespaceも含む）、第二引数が関連するテーブルが持つ外部キーカラム名、第三引数はモデルに hasMany が定義されている側のテーブルが持つ、外部キーに紐づけられたカラムの名前
        return $this->hasMany('App\Task', 'folder_id', 'id');
    }
}
