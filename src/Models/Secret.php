<?php

declare(strict_types=1);

namespace Infisical\SDK\Models;

/**
 * Represents a secret with key and value
 */
class Secret
{
    public function __construct(
        public readonly string $secretKey,
        public readonly string $secretValue,
        public readonly string $id,
        public readonly string $workspaceId,
        public readonly string $environment,
        public readonly int $version,
        public readonly string $type,
        public readonly string $secretComment,
        public readonly bool $skipMultilineEncoding,
        public readonly string $secretPath,
        public readonly bool $secretValueHidden,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['secretKey'] ?? '',
            $data['secretValue'] ?? '',
            $data['id'] ?? '',
            $data['workspaceId'] ?? '',
            $data['environment'] ?? '',
            $data['version'] ?? 0,
            $data['type'] ?? '',
            $data['secretComment'] ?? '',
            $data['skipMultilineEncoding'] ?? false,
            $data['secretPath'] ?? '',
            $data['secretValueHidden'] ?? false,
        );
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'secretKey' => $this->secretKey,
            'secretValue' => $this->secretValue,
        ];
    }
}
