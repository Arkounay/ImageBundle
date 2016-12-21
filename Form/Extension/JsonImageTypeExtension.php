<?php

namespace Arkounay\ImageBundle\Form\Extension;


use Arkounay\ImageBundle\Form\ImageType;
use Arkounay\ImageBundle\Form\JsonImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JsonImageTypeExtension extends AbstractTypeExtension
{

    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return JsonImageType::class;
    }

}
