<?php

declare(strict_types=1);

namespace Infisical\SDK\Services;

use Infisical\SDK\Models\MachineIdentityCredential;
use Infisical\SDK\Http\HttpClient;

/**
 * Service for universal authentication (machine identity)
 */
class UniversalAuthService
{
    private HttpClient $httpClient;
    /**
     * @var callable(string): void 
     */
    private $onAuthenticate;
    
    /**
     * @param callable(string): void $onAuthenticate
     */
    public function __construct(HttpClient $httpClient, $onAuthenticate)
    {
        $this->httpClient = $httpClient;
        $this->onAuthenticate = $onAuthenticate;
    }

    /**
     * Login with client ID and client secret
     *
     * @param  string $clientId     The client ID
     * @param  string $clientSecret The client secret
     * @return MachineIdentityCredential The machine identity credential
     */
    public function login(string $clientId, string $clientSecret): MachineIdentityCredential
    {
        $response = $this->httpClient->post(
            "/api/v1/auth/universal-auth/login", [
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            ]
        );

        // Parse the JSON response body
        $responseData = json_decode($response->getBody()->getContents(), true);
        
        if (!$responseData) {
            throw new \RuntimeException('Invalid response from authentication server');
        }

        $credential = MachineIdentityCredential::fromArray($responseData);
        call_user_func($this->onAuthenticate, $credential->accessToken);
        
        return $credential;
    }
}
