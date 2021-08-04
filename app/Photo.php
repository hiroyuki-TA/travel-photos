<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['comment','image_file_name',];
    
    /**
     * 画像投稿を所有するユーザー　Userモデルとの関係を定義
     *  public function user() photoを持つuserは１人のため単数形
     * 単数の方belongsTO 複数持つ方hasMany 
     */ 
    public function user()
    {
         return $this->belongsTo(User::class);
    }
}
