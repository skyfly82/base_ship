<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class InPostService
{
    protected $apiUrl;
    protected $token;

    public function __construct()
    {
        $this->apiUrl = rtrim(config('services.inpost.api_url'), '/');
        $this->token = config('services.inpost.token');
    }

    /**
     * Tworzenie przesyłki w InPost
     */
    public function createShipment(array $data)
    {
        $response = Http::withToken($this->token)
            ->post($this->apiUrl . '/shipments', $data);

        if ($response->failed()) {
            throw new \Exception("InPost shipment creation failed: " . $response->body());
        }

        return $response->json();
    }

    /**
     * Pobranie etykiety przesyłki
     */
    public function getLabel($shipmentId, $format = 'A6')
    {
        $response = Http::withToken($this->token)
            ->get($this->apiUrl . "/shipments/{$shipmentId}/label", [
                'format' => $format
            ]);

        if ($response->failed()) {
            throw new \Exception("InPost label fetch failed: " . $response->body());
        }

        return $response->body(); // PDF binary
    }

    /**
     * Pobranie listy punktów (np. Paczkomaty, POP)
     */
    public function getPoints($type = null)
    {
        $url = $this->apiUrl . '/points';
        $query = $type ? ['type' => $type] : [];
        $response = Http::withToken($this->token)->get($url, $query);

        if ($response->failed()) {
            throw new \Exception("InPost points fetch failed: " . $response->body());
        }

        return $response->json();
    }
}
