<?php
namespace ViaCep\Src\Services;

use ViaCep\Src\Model\ZipCode;

class ZipCodeSecure
{
    private ZipCode $zipCode;

    public function __construct(ZipCode $zipCode)
    {
        $this->zipCode = $zipCode;
    }

    public function isValidZipCode(): bool
    {
        $zipCodeValue = $this->zipCode->getZipCode();
        $cleanedZipCode = preg_replace('/\D/', '', $zipCodeValue);
        return preg_match('/^\d{8}$/', $cleanedZipCode) === 1;
    }
}