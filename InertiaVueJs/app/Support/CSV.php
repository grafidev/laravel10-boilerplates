<?php

namespace App\Support;

class CSV
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public static function from($file)
    {
        return new self($file);
    }

    public function columns()
    {
        return $this->openFile(fn ($handle) => array_filter(fgetcsv($handle, 1000, ',')));
    }

    public function onEachRow(callable $callable)
    {
        $this->openFile(function ($handle) use ($callable) {
            $columns = array_filter(fgetcsv($handle, 1000, ','));

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $row = [];

                for ($i = 0; $i < count($data); $i++) {
                    if (! isset($columns[$i])) {
                        continue;
                    }

                    $row[$columns[$i]] = $data[$i];
                }

                $callable($row);
            }
        });
    }

    protected function openFile(callable $callable)
    {
        $handle = fopen($this->file->getRealPath(), 'r');

        return $callable($handle);

        fclose($handle);
    }
}
