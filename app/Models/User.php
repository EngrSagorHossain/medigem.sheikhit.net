<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'college_name',
        'hsc_exam_year',
        'password',
        'package_status',
        'is_ban',
    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


public function performance(){
    return $this->HasMany(Performance::class,'user_id');
}

public function packagePurchaseLists()
{
    return $this->hasMany(PackagePurchaseList::class, 'user_id');
}

public function examhistorie()
    {
        return $this->HasMany(ExamHistory::class,'user_id');
    }
public function paymenthistories()
    {
        return $this->HasMany(PaymentHistory::class,'user_id');
    }
    public function ranks()
    {
        return $this->HasMany(Rank::class,'user_id');
    }   
}
