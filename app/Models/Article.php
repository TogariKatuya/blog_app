<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // テーブル名を指定（省略時はモデル名の複数形がテーブル名になる）
    protected $table = 'articles';

    // マスアサインメント可能な属性を指定
    protected $fillable = [
        'user_id',
        'hash',
        'title',
        'contents',
        'port_stauts_flag',
        'delete_flag',
        'views',
    ];

    // タイムスタンプを使用する場合は省略可能
    public $timestamps = true;

    // 必要に応じてリレーションメソッドを追加
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }

    public function comments()
    {
        return $this->hasMany(ArticleComment::class);
    }

    public function goods()
    {
        return $this->hasMany(ArticleGood::class);
    }
}
