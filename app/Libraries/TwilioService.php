<?php

namespace App\Libraries;

use Twilio\Rest\Client;

class TwilioService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        // Load from .env file properly
        $sid = getenv('TWILIO_SID') ?: $_ENV['TWILIO_SID'] ?? '';
        $token = getenv('TWILIO_TOKEN') ?: $_ENV['TWILIO_TOKEN'] ?? '';
        $this->from = getenv('TWILIO_FROM') ?: $_ENV['TWILIO_FROM'] ?? '';
        
        // Trim any whitespace
        $sid = trim($sid);
        $token = trim($token);
        $this->from = trim($this->from);
        
        // Log to CI4 log file
        log_message('debug', 'TwilioService initialized');
        log_message('debug', 'SID length: ' . strlen($sid));
        log_message('debug', 'SID prefix: ' . substr($sid, 0, 2));
        log_message('debug', 'From number: ' . $this->from);
        
        // Validate credentials
        if (empty($sid) || empty($token)) {
            throw new \Exception('Twilio credentials missing from .env file');
        }
        
        if (strpos($sid, 'AC') !== 0) {
            throw new \Exception('Invalid Twilio SID format. Must start with "AC"');
        }
        
        $this->client = new Client($sid, $token);
    }

    public function sendOtpSms($mobile, $otp)
    {
        $toNumber = '+91' . ltrim($mobile, '0');
        
        log_message('debug', 'Sending OTP to: ' . $toNumber);
        log_message('debug', 'From number: ' . $this->from);
        
        return $this->client->messages->create(
            $toNumber,
            [
                'from' => $this->from,
                'body' => 'Your OTP is: ' . $otp
            ]
        );
    }
}