<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZoomService
{
    private function generateToken()
    {
        $response = Http::withBasicAuth(
            config('services.zoom.client_id'),
            config('services.zoom.client_secret')
        )->asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'account_credentials',
            'account_id' => config('services.zoom.account_id'),

        ]);

        return $response->json()['access_token'];
    }

    public function createMeeting($topic, $startTime, $duration)
    {
        $token = $this->generateToken();
        $response = Http::withToken($token)
            ->post('https://api.zoom.us/v2/users/' . config('services.zoom.user_email') . '/meetings', [
                "topic" => $topic,
                "type" => 2,
                "start_time" => $startTime,
                "duration" => $duration,
                "timezone" => "Asia/Kolkata",
                "agenda" => "Mentor Session",
                "settings" => [
                    "host_video" => true,
                    "participant_video" => true,
                    "waiting_room" => true,
                ],

            ]);
            return $response->json();
    }

}
