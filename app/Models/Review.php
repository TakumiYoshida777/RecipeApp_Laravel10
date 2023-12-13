<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
    // recipeメソッド名を自由に決めることができます。
    // ただし、Eloquentの関連メソッドには一般的な命名規則があります。
    // 通常、belongsToリレーションのメソッド名は関連するモデルの単数形になりますが、
    // これはルールではなく推奨される慣習です。
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
