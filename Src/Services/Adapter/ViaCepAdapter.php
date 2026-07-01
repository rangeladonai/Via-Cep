<?php
namespace ViaCep\Src\Services\Adapter;

class ViaCepAdapter implements ViaCepAdapterInterface
{
    public function normalize(array $rawData): array
    {
        return [
            'zipCode'      => isset($rawData['cep']) ? preg_replace('/\D/', '', $rawData['cep']) : '',
            'place'        => $rawData['logradouro'] ?? '',
            'neighborhood' => $rawData['bairro'] ?? '',
            'city'         => $rawData['localidade'] ?? '',
            'state'         => $rawData['uf'] ?? '',
        ];
    }
}
