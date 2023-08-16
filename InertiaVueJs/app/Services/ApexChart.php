<?php

namespace App\Services;

class ApexChart
{
    protected $width;

    protected $height;

    protected $labels;

    protected $title;

    protected $type;

    protected $data;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function make(string $type): self
    {
        return new self($type);
    }

    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    public function setLabels($labels)
    {
        $this->labels = $labels;

        return $this;
    }

    public function setDataset(string $title, $data)
    {
        $this->title = $title;
        $this->data = $data;

        return $this;
    }

    public function render()
    {
        return [
            'chart' => [
                'type' => $this->type,
                'height' => $this->height,
                'zoom' => [
                    'enabled' => false,
                ],
            ],
            'series' => [
                [
                    'name' => $this->title,
                    'data' => $this->data,
                ],
            ],
            'dataLabels' => [
                'enabled' => false,
            ],
            'stroke' => [
                'curve' => 'straight',
            ],
            'title' => [
                'text' => $this->title,
                'align' => 'left',
            ],
            'xaxis' => [
                'categories' => $this->labels,
            ],
        ];
    }
}
