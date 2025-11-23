<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static create(array $attributes)
 * @method static whereHas(string $string, \Closure $param)
 * @method static where(string $string, string $string1)
 * @property mixed $id
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'phone_number',
        'company_name',
        'avatar',
        'password',
        'is_verified_seller',
        'seller_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'seller_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_verified_seller' => 'boolean',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'seller_verified_at' => 'datetime',
            'is_verified_seller' => 'boolean',
        ];
    }

    public function loginInfo(): HasMany
    {
        return $this->hasMany(UserLoginInfo::class, 'user_id', 'id');
    }

    public function lastLoginInfo(): HasOne
    {
        return $this->hasOne(UserLoginInfo::class, 'user_id', 'id')->latest('login_date');
    }

    // 添加卖家相关的关系

    // 用户可以有订阅
    public function subscription()
    {
        return $this->hasOne(SellerSubscription::class, 'user_id');
    }

    // 用户可以发布多个产品
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    // 检查用户是否有有效的订阅
    public function hasValidSubscription()
    {
        return $this->subscription && 
               $this->subscription->payment_status === 'paid' && 
               $this->subscription->end_date && 
               $this->subscription->end_date->isFuture();
    }
    
    // Seller ratings set by admins
    public function sellerRating()
    {
        return $this->hasOne(SellerRating::class, 'seller_id');
    }
    
    // Get seller's rating value
    public function getSellerRatingAttribute()
    {
        $rating = $this->sellerRating();
        return $rating ? $rating->first()->rating : null;
    }
    
    // Check if seller has a rating
    public function getHasSellerRatingAttribute()
    {
        return $this->sellerRating()->exists();
    }
    
    // Get seller's average rating (for backward compatibility)
    public function getAverageRatingAttribute()
    {
        return $this->seller_rating ?? 0;
    }
    
    // Get seller's total ratings count (for backward compatibility)
    public function getTotalRatingsAttribute()
    {
        return $this->sellerRating()->exists() ? 1 : 0;
    }
}