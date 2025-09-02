<?php

declare(strict_types=1);

namespace Infisical\SDK\Services;

use Infisical\SDK\Models\Secret;
use Infisical\SDK\Models\ListSecretsParameters;
use Infisical\SDK\Http\HttpClient;
use Infisical\SDK\Models\CreateSecretParameters;
use Infisical\SDK\Models\DeleteSecretParameters;
use Infisical\SDK\Models\GetSecretParameters;
use Infisical\SDK\Models\UpdateSecretParameters;

/**
 * Service for managing secrets
 */
class SecretsService
{
    private HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * List secrets with optional filtering and pagination
     *
     * @param  ListSecretsParameters|null $parameters Optional parameters for filtering and pagination
     * @return array<Secret> Array of Secret objects
     */
    public function list(?ListSecretsParameters $parameters = null): array
    {
        $response = $this->httpClient->get('/api/v3/secrets/raw', $parameters?->toArray() ?? []);
        $responseData = json_decode($response->getBody()->getContents(), true);


        $secrets = array_map(fn($data) => Secret::fromArray($data), $responseData['secrets'] ?? []);
        
        // Ensure unique secrets by key before processing imports
        if ($parameters?->recursive) {
            $secrets = $this->ensureUniqueSecretsByKey($secrets, $parameters?->skipUniqueValidation ?? false);
        }
        

        // Handle imports - imports take precedence over secrets
        if (isset($responseData['imports'])) {
            foreach ($responseData['imports'] as $importBlock) {
                foreach ($importBlock['secrets'] as $importSecretData) {
                    $importSecret = Secret::fromArray($importSecretData);
                    
                    // Only append if not already in the list (imports take precedence)
                    if (!$this->containsSecret($secrets, $importSecret->secretKey)) {
                        $secrets[] = $importSecret;
                    }
                }
            }
        }

        if ($parameters?->attach_to_process_env) {
            foreach ($secrets as $secret) {
                putenv($secret->secretKey . '=' . $secret->secretValue);
            }
        }

        return $secrets;
    }

    /**
     * Get a single secret by key
     *
     * @param  GetSecretParameters|null $parameters Optional parameters for filtering and pagination
     * @return Secret The secret
     */
    public function get(?GetSecretParameters $parameters = null): Secret
    {
        $response = $this->httpClient->get('/api/v3/secrets/raw/' . $parameters?->secretKey, $parameters?->toArray() ?? []);
        $responseData = json_decode($response->getBody()->getContents(), true);
        return Secret::fromArray($responseData['secret'] ?? []);
    }

    public function update(?UpdateSecretParameters $parameters = null): Secret
    {
        $response = $this->httpClient->patch('/api/v3/secrets/raw/' . $parameters?->secretKey, $parameters?->toArray() ?? []);
        $responseData = json_decode($response->getBody()->getContents(), true);


        return Secret::fromArray($responseData['secret'] ?? []);
    }

    public function delete(?DeleteSecretParameters $parameters = null): Secret
    {
        $response = $this->httpClient->delete('/api/v3/secrets/raw/' . $parameters?->secretKey, $parameters?->toArray() ?? []);
        $responseData = json_decode($response->getBody()->getContents(), true);
        return Secret::fromArray($responseData['secret'] ?? []);
    }

    public function create(?CreateSecretParameters $parameters = null): Secret
    {
        $response = $this->httpClient->post('/api/v3/secrets/raw/' . $parameters?->secretKey, $parameters?->toArray() ?? []);
        $responseData = json_decode($response->getBody()->getContents(), true);
        return Secret::fromArray($responseData['secret'] ?? []);
    }

    /**
     * @param Secret[] $secrets
     */
    private function containsSecret(array $secrets, string $secretKey): bool
    {
        foreach ($secrets as $secret) {
            if ($secret->secretKey === $secretKey) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param  Secret[] $secrets
     * @return Secret[]
     */
    private function ensureUniqueSecretsByKey(array $secrets, bool $skipUniqueValidation): array
    {
        $secretMap = [];

        // Move secrets to a map to ensure uniqueness
        foreach ($secrets as $secret) {
            if ($skipUniqueValidation) {
                // Create a composite key using both secretPath and secretKey
                $key = $secret->secretPath . ':' . $secret->secretKey;
            } else {
                // Use only secretKey for global uniqueness
                $key = $secret->secretKey;
            }
            $secretMap[$key] = $secret;
        }

        // Return array with unique secrets
        return array_values($secretMap);
    }

}
