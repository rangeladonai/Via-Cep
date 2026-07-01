<?php
namespace ViaCep\Src\Controller;

use Exception;
use ViaCep\Src\Model\ZipCode;
use ViaCep\Src\Services\ZipCodeSecure;
use ViaCep\Src\Services\Facade\ViaCepService;
use ViaCep\Src\Services\Storage\StorageContext;
use ViaCep\Src\Services\Storage\JsonStorage;
use ViaCep\Src\Services\Storage\SqlStorage;

class ZipCodeController
{
    private ViaCepService $viaCepService;

    public function __construct()
    {
        $this->viaCepService = new ViaCepService();
    }

    /**
     * Search CEP using the ViaCepService Facade.
     */
    public function SearchCep()
    {
        header('Content-Type: application/json');
        try {
            $zipCodeInput = $_POST['zipCode'] ?? '';
            if (empty($zipCodeInput)) {
                throw new Exception("O CEP não pode estar vazio.");
            }

            // Sanitiza e valida o CEP antes de consultar
            $cleaned = preg_replace('/\D/', '', $zipCodeInput);
            $zipCodeModel = new ZipCode((int)$cleaned);
            $this->validZipCode($zipCodeModel);

            $data = $this->viaCepService->fetchAndNormalize($cleaned);
            echo json_encode(['success' => true, 'data' => $data]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Save CEP data using the chosen strategy (Strategy pattern).
     */
    public function SaveCep()
    {
        header('Content-Type: application/json');
        try {
            $zipCodeInput = $_POST['zipCode'] ?? '';
            $strategyName = $_POST['strategy'] ?? 'json';

            if (empty($zipCodeInput)) {
                throw new Exception("O CEP não pode estar vazio.");
            }

            $cleaned = preg_replace('/\D/', '', $zipCodeInput);
            $zipCodeModel = new ZipCode((int)$cleaned);
            $this->validZipCode($zipCodeModel);

            $data = [
                'zipCode'      => $cleaned,
                'place'        => $_POST['place'] ?? '',
                'neighborhood' => $_POST['neighborhood'] ?? '',
                'city'         => $_POST['city'] ?? '',
                'state'        => $_POST['state'] ?? '',
            ];

            // Define dynamic strategy
            if ($strategyName === 'sql') {
                $provider = new SqlStorage();
                $strategyMsg = "Banco de Dados SQL (arquivo Sql/saved_ceps.sql)";
            } else {
                $provider = new JsonStorage();
                $strategyMsg = "Arquivo JSON na pasta Json/";
            }

            $context = new StorageContext($provider);
            $context->executeSave($data['zipCode'], $data);

            $msg = "Sucesso! Dados salvos usando a estratégia: {$strategyMsg}!";
            $class = "alert alert-success";

            echo json_encode(['success' => true, 'msg' => $msg, 'class' => $class]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'msg' => "Erro ao salvar os dados: " . $e->getMessage(),
                'class' => "alert alert-danger"
            ]);
        }
    }

    /**
     * Legacy support for /save/cep/json.
     */
    public function SaveCepJsonFile()
    {
        $_POST['strategy'] = 'json';
        $this->SaveCep();
    }

    public function validZipCode(ZipCode $zipCode)
    {
        $zipCodeSecure = new ZipCodeSecure($zipCode);
        if ($zipCodeSecure->isValidZipCode() == false){
            // Se o CEP for válido com 8 dígitos mas perdeu o zero à esquerda devido ao cast float/int,
            // permitimos caso a string original tenha 8 dígitos.
            $val = (string)$zipCode->getZipCode();
            if (strlen($val) !== 8 && strlen(sprintf('%08d', $val)) !== 8) {
                throw new Exception("CEP inválido. Deve conter exactamente 8 dígitos.");
            }
        }
    }
}