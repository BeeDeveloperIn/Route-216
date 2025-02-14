<?php
namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\UserDevice;
class FirebaseNotificationService
{
    /**
     * Generate access token for Firebase Cloud Messaging.
     *
     * @return string|null
     */

    private function generateAccessToken()
    {
        // Check if the token exists in cache
        if (Cache::has('firebase_access_token')) {
            return Cache::get('firebase_access_token');
        }
        try {
            // Path to the service_account.json file
            $credentialsFilePath = storage_path('app/private/service_account.json');
            // Create credentials object
            $credentials = new ServiceAccountCredentials(
                ['https://www.googleapis.com/auth/firebase.messaging'],
                $credentialsFilePath
            );
            // Fetch the token
            $token = $credentials->fetchAuthToken();
            $accessToken = $token['access_token'];
            // Cache the token for 55 minutes
            Cache::put('firebase_access_token', $accessToken, now()->addMinutes(55));
            return $accessToken;
        } catch (\Exception $e) {
            response()->json( ['Error generating access token: ' . $e->getMessage()]);
            return null;
        }
    }
    /**
     * Send push notifications via Firebase Cloud Messaging.
     *
     * @param $to
     * @param string $title
     * @param string $body
     */
    public function sendPushNotificationSync($userIds, $title, $body,$log = false)
    {
        // Generate access token for Firebase
        $access_token = $this->generateAccessToken();
        // Retrieve the user's device details
        $devices = UserDevice::whereIn('user_id', $userIds)
            ->orderBy('created_at', 'DESC')
            ->get();

        // Define the FCM endpoint
        $projectId = config('services.fcm.projectId');
        $fcmEndpoint = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
        foreach ($devices as $device) {
            if (!empty($device)) {
                try {
                    // Prepare the message payload (title and body only)
                    $message = [
                        'message' => [
                            'token' => $device->device_token,
                            'notification' => [
                                'title' => $title,
                                'body'  => $body
                            ],
                            'android' => [
                                'notification' => [
                                    'icon' => asset('notification_logo.png'),
                                    'channel_id' => 'route216'
                                ]
                            ],
                            'apns' => [
                                'payload'=>[
                                    'aps' => [
                                        'sound' => 'default'
                                    ]
                                ]
                            ]
                        ]
                    ];
                    // Send the notification via HTTP POST request
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $access_token,
                        'Content-Type' => 'application/json',
                    ])->post($fcmEndpoint,$message); // Ensure payload is a JSON string
                    // Log the result of the notification
                    if($log){
                        if ($response->status() == 200) {
                            return response()->json( ['Notification sent successfully: ' => $response->body()]);
                        } else {
                            return response()->json( ['Error sending FCM notification: ' . $response->body()]);
                        }
                    }
                } catch (\Exception $e) {
                    if($log){
                        return response()->json( ['Error sending FCM notification: ' . $e->getMessage()]);
                    }
                }
            }
        }
    }
}