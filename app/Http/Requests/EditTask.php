<?php

namespace App\Http\Requests;

use App\Task;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EditTask extends CreateTask
{
 

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = parent::rules();

        //Rule::inメソッド.入力値が許可リストに含まれているか検証
        //許可リストは array_keys(Task::STATUS) で配列として取得できるので、Rule クラスの in メソッドを使ってルールの文字列を作成
        // -> 'in(1, 2, 3)' を出力する
        //'status' => 'required|in(1, 2, 3)',として出力される
        $status_rule = Rule::in(array_keys(Task::STATUS));


        return $rule + [
            'status' => 'required|' . $status_rule, 
        ];
    }
 
    //親クラス CreateTask の attributes メソッドの結果と合体した属性名リストを返却
     public function attributes()
     {
         $attributes = parent::attributes();

         return $attributes + [
            'status' => '状態',
         ];
     }
     public function messages()
     {
          //親クラスのmessages()メソッドを呼び出す
          //CreateTask のmessages()メソッドを呼び出す
        $messages  = parent::messages();

        $status_labels = array_map(function($item) {
            return $item['label'];
        },Task::STATUS);

        //implode — $status_labelsを,により連結する
        $status_labels = implode('、', $status_labels);

        return $messages + [
         'status.in' =>  ':attribute には ' . $status_labels. ' のいずれかを指定してください。',
        ];
     }

}
