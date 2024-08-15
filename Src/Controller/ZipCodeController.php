<?php
namespace ViaCep\Src\Controller;

use Exception;
use ViaCep\Src\Core\Web;
use ViaCep\Src\Model\ZipCode;
use ViaCep\Src\Services\ZipCodeSecure;

class ZipCodeController
{
    public function SaveCepJsonFile()
    {
        if (empty($_POST['zipCode'])){
            throw new Exception(__METHOD__ . ": POST zipCode can't be empty");
        }
        
        $zipCode = new ZipCode($_POST['zipCode']);
        $this->validZipCode($zipCode);
        $json = $this->zipCodeDataJson($_POST);
        $saveMessage = $this->saveJson("../Json/", $zipCode->getZipCode(), $json);

        Web::View(['zipCode' => $zipCode->getZipCode(), 'msg' => $saveMessage], 'Home');
    }

    public function validZipCode(ZipCode $zipCode)
    {
        $zipCodeSecure = new ZipCodeSecure($zipCode);
        if ($zipCodeSecure->isValidZipCode() == false){
            throw new Exception(__METHOD__ . " Not a valid zip code");
        }
    }

    public function zipCodeDataJson(array $zipCodeData)
    {
        $data = json_encode([
            "ZipCode" => $zipCodeData['zipCode'],
            "City" => $zipCodeData['city'],
            "State" => $zipCodeData['state'],
            "Neighborhood" => $zipCodeData['neighborhood'],
            "Place" => $zipCodeData['place'],
        ]);
        return $data;
    }

    function saveJson(string $path, string $fileName, $json)
    {
        try{
            $file = $path . $fileName . ".json";
            file_put_contents($file, $json);
            return "Zip Code Saved! Json/" . $fileName . ".json";
        }catch (Exception $e){
            return $e->getMessage();
        }
    }
}