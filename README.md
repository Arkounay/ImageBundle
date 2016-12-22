# Work In Progress

## Arkounay Image Bundle - Symfony Easier Doctrine image management

![alt tag](http://outerark.com/symfony/arkounay_image_bundle.png)

### Getting Started

- Download the files:
        
        composer require arkounay/image-bundle "dev-master"

- In `AppKernel.php` add the bundle:
        
        new Arkounay\ImageBundle\ArkounayImageBundle()
        
- Then, run the following command:
     
        php bin/console assets:install 
        
- In your twig template, you will then need to import the required assets:
    
    - CSS:
        
            <link rel="stylesheet" href="{{ asset('bundles/arkounayimage/arkounay_image_bundle.css') }}">

    - JS (**requires [jQuery](https://jquery.com/), [ninsuo/symfony-collection](https://github.com/ninsuo/symfony-collection) and optionnaly [bootstrap](http://getbootstrap.com/)**):
    
            {# Import jQuery: #}
                <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
            {% endif %}
               
            {# Then the default bundle's JavaScript: #}
            {% include '@ArkounayBlock/assets/include_js.html.twig' %}
            
- In `routing.yml`, you will need to import the Ajax route:
        
         arkounay_image:
             resource: "@ArkounayImageBundle/Resources/config/routing.yml"
             
- In config.yml, add the following Doctrine types:

        doctrine:
            dbal:
                types:
                    json_image: Arkounay\ImageBundle\Type\JsonImageType
                    json_images: Arkounay\ImageBundle\Type\JsonImagesType
                    
### Usage
    
In an entity, you can now add the new `json_image` types:

    /**
     * @var Image
     * @ORM\Column(type="json_image")
     */
    protected $image;
    
    /**
     * @var ArrayCollection|Image[]
     * @ORM\Column(type="json_images")
     */
    protected $imageCollection;
    
You can bound these fields to a form using its corresponding type:

    use Arkounay\ImageBundle\Form\JsonImagesType;
    use Arkounay\ImageBundle\Form\JsonImageType;
    
    // ... 
    
    $builder
        ->add('image', JsonImageType::class)
        ->add('imageCollection', JsonImagesType::class);
    
### Options:

**JsonImageType:**
- `'allow_alt' => true` allows the user to specify an alt
- `'path_readonly' => false` prevents the user from manually changing the path (it only adds a "readonly" attribute to the corresponding HTML input) 

**JsonsImageType:**

Some [ninsuo/symfony-collection](https://github.com/ninsuo/symfony-collection)'s options are available directly:
- `'min' => 0`
- `'max' => 100`
- `'init_with_n_elements' => 1`
- `'add_at_the_end' => true`

### Editing the form HTML
Check `Resources/views/forms/fields.html.twig`

