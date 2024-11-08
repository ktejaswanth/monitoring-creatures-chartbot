<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatbotController extends Controller
{
    // Display the chatbot UI
    public function index()
    {
        return view('chatbot.index');
    }

    // Handle the user's message and generate a response
    public function respond(Request $request)
    {
        // Get the user's message
        $userMessage = $request->input('message');

        // Check if external API integration is required or use a simple response
        if ($this->shouldUseApi($userMessage)) {
            return $this->getApiResponse($userMessage);
        }

        // Otherwise, generate a basic bot response
        $botResponse = $this->generateResponse($userMessage);

        return response()->json(['response' => $botResponse]);
    }

    // Function to determine whether to use API based on the message content
    private function shouldUseApi($message)
    {
        // Simple check: If message contains the word 'api', use the external API
        return strpos(strtolower($message), 'api') !== false;
    }

    // Function to generate basic responses
    private function generateResponse($message)
    {
        // For simplicity, use basic conditionals or replace with AI logic
        if (strpos(strtolower($message), 'hello') !== false) {
            return "Hi! How can I assist you today?";
        }

        if (strpos(strtolower($message), 'animal') !== false) {
            return "I can help with animal monitoring. Please specify your query.";
        }

        return "I'm sorry, I didn't understand that. Can you rephrase?";
    }

    // Function to get response from the external API (Vultr Inference API)
    private function getApiResponse($message)
    {
        // Initialize the Guzzle client
        $client = new Client();

        // API endpoint and key from environment
        $url = env('VULTR_API_URL') . '/v1/your-specific-endpoint'; // Make sure to set VULTR_API_URL in .env
        $apiKey = env('VULTR_API_KEY'); // Your API Key

        try {
            // Send POST request to the API
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => "Bearer $apiKey",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'message' => $message
                ]
            ]);

            // Decode the API response
            $responseData = json_decode($response->getBody()->getContents(), true);

            return response()->json($responseData);

        } catch (\Exception $e) {
            // If there's an error, return a message
            return response()->json([
                'response' => "Sorry, there was an error connecting to the API."
            ]);
        }
    }
}
