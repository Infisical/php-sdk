<?php

declare(strict_types=1);

namespace Infisical\SDK\Models;

/**
 * Parameters for updating a secret
 */
class UpdateSecretParameters
{
    public function __construct(
        public readonly ?string $secretKey = null,
        public readonly ?string $environment = null,
        public readonly ?string $projectId = null,
        public readonly ?string $secretPath = null,
        public readonly ?string $newSecretValue = null,
        public readonly ?string $newSecretKey = null,
        public readonly ?string $newSecretComment = null,
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

        if ($this->newSecretValue !== null) {
            $params['secretValue'] = $this->newSecretValue;
        }

        if ($this->newSecretComment !== null) {
            $params['secretComment'] = $this->newSecretComment;
        }

        $params['secretKey'] = $this->secretKey;

        return $params;
    }
}
