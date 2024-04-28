<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\FCMDeviceToken;

class PushNotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        // Replace 'your_server_key' with your Firebase Server Key
        $serverKey = 'AAAAcf3Z6AA:APA91bHtEksIPhQ19_biQLeDtAcMgYk75_3LuACe_ct4kiQTTLnUEEZWmsJXonkeugzoiUh7YJR3-w_kAS0Dyj__l3gpd97aON1h8QLQf805rfr3t8ZNVH6FrRB-gAup5zc1zoKTDen4';


        // Retrieve device token and notification data from the request
        $deviceTokens = FCMDeviceToken::pluck('device_token')->toArray();
  
        $title = $request->input('title');
        $body = $request->input('body');

        // Construct the request payload
        $data = [
            'registration_ids' => $deviceTokens, // 'to' instead of 'token'
            'notification' => [
                'title' => $title,
                'body' => $body,
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


    public function storeDeviceToken(Request $request)
    {
        $existingToken = FCMDeviceToken::where('user_id', $request->user()->id)->first();
    
        if ($existingToken) {
            // If user already has a token, update it
            $existingToken->device_token = $request->device_token;
            $existingToken->save();
            return response()->json($existingToken, 200);
        } else {
            // If user doesn't have a token, create a new one
            $fcmdeviceToken = new FCMDeviceToken();
            $fcmdeviceToken->device_token = $request->device_token;
            $fcmdeviceToken->user_id = $request->user()->id;
            $fcmdeviceToken->save();
            return response()->json($fcmdeviceToken, 201);
        }
    }
    


}
