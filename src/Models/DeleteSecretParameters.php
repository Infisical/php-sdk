<?php

declare(strict_types=1);

namespace Infisical\SDK\Models;

/**
 * Parameters for deleting a secret
 */
class DeleteSecretParameters
{
    public function __construct(
        public readonly ?string $secretKey = null,
        public readonly ?string $environment = null,
        public readonly ?string $projectId = null,
        public readonly ?string $secretPath = null,
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

        if ($this->secretKey !== null) {
            $params['secretKey'] = $this->secretKey;
        }

        if ($this->environment !== null) {
            $params['environment'] = $this->environment;
        }

        if ($this->projectId !== null) {
            $params['workspaceId'] = $this->projectId;
        }
        
        if ($this->secretPath !== null) {
            $params['secretPath'] = $this->secretPath;
        }

        return $params;
    }

}
