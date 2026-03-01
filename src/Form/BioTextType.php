<?php

    namespace App\Form;

    use FOS\CKEditorBundle\Form\Type\CKEditorType;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\Validator\Constraints\File;

    class BioTextType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('text1', TextareaType::class, [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'style' => 'display: none;', // on le masque
                        'id' => 'bio_text_1',
                    ],
                ])
                ->add('title1', TextType::class, [
                    'label' => false,
                    'required' => true,
                    'attr' => [
                    'placeholder' => 'Titre',
                    ]])
                ->add('text2', TextareaType::class, [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'style' => 'display: none;', // on le masque
                        'id' => 'bio_text_2',
                    ],
                ])
                ->add('title2', TextType::class, [
                    'label' => false,
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Titre',
                    ]

                ])
                ->add('text3', TextareaType::class, [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'style' => 'display: none;', // on le masque
                        'id' => 'bio_text_3',
                    ],
                ])
                ->add('title3', TextType::class, [
                    'label' => false,
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Titre',
                    ]

                ])

                ->add('save', SubmitType::class, [
                    'label' => 'Enregistrer',
                ]);
            ;
        }

        public function configureOptions(OptionsResolver $resolver): void
        {
//        $resolver->setDefaults([
//            'data_class' => Media::class,
//        ]);
        }
    }
