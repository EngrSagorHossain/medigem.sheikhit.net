<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PackagePurchaseList;

class PaymentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method',
        'sent_number',
        'transaction_id',
        'package_id',
        'amount',
        'remarks',
        'status',
    ];

    protected static function booted()
    {
        // Listen for the updating event
        static::updating(function ($paymentHistory) {
            // Check if the status is being updated to "accepted"
            if ($paymentHistory->isDirty('status') && $paymentHistory->status === 'accepted') {
                // Trigger the purchasePackage method
                $paymentHistory->purchasePackage();
            }
        });
    }

    public function purchasePackage()
    {
        $newPurchase = new PackagePurchaseList;
        $newPurchase->user_id = $this->user_id;
        $newPurchase->package_id = $this->package_id;
        $newPurchase->save();

    }


}
