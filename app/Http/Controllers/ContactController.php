<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Show Contact Form
     */
    public function index()
    {
        return view('frontend.contact');
    }

    /**
     * Submit Contact Form
     */
    public function submit(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Email Data
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'user_message' => $request->message,
        ];

        try {
            // Send Email
            Mail::send('emails.contact', $data, function ($message) {
                $message->to('foziatariq213@gmail.com')
                        ->subject('New Contact Message from NovaCart');
            });

            return response()->json([
                'success' => true,
                'message' => 'Your message has been sent successfully!'
            ]);

        } catch (\Exception $e) {
            // Log error
            \Log::error('Contact email error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message: ' . $e->getMessage()
            ]);
        }
    }
}