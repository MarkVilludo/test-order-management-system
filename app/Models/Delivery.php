<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Delivery extends Model
{
    protected $fillable = ['order_id', 'delivery_person_id', 'status', 'delivered_at'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function deliveryPerson()
    {
        return $this->belongsTo(User::class, 'delivery_person_id');
    }
}
