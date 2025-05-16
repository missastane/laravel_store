<?php

namespace App\Models;

use App\Models\Content\Comment;
use App\Models\Content\Post;
use App\Models\Market\CartItem;
use App\Models\Market\Compare;
use App\Models\Market\Copan;
use App\Models\Market\OfflinePayment;
use App\Models\Market\OnlinePayment;
use App\Models\Market\Order;
use App\Models\Market\OrderItem;
use App\Models\Market\Payment;
use App\Models\Market\Product;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketAdmin;
use App\Models\Ticket\TicketFile;
use App\Models\User\Address;
use App\Models\User\Permission;
use App\Models\User\Role;
use App\Traits\Permissions\HasPermissionsTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Nagy\LaravelRating\Traits\CanRate;

class User extends Authenticatable
{
    // use HasApiTokens;
    use HasFactory, SoftDeletes, CascadeSoftDeletes;
    use HasProfilePhoto;
    use Notifiable, Sluggable;
    use TwoFactorAuthenticatable;
    use HasPermissionsTrait;
    use CanRate;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'activation',
        'activation_date',
        'mobile',
        'profile_photo_path',
        'status',
        'user_type',
        'email_verified_at',
        'mobile_verified_at',
        'slug',
        'national_code',
        'current_team_id'
    ];

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => ['first_name', 'last_name']
            ]
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
        'profile_photo_path' => 'array'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_path',
    ];

    protected $cascadeDeletes = ['orders', 'ticketAdmin','tickets','otps', 'roles', 'addresses','payments', 'onlinePayments','offlinePayments', 'copans','cartItems','posts','comments', 'ticketFiles'];

    protected $dates = ['deleted_at'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isUserPerchasedProduct($productId)
    {
        $productIds = collect();
            foreach($this->orderItems()->where('product_id', $productId)->get() as $item){
                $productIds->push($item->product_id);
        }
        $productIds = $productIds->unique();
        return $productIds;
    }

    public function ticketFiles()
    {
        return $this->hasMany(TicketFile::class, 'user_id');
    }
    public function copans()
    {
        return $this->hasMany(Copan::class, 'user_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'author_id');
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'user_id');
    }
    
    public function onlinePayments()
    {
        return $this->hasMany(OnlinePayment::class, 'user_id');
    }
    public function offlinePayments()
    {
        return $this->hasMany(OfflinePayment::class, 'user_id');
    }
    public function ticketAdmin()
    {
        return $this->hasOne(TicketAdmin::class, 'user_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }
    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class,'user_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_user');
    }
    public function otps()
    {
        return $this->hasMany(Otp::class, 'user_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class,Order::class);
    }

    public function compare()
    {
        return $this->hasOne(Compare::class);
    }
}
