<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotosController extends Controller
{
     public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            // （後のChapterで他ユーザの投稿も取得するように変更しますが、現時点ではこのユーザの投稿のみ取得します）
            $photos = $user->photos()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'photos' => $photos,
            ];
        }

        // Welcomeビューでそれらを表示
        return view('welcome', $data);
    }
    
    
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'image_file_name' => 'required|max:255',
        ]);

        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->photos()->create([
            'image_file_name' => $request->image_file_name,
        ]);

        // 前のURLへリダイレクトさせる
        return back();
    }
    
    public function destroy($id)
    {
        // idの値で投稿を検索して取得
        $photo = \App\Photo::findOrFail($id);

        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        //他者のMicropostを勝手に削除されないよう、
        //ログインユーザのIDとMicropostの所有者のID（user_id）が一致しているかを調べる
        if (\Auth::id() === $photo->user_id) {
            $photo->delete();
        }

        // 前のURLへリダイレクトさせる
        return back();
    }
    

}