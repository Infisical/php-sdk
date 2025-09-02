<?php

declare(strict_types=1);

namespace Infisical\SDK\Models;

/**
 * Machine identity credentials from universal auth
 */
class MachineIdentityCredential
{
    public function __construct(
        public readonly string $accessToken,
        public readonly int $expiresIn,
        public readonly int $accessTokenMaxTTL,
        public readonly string $tokenType
    ) {
    }

    /**
     * Create from array
     *
     * @param  array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['accessToken'] ?? '',
            $data['expiresIn'] ?? 0,
            $data['accessTokenMaxTTL'] ?? 0,
            $data['tokenType'] ?? ''
        );
    }

    /**
     * Convert to array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'accessToken' => $this->accessToken,
            'expiresIn' => $this->expiresIn,
            'accessTokenMaxTTL' => $this->accessTokenMaxTTL,
            'tokenType' => $this->tokenType,
        ];
    }
}
