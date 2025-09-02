<?php

declare(strict_types=1);

namespace Infisical\SDK\Models;

/**
 * Parameters for creating a secret
 */
class CreateSecretParameters
{
    public function __construct(
        public readonly ?string $environment = null,
        public readonly ?string $projectId = null,
        public readonly ?string $secretPath = null,
        public readonly ?string $secretKey = null,
        public readonly ?string $secretValue = null,
        public readonly ?string $secretComment = null,
    ) {
    }

    /**
     * Convert to array for HTTP request
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $params = [];

        if ($this->environment !== null) {
            $params['environment'] = $this->environment;
        }

        if ($this->projectId !== null) {
            $params['workspaceId'] = $this->projectId;
        }
        
        if ($this->secretPath !== null) {
            $params['secretPath'] = $this->secretPath;
        }

        if ($this->secretKey !== null) {
            $params['secretKey'] = $this->secretKey;
        }

        if ($this->secretValue !== null) {
            $params['secretValue'] = $this->secretValue;
        }

        if ($this->secretComment !== null) {
            $params['secretComment'] = $this->secretComment;
        }

        return $params;
    }

}
