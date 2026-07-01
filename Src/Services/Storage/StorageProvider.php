<?php
namespace ViaCep\Src\Services\Storage;

interface StorageProvider
{
    /**
     * Persist CEP data.
     *
     * @param string $zipCode
     * @param array $data
     * @return bool
     */
    public function save(string $zipCode, array $data): bool;
}
