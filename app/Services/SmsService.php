<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    protected $public_key;

    protected $private_key;

    protected $base_url;

    protected $callerID;

    public function __construct()
    {
        // $this->public_key = env('SMS_PUBLIC_KEY'); // Your public API key
        // $this->private_key = env('SMS_PRIVATE_KEY');       // Your private API key
        // $this->callerID = 'KM ZION';             // Your caller ID
        // $this->base_url = 'http://smpp.revesms.com:7788'; // Base URL
        //FOR CAPANEl
        $this->public_key = env('SMS_PUBLIC_KEY'); // Your public API key
        $this->private_key = env('SMS_PRIVATE_KEY'); // Your private API key
        $this->callerID = env('SMS_CALLER_ID', 'KM ZION'); // Your caller ID
        $this->base_url = env('SMS_BASE_URL', 'http://apismpp.revesms.com/sendtext'); // Base URL
    }
    public function sendMessage($phone_number, $message_content)
    {
        // Prepare the payload
        $payload = [
            'apikey' => $this->public_key,
            'secretkey' => $this->private_key,
            'callerID' => $this->callerID,
            'toUser' => $phone_number,
            'messageContent' => $message_content,
        ];

        // Send the POST request
        $response = Http::post($this->base_url . '/sendtext', $payload);

        // Check if the response was successful
        if ($response->successful()) {
            return $response->json(); // Return response data
        } else {
            return ['status' => 'error', 'message' => 'Error sending SMS.'];
        }
    }
    // public function sendMessage($phone_number, $message_content)
    // {
    //     // Create the API URL
    //     $url = $this->base_url . '/sendtext?apikey=' . urlencode($this->public_key) .
    //         '&secretkey=' . urlencode($this->private_key) .
    //         '&callerID=' . urlencode($this->callerID) .
    //         '&toUser=' . urlencode($phone_number) .
    //         '&messageContent=' . urlencode($message_content);

    //     // Send the request and get the response
    //     $response = Http::get($url);

    //     // Check if the response was successful
    //     if ($response->successful()) {
    //         return $response->json(); // Return response data
    //     } else {
    //         return ['status' => 'error', 'message' => 'Error sending SMS.'];
    //     }
    // }
}
