<?php

declare(strict_types=1);

namespace Infisical\SDK\Services;

use Infisical\SDK\Services\UniversalAuthService;
use Infisical\SDK\Http\HttpClient;

/**
 * Service for authentication operations
 */
class AuthService
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
     * Get the universal auth service
     *
     * @return UniversalAuthService
     */
    public function universalAuth(): UniversalAuthService
    {
        return new UniversalAuthService($this->httpClient, $this->onAuthenticate);
    }
}
