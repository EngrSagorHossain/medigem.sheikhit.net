<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\FCMDeviceToken;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = ['notice'];

    protected static function booted()
    {
        static::created(function ($notice) {
            $notice->sendNotification();
        });
    }

    public function sendNotification()
    {
        // Replace 'your_server_key' with your Firebase Server Key
        $serverKey = 'AAAAcf3Z6AA:APA91bHtEksIPhQ19_biQLeDtAcMgYk75_3LuACe_ct4kiQTTLnUEEZWmsJXonkeugzoiUh7YJR3-w_kAS0Dyj__l3gpd97aON1h8QLQf805rfr3t8ZNVH6FrRB-gAup5zc1zoKTDen4';

        // Retrieve device tokens
        $deviceTokens = FCMDeviceToken::pluck('device_token')->toArray();
  
        // Notification data
        $title = 'MediGem';
        $body = 'Hello This is testing';

        // Construct the request payload
        $data = [
            'registration_ids' => $deviceTokens,
            'notification' => [
                'title' => 'MediGem',
                'body' => $this->notice,
            ],
        ];

        // Send the HTTP POST request to the FCM endpoint
        $response = Http::withHeaders([
                'Authorization' => 'key=' . $serverKey,
                'Content-Type' => 'application/json',
            ])
            ->post("https://fcm.googleapis.com/fcm/send", $data);

        // Check if the request was successful
        if ($response->successful()) {
            // Notification sent successfully
            $responseBody = $response->json();
            return response()->json(['success' => true, 'response' => $responseBody]);
        } else {
            // Notification sending failed
            $error = $response->json();
            return response()->json(['success' => false, 'error' => $error]);
        }
    }
}
