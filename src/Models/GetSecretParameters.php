<?php

declare(strict_types=1);

namespace Infisical\SDK\Models;

/**
 * Parameters for getting a secret
 */
class GetSecretParameters
{
    public function __construct(
        public readonly ?string $secretKey = null,
        public readonly ?string $environment = null,
        public readonly ?string $projectId = null,
        public readonly ?string $secretPath = null,
        public readonly ?int $version = null,
        public readonly ?string $type = null,
        public readonly ?bool $expandSecretReferences = true,
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

        if ($this->version !== null) {
            $params['version'] = $this->version;
        }

        if ($this->type !== null) {
            $params['type'] = $this->type;
        }

        if ($this->expandSecretReferences !== null) {
            $params['expandSecretReferences'] = $this->boolToString($this->expandSecretReferences);
        }

        return $params;
    }
    private function boolToString(bool $value): string
    {
        return $value ? 'true' : 'false';
    }
}
