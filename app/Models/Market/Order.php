<?php

namespace App\Models\Market;

use App\Models\User;
use App\Models\User\Address;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes,CascadeSoftDeletes;


    protected $fillable = ['user_id','postal_tracking_code', 'address_id', 'address_object', 'payment_id', 'payment_object', 'payment_type', 'payment_status', 'delivery_id', 'delivery_object', 'delivery_amount', 'delivery_status', 'delivery_date', 'order_final_amount', 'order_discount_amount', 'copan_id', 'copan_object', 'order_copan_discount_amount', 'common_discount_id', 'common_discount_object', 'order_common_discount_amount', 'order_total_products_discount_amount', 'order_status'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $cascadeDeletes = ['orderItems'];

    protected $dates = ['deleted_at'];

   
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
    public function copan()
    {
        return $this->belongsTo(Copan::class);
    }

    public function commonDiscount()
    {
        return $this->belongsTo(CommonDiscount::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getPaymentStatusValueAttribute()
    {
        switch ($this->payment_status) {
            case 0:
                $result = 'پرداخت نشده';
                break;
            case 1:
                $result = 'پرداخت شده';
                break;
            case 2:
                $result = 'باطل شده';
                break;
            default:
                $result = 'مرجوع شده';
        }
        return $result;
    }

    public function getPaymentTypeValueAttribute()
    {
        switch ($this->payment_type) {
            case 0:
                $result = 'آنلاین';
                break;
            case 1:
                $result = 'آفلاین';
                break;
            case 2:
                $result = 'پرداخت شده';
                break;
            default:
                $result = 'در محل';
        }
        return $result;
    }


    public function getDeliveryStatusValueAttribute()
    {
        switch ($this->delivery_status) {
            case 0:
                $result = 'ارسال نشده';
                break;
            case 1:
                $result = 'در حال ارسال';
                break;
            case 2:
                $result = 'ارسال شده';
                break;

            default:
                $result = 'تحویل داده شده';
        }
        return $result;
    }

    public function getOrderStatusValueAttribute()
    {
        switch ($this->order_status) {
            case 1:
                $result = 'در انتظار تأیید';
                break;
            case 2:
                $result = 'تأیید نشده';
                break;
            case 3:
                $result = 'تأیید شده';
                break;
            case 4:
                $result = 'باطل شده';
                break;
            case 5:
                $result = 'مرجوع شده';
                break;
            default:
                $result = 'بررسی نشده';
        }
        return $result;
    }

}
