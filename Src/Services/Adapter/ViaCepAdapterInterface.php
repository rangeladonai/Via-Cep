<?php
namespace ViaCep\Src\Services\Adapter;

interface ViaCepAdapterInterface
{
    /**
     * Normalize the raw API response to the system's expected internal format.
     *
     * @param array $rawData
     * @return array
     */
    public function normalize(array $rawData): array;
}
