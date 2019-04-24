<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
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

    public function scopeTransactionId($query, $value)
    {
        return $query->where('transaction_id', $value);
    }

    public function scopePrice($query, $value)
    {
        return $query->where('price', $value);
    }

    public function scopeCount($query, $value)
    {
        return $query->where('count', $value);
    }
}
