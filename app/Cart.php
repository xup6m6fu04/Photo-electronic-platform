<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
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

    public function scopeUserEmail($query, $value)
    {
        return $query->where('user_email', $value);
    }

    public function scopeProductId($query, $value)
    {
        return $query->where('product_id', $value);
    }
}
