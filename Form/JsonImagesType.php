<?php

namespace Arkounay\ImageBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JsonImagesType extends CollectionType
{

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $entryOptionsNormalizer = function (Options $options, $value) {
            $value['block_name'] = 'entry';

            return $value;
        };

        $resolver->setDefaults([
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true,
            'prototype_data' => null,
            'prototype_name' => '__name__',
            'entry_type' => JsonImageType::class,
            'entry_options' => [],
            'delete_empty' => false,
            'by_reference' => false,
            'required' => false,
            'min' => 0,
            'max' => 100,
            'init_with_n_elements' => 1,
            'add_at_the_end' => true
        ]);

        $resolver->setNormalizer('entry_options', $entryOptionsNormalizer);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars = array_replace($view->vars, [
            'data_max' => $options['max'],
            'data_min' => $options['min'],
            'data_init_with_n_elements' => $options['init_with_n_elements'],
            'data_add_at_the_end' => $options['add_at_the_end'],
        ]);
    }

    public function getBlockPrefix()
    {
        return 'arkounay_images';
    }


}
