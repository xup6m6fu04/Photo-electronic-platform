<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const OPEN  = 'Y'; // 上架狀態
    const CLOSE = 'N'; // 下架狀態
    const DEL_Y = 'Y'; // 已刪除 (軟刪除)
    const DEL_N = 'N'; // 刪除復原 (只有我能復原ㄎㄎ)

    const PRODUCT_TYPE_A = 'A'; // 時裝
    const PRODUCT_TYPE_B = 'B'; // 內衣
    const PRODUCT_TYPE_C = 'C'; // 大尺度

    /**
     * 不可被批量賦值的屬性。
     *
     * @var array
     */
    protected $guarded = [];

    public function scopeId($query, $value)
    {
        return $query->where('id', $value);
    }

    public function scopeProductId($query, $value)
    {
        return $query->where('product_id', $value);
    }

    public function scopeProductName($query, $value)
    {
        return $query->where('product_name', $value);
    }

    public function scopePrice($query, $value)
    {
        return $query->where('price', $value);
    }

    public function scopeType($query, $value)
    {
        return $query->where('type', $value);
    }

    public function scopeDownloadUrl($query, $value)
    {
        return $query->where('download_url', $value);
    }

    public function scopeBuyCount($query, $value)
    {
        return $query->where('buy_count', $value);
    }

    public function scopePage($query, $value)
    {
        return $query->where('page', $value);
    }

    public function scopeActorName($query, $value)
    {
        return $query->where('actor_name', $value);
    }

    public function scopeMainInfo($query, $value)
    {
        return $query->where('main_info', $value);
    }

    public function scopeSubInfo($query, $value)
    {
        return $query->where('sub_info', $value);
    }

    public function scopePreview1($query, $value)
    {
        return $query->where('preview_1', $value);
    }

    public function scopePreview2($query, $value)
    {
        return $query->where('preview_2', $value);
    }

    public function scopePreview3($query, $value)
    {
        return $query->where('preview_3', $value);
    }

    public function scopeOpen($query, $value)
    {
        return $query->where('open', $value);
    }
}
