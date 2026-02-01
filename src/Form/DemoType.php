<?php

    namespace App\Form;

    use App\Entity\Demo;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\Validator\Constraints\File;

    class DemoType  extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('title', TextType::class, [
                    'required' => false,
                    'label' => 'Titre',
                ])

                ->add('media', FileType::class, [
                    'label' => 'Media principal',
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '100M',
                            'mimeTypes' => [
                                'video/mp4',
                                'video/quicktime',
                                'image/jpeg',
                                'image/png',
                                'image/gif',
                            ],
                            'mimeTypesMessage' => 'Format invalide',
                        ]),
                    ],
                ])

                ->add('thumbnail', FileType::class, [
                    'label' => 'Miniature',
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '10M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/gif',
                            ],
                            'mimeTypesMessage' => 'Image invalide',
                        ]),
                    ],
                ])
            ;
        }

        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => Demo::class,
            ]);
        }
    }