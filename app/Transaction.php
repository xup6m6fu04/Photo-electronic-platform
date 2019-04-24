<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const STATUS_SUCCESS = 'Y'; // 訂單已完成
    const STATUS_PAYED   = 'P'; // 訂單已付款 (尚未確認付款)
    const STATUS_CREATE  = 'N'; // 訂單建立
    const STATUS_CANCEL  = 'C'; // 訂單取消

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

    public function scopeUserEmail($query, $value)
    {
        return $query->where('user_email', $value);
    }

    public function scopeStatus($query, $value)
    {
        return $query->where('status', $value);
    }

    public function scopeAccount($query, $value)
    {
        return $query->where('account', $value);
    }

}
