<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResponseResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'response' => [
                'status' => $this->resource['status'] ?? '',
                'message' => $this->resource['message'] ?? '',
                'data' => $this->resource['data'] ?? null,
            ]
        ];
    }

    public const DELETED_SERIES = [
        'status' => 'success',
        'message' => 'Successfully deleted series',
        'data' => null,
    ];

    public const UNAUTHORIZED = [
        'status' => 'unauthorized',
        'message' => 'Unauthorized: Invalid token',
        'data' => null,
    ];

    public const CONNECTED = [
        'status' => 'succes',
        'message' => 'Connected',
        'data' => null,
    ];

    public const NOTOKEN = [
        'status' => 'error',
        'message' => 'No secret found in the ENV file',
        'data' => null,
    ];
}
