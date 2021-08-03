<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//User.php   Userモデルを指定している
use App\User;

class UsersController extends Controller
{
    public function index()
    {
           // ユーザ一覧をidの降順で取得 idを基準にdesc降順
        $users = User::orderBy('id', 'desc')->paginate(10);

        // ユーザ一覧ビューでそれを表示
        return view('users.index', [
            'users' => $users,
        ]);
    }
}
