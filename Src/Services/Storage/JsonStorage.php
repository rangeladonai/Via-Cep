<?php
namespace ViaCep\Src\Services\Storage;

use Exception;

class JsonStorage implements StorageProvider
{
    private string $path;

    public function __construct(string $path = "../Json/")
    {
        $this->path = $path;
    }

    public function save(string $zipCode, array $data): bool
    {
        if (!is_dir($this->path)) {
            mkdir($this->path, 0777, true);
        }
        $file = $this->path . $zipCode . ".json";
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if (file_put_contents($file, $json) === false) {
            throw new Exception("Falha ao salvar o arquivo JSON para o CEP: " . $zipCode);
        }
        return true;
    }
}
