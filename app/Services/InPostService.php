<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class InPostService
{
    protected Client $client;
    protected ?string $accessToken;
    protected ?string $organizationId;

    public function __construct()
    {
        $this->accessToken = config('services.inpost.token');
        $this->organizationId = config('services.inpost.organization_id');

        // Zawsze podaj pełny URL (z https://)
        $baseUrl = config('services.inpost.base_url');

        if (!$this->accessToken || !$this->organizationId) {
            Log::error('InPost Service: Access Token or Organization ID is not configured.');
        }

        $this->client = new Client([
            'base_uri' => rtrim($baseUrl, '/'),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken,
                'Content-Type' => 'application/json',
            ],
            'timeout' => 10,
        ]);
    }

    public function createShipment(array $data)
    {
        $endpoint = "/v2/organizations/{$this->organizationId}/shipments";
        try {
            $response = $this->client->post($endpoint, [
                'json' => $data,
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
            Log::info('InPost createShipment result', ['result' => $result]);
            return $result;
        } catch (GuzzleException $e) {
            Log::error('InPost API Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Pobieranie etykiety PDF po shipmentId z InPost (sandbox działa dla paczek utworzonych przez API!).
     * Domyślnie A6 (możesz zmienić na A4).
     */
    public function getLabel($shipmentId, $format = 'A6')
    {
        $endpoint = "/v1/shipments/{$shipmentId}/label";
        try {
            $response = $this->client->get($endpoint, [
                'query' => ['format' => $format]
            ]);
            return $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            Log::error('InPost getLabel error: ' . $e->getMessage());
            return null;
        }
    }
}
