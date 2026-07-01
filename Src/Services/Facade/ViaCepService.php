<?php
namespace ViaCep\Src\Services\Facade;

use Exception;
use ViaCep\Src\Services\Adapter\ViaCepAdapter;

class ViaCepService
{
    private ViaCepAdapter $adapter;

    public function __construct()
    {
        $this->adapter = new ViaCepAdapter();
    }

    /**
     * Fetch raw data from ViaCep API, handle errors, and return normalized array.
     *
     * @param string $zipCode
     * @return array
     * @throws Exception
     */
    public function fetchAndNormalize(string $zipCode): array
    {
        $cleaned = preg_replace('/\D/', '', $zipCode);
        if (strlen($cleaned) !== 8) {
            throw new Exception("CEP inválido. Deve conter exactamente 8 dígitos numéricos.");
        }

        $url = "https://viacep.com.br/ws/{$cleaned}/json/";

        $context = stream_context_create([
            'http' => [
                'timeout' => 5,
                'ignore_errors' => true
            ]
        ]);

        $response = @file_get_contents($url, false, $context);
        if ($response === false) {
            throw new Exception("Erro de conexão ao acessar a API externa ViaCep.");
        }

        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Falha ao processar os dados da API ViaCep.");
        }

        if (isset($data['erro']) && $data['erro'] === true) {
            throw new Exception("O CEP informado não foi encontrado na base de dados.");
        }

        return $this->adapter->normalize($data);
    }
}
