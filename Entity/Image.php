<?php

namespace Arkounay\ImageBundle\Entity;

class Image implements \JsonSerializable
{

    /** @var string */
    private $path;

    /** @var string */
    private $alt;

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param string $alt
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'path' => $this->path,
            'alt' => $this->alt
        ];
    }

    public function getFilePath()
    {
        return substr($this->path, 1);
    }


}
