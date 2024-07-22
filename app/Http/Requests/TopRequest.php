<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopRequest extends FormRequest
{
    /**
     * このリクエストを承認するかどうか
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // 認証が必要な場合はここで調整
    }

    /**
     * リクエストに適用するバリデーションルール
     *
     * @return array
     */
    public function rules()
    {
        return [
            'query' => 'nullable|string|max:255',
            'sort' => 'nullable|in:views,created_at', // ソート可能なフィールド
        ];
    }
}
