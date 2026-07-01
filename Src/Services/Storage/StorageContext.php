<?php
namespace ViaCep\Src\Services\Storage;

class StorageContext
{
    private StorageProvider $provider;

    public function __construct(StorageProvider $provider)
    {
        $this->provider = $provider;
    }

    public function setProvider(StorageProvider $provider): void
    {
        $this->provider = $provider;
    }

    public function executeSave(string $zipCode, array $data): bool
    {
        return $this->provider->save($zipCode, $data);
    }
}
