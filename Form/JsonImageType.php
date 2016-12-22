<?php

namespace Arkounay\ImageBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JsonImageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('path', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'arkounay.image.path.placeholder', 'readonly' => $options['path_readonly']],
            ])
            ->add('alt', TextType::class, [
                'required' => false
            ])
            ->add('file', FileType::class, [
                'attr' => ['class' => 'arkounay-image-file-input'],
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'required' => false,
            'data_class' => 'Arkounay\ImageBundle\Entity\Image',
            'by_reference' => false,
            'allow_alt' => true,
            'path_readonly' => false
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars = array_replace($view->vars, [
            'allow_alt' => $options['allow_alt'],
        ]);
    }



    public function getBlockPrefix()
    {
        return 'arkounay_image';
    }

}
