<?php

namespace App\DataTransferObjects\API\HRIS;

class ProjectDto
{
    public function __construct(
        public readonly ?int $project_id,
        public readonly ?string $project,
        public readonly ?string $project_prefix,
        public readonly ?string $location,
        public readonly ?string $location_prefix,
        public readonly ?int $pjo,
    ) {
    }

    public static function fromResponseByPosition(array $response): self
    {
        $data = [];
        if (isset($response['project'])) {
            $data = $response['project'];
        }
        return new self(
            isset($data['project_id']) ? $data['project_id'] : null,
            isset($data['project']) ? $data['project'] : null,
            isset($data['project_prefix']) ? $data['project_prefix'] : null,
            isset($data['location']) ? $data['location'] : null,
            isset($data['location_prefix']) ? $data['location_prefix'] : null,
            isset($data['pjo']) ? $data['pjo'] : null,
        );
    }
}