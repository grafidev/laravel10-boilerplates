<?php

namespace App\Support;

use Maatwebsite\Excel\Validators\ValidationException;

class ImportValidator
{
    private $exception;

    public function __construct(ValidationException $exception)
    {
        $this->exception = $exception;
    }

    public static function make($e): static
    {
        return new self($e);
    }

    public function getMessage(): string
    {
        return collect($this->exception->failures())
            ->map(fn ($failure) => $this->translateError($failure))
            ->join('');
    }

    private function translateError($failure)
    {
        $attribute = $failure->attribute();
        $row = $failure->row();
        $errors = $failure->errors();
        $error = implode(', ', $errors);

        return "Il y a une erreur à la <b>ligne $row</b>, <b>Colonne concernée</b>: $attribute, <br><b>ERREUR</b>: $error";
    }
}
