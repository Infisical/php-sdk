<?php

declare(strict_types=1);

namespace Infisical\SDK\Models;


/**
 * Represents a secret import 
 */
class SecretImport
{
    public function __construct(
        public readonly string $secretPath,
        public readonly string $environment,
        public readonly string $folderId,
        /**
         * @var Secret[] 
         */
        public readonly array $secrets,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['secretPath'] ?? '',
            $data['environment'] ?? '',
            $data['folderId'] ?? '',
            array_map(fn($data) => Secret::fromArray($data), $data['secrets'] ?? []),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'secretPath' => $this->secretPath,
            'environment' => $this->environment,
            'folderId' => $this->folderId,
            'secrets' => array_map(fn($secret) => $secret->toArray(), $this->secrets),
        ];
    }
}
