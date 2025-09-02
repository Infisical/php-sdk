<?php

declare(strict_types=1);

namespace Infisical\SDK\Models;

/**
 * Parameters for listing secrets
 */
class ListSecretsParameters
{
    public function __construct(
        public readonly ?string $environment = null,
        public readonly ?string $secretPath = null,
        public readonly ?string $projectId = null,
        public readonly ?bool $expandSecretReferences = true,
        public readonly ?bool $recursive = null,
        /**
         * @var array<string>|null 
         */
        public readonly ?array $tagSlugs = null,
        public readonly ?bool $attach_to_process_env = null,
        public readonly ?bool $skipUniqueValidation = null,
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
        
        if ($this->secretPath !== null) {
            $params['secretPath'] = $this->secretPath;
        }
        
        if ($this->projectId !== null) {
            $params['workspaceId'] = $this->projectId;
        }
        
        if ($this->expandSecretReferences !== null) {
            $params['expandSecretReferences'] = $this->boolToString($this->expandSecretReferences);
        }

        if ($this->recursive !== null) {
            $params['recursive'] = $this->boolToString($this->recursive);
        }

        if ($this->tagSlugs !== null) {
            $params['tagSlugs'] = implode(',', $this->tagSlugs);
        }

        if ($this->attach_to_process_env !== null) {
            $params['attach_to_process_env'] = $this->attach_to_process_env;
        }

        if ($this->skipUniqueValidation !== null) {
            $params['skipUniqueValidation'] = $this->skipUniqueValidation;
        }

        // We forcefully include imports as we're trying to move to a structure where users won't have to worry about imports vs. secrets.
        $params["include_imports"] = "true";
        
        return $params;
    }
    private function boolToString(bool $value): string
    {
        return $value ? 'true' : 'false';
    }
}
