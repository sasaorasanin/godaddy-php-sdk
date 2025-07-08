<?php

namespace GoDaddy\Exceptions;

use Throwable;

class ValidationException extends ServiceException
{
    protected array $fields = [];

    public function __construct(
        string $message = 'Validation failed.',
        int $code = 422,
        ?Throwable $previous = null,
        array $fields = []
    ) {
        $this->fields = $fields;
        parent::__construct($message, $code, $previous);
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function hasField(string $path): bool
    {
        foreach ($this->fields as $field) {
            if (($field['path'] ?? '') === $path) {
                return true;
            }
        }
        return false;
    }

    public function getFieldError(string $path): ?string
    {
        foreach ($this->fields as $field) {
            if (($field['path'] ?? '') === $path) {
                return $field['message'] ?? null;
            }
        }
        return null;
    }
}
