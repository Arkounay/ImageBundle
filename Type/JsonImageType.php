<?php

namespace Arkounay\ImageBundle\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonArrayType;
use Arkounay\ImageBundle\Entity\Image;

class JsonImageType extends JsonArrayType
{
    const TYPE = 'json_image';


    public function getName()
    {
        return self::TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        return json_encode($value);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return new Image();
        }

        $value = (is_resource($value)) ? stream_get_contents($value) : $value;

        $json = json_decode($value, true);
        $res = new Image();

        if (isset($json['alt'])) {
            $res->setAlt($json['alt']);
        }

        if (isset($json['path'])) {
            $res->setPath($json['path']);
        }

        return $res;
    }

}