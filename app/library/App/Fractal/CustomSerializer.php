<?php

namespace App\Fractal;

class CustomSerializer extends \League\Fractal\Serializer\ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        if ($resourceKey == null) {
            return $data;
        }

        return [$resourceKey ?: 'data' => $data];
    }

    public function item($resourceKey, array $data)
    {
        if ($resourceKey == null) {
            return $data;
        }

        return [$resourceKey ?: 'data' => $data];
    }
}