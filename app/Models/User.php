<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'profile',
        'ip',
        'country',
        'country_code',
        'city',
        'zip_code',
        'email',
        'email_verify',
        'email_code',
        'password',
        'google_id',
        'facebook_id',
        'role',
        'admin_role',
        'status',
    ];

    public function sentChats()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    public function receivedChats()
    {
        return $this->hasMany(Chat::class, 'reciver_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        ];
    }


    /**
     * Get transactions where user is a seller
     */
    public function sellerTransactions()
    {
        return $this->hasMany(Transaction::class, 'seller_id');
    }

    /**
     * Get transactions where user is a buyer
     */
    public function buyerTransactions()
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }

    /**
     * Get custom seller commission
     */
    public function sellerCommission()
    {
        return $this->hasOne(SellerCommission::class, 'seller_id');
    }

    /**
     * Get total earnings as seller
     */
    public function getTotalEarningsAttribute()
    {
        return $this->sellerTransactions()
            ->where('status', 'completed')
            ->sum('seller_earnings');
    }

    /**
     * Get pending payout amount
     */
    public function getPendingPayoutAttribute()
    {
        return $this->sellerTransactions()
            ->where('status', 'completed')
            ->where('payout_status', 'pending')
            ->sum('seller_earnings');
    }

    /**
     * Get total spent as buyer
     */
    public function getTotalSpentAttribute()
    {
        return $this->buyerTransactions()
            ->where('status', 'completed')
            ->sum('total_amount');
    }
}
