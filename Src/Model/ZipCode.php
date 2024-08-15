<?php
namespace ViaCep\Src\Model;

class ZipCode
{
    private int $zipCode;

    public function __construct(int $zipCode)
    {
        $this->zipCode = $zipCode;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }
}