<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->hasMany(Category::class,'package_id');
    }


    public function packagePurchaseLists()
    {
        return $this->hasMany(PackagePurchaseList::class, 'package_id');
    }
    

}
