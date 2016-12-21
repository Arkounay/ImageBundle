<?php

namespace Arkounay\ImageBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JsonImageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('path', TextType::class)
            ->add('alt', TextType::class, [
                'required' => false
            ])
            ->add('file', FileType::class, [
                'attr' => ['class' => 'arkounay-image-file-input'],
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'required' => false,
            'data_class' => 'Arkounay\ImageBundle\Entity\Image',
            'by_reference' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return 'arkounay_image';
    }

}
