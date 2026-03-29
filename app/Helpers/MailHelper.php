<?php

if (!function_exists('send_custom_mail')) {
    /**
     * Send an email using PHP's native mail() function.
     *
     * @param string $to
     * @param string $subject
     * @param string $message HTML content
     * @param string $fromEmail sender email address
     * @param string $fromName sender name
     * @return bool
     */
    function send_custom_mail($to, $subject, $message, $fromEmail = null, $fromName = null)
    {
        try {
            \Illuminate\Support\Facades\Mail::html($message, function ($msg) use ($to, $subject, $fromEmail, $fromName) {
                $msg->to($to)->subject($subject);
                
                if ($fromEmail) {
                    $fromName = $fromName ?? config('mail.from.name', 'CRM Caridad');
                    $msg->from($fromEmail, $fromName);
                }
            });
            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
            return false;
        }
    }
}
