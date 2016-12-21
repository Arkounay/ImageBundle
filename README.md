# Work In Progress

## Arkounay Image Bundle - Symfony Easier Doctrine image management

### Getting Started

- Download the files:
        
        composer require arkounay/image-bundle@dev

- In `AppKernel.php` add the bundle:
        
        new Arkounay\BlockBundle\ArkounayImageBundle()
        
- Then, run the following command:
     
        php bin/console assets:install 
        
- In your twig template, you will then need to import the required assets:
    
    - CSS:
        
            <link rel="stylesheet" href="{{ asset('bundles/arkounayimage/arkounay_image_bundle.css') }}">

    - JS (**requires [jQuery](https://jquery.com/) and [ninsuo/symfony-collection](https://github.com/ninsuo/symfony-collection)**):
    
            {# Import jQuery: #}
                <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
            {% endif %}
               
            {# Then the default bundle's JavaScript: #}
            {% include '@ArkounayImageBundle:assets:include_js.html.twig' %}
            
- In `routing.yml`, you will need to import the Ajax route:
        
         arkounay_image:
             resource: "@ArkounayImageBundle/Resources/config/routing.yml"
             
- In config.yml, add the following Doctrine types:

        doctrine:
            dbal:
                types:
                    arkounay_image:  Arkounay\ImageBundle\Type\JsonImageType
                    arkounay_images:  Arkounay\ImageBundle\Type\JsonImagesType
                    
### Usage
    
In an entity, you can now add the new Image Types:

    /**
     * @var Image
     * @ORM\Column(type="arkounay_image")
     */
    protected $image;
    
    /**
     * @var ArrayCollection|Image[]
     * @ORM\Column(type="arkounay_images")
     */
    protected $imageCollection;
    
You can bound these fields to a form using its corresponding type:

    use Arkounay\ImageBundle\Form\JsonImagesType;
    use Arkounay\ImageBundle\Form\JsonImageType;
    
    // ... 
    
    $builder
        ->add('image', JsonImageType::class)
        ->add('imageCollection', JsonImagesType::class);
    
### Editing the form HTML
Check `Resources/views/forms/fields.html.twig`