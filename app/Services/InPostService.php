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
    protected string $baseUrl;

    public function __construct()
    {
        $this->accessToken = config('services.inpost.token');
        $this->organizationId = config('services.inpost.organization_id');

        // Poprawka: powinno być api_url!
        $this->baseUrl = config('services.inpost.api_url');

        if (!$this->accessToken || !$this->organizationId) {
            Log::error('InPost Service: Access Token or Organization ID is not configured.');
        }

        if (!$this->baseUrl) {
            Log::error('InPost Service: API URL (baseUrl) is not configured.');
        }

        $this->client = new Client([
            'base_uri' => rtrim($this->baseUrl, '/'),
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
        $fullUrl = rtrim($this->baseUrl, '/') . $endpoint;
        Log::info('InPost createShipment - Pełny URL', ['url' => $fullUrl]);
        Log::info('InPost createShipment - Payload', $data);

        try {
            $response = $this->client->post($endpoint, [
                'json' => $data,
            ]);
            $result = json_decode($response->getBody()->getContents(), true);
            Log::info('InPost createShipment - Odpowiedź', ['result' => $result]);
            return $result;
        } catch (GuzzleException $e) {
            Log::error('InPost API Error w createShipment: ' . $e->getMessage());
            return null;
        }
    }

    public function getLabel($shipmentId, $format = 'A6')
    {
        $endpoint = "/v1/shipments/{$shipmentId}/label";
        $fullUrl = rtrim($this->baseUrl, '/') . $endpoint;
        Log::info('InPost getLabel - Pełny URL', ['url' => $fullUrl]);

        try {
            $response = $this->client->get($endpoint, [
                'query' => ['format' => $format]
            ]);
            Log::info('InPost getLabel - Status', ['status' => $response->getStatusCode()]);
            return $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            Log::error('InPost getLabel error: ' . $e->getMessage());
            return null;
        }
    }
}
