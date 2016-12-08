<?php

namespace nacholibre\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use nacholibre\DoctrineTranslatableFormBundle\Form\AbstractTranslatableType;
use Symfony\Component\Validator\Constraints as Assert;
use nacholibre\AdminBundle\Form\DynamicSlugType;
//use Cocur\Slugify\Slugify;
//use EasySlugger\Slugger;
//use nacholibre\Utils\Test;

class PostType extends AbstractTranslatableType
{
    private $container;

    function __construct($container, $mapper) {
        $this->container = $container;
        $params = $container->getParameter('nacholibre_news');
        $this->postClass = $params['entity_class'];
        parent::__construct($mapper);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $parameters = $this->container->getParameter('nacholibre_news');
        $editor = $parameters['editor'];

        $translatableBuilder = $this->createTranslatableMapper($builder, $options);

        $translatableBuilder
            ->add('title', TextType::class, [
                'label' => 'Title'
            ])
        ;

        $translatableBuilder->add('slug', DynamicSlugType::class, [
            'label' => 'Slug',
            'required' => true,
            'slug_input' => 'title',
            'toggable' => true,
            'constraints_required_locales' => [
                new Assert\NotBlank(),
            ],
            //'disabled' => true,
        ]);

        if ($editor['name'] == 'ckeditor') {
            $editorConfig = [
            ];

            if ($editor['elfinder_integration']) {
                $editorConfig['filebrowserBrowseRoute'] = $editor['elfinder_browse_route'];
                $editorConfig['filebrowserBrowseRouteParameters'] = [
                    'instance' => $editor['elfinder_instance'],
                    'homeFolder' => $editor['elfinder_homefolder'],
                ];
            }

            $translatableBuilder->add('content', 'Ivory\CKEditorBundle\Form\Type\CKEditorType' , [
                'config_name' => $editor['config_name'],
                'config' => $editorConfig,
                'label' => 'Content',
                'required' => true,
            ]);
        } else {
            $translatableBuilder->add('content', TextareaType::class , [
                'label' => 'Content',
                'required' => true,
            ]);
        }

        $builder->add('image', 'nacholibre\RichUploaderBundle\Form\Type\RichUploaderType', [
            'entity_class' => 'nacholibre\NewsBundle\Entity\NewsImage',
            'required' => true,
            'multiple' => false, //false for single files and true for multiple
            'size' => 'md', //available options md and xs
        ]);

        //$builder
        //    ->add('active', CheckboxType::class, [
        //        'label' => 'Active',
        //    ])
        //    ->add('commentsEnabled', CheckboxType::class, [
        //        'label' => 'Enable comments'
        //    ])
        //    //->add('startDate', 'datetime')
        //    //->add('createdAt', 'datetime')
        //    //->add('modifiedAt', 'datetime')
        //;

        //$builder->add('imageFile', VichImageType::class, array(
        //    'label' => 'Post Photo',
        //    'required'      => false,
        //    'allow_delete'  => true, // not mandatory, default is true
        //    'download_link' => false, // not mandatory, default is true
        //));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            //'data_class' => 'nacholibre\NewsBundle\Entity\Post'
            //'data_class' => 'AppBundle\Entity\Post'
            'data_class' => $this->postClass
        ));

        $this->configureTranslationOptions($resolver);
    }
}
