<?php

    namespace App\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\CollectionType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\Validator\Constraints\File;

    class AboutMediasType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $count = $options['count'] ?? 1;
            for ($i = 1; $i <= $count; $i++) {
                $builder->add('media_'.$i, FileType::class, [
                    'label' => 'Fichier',
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
                            'mimeTypesMessage' => 'Veuillez uploader une vidéo mp4/quicktime ou une image (jpeg, png, gif).',
                        ]),
                    ],
                ]);
            }

            $builder->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
            ]);
        }

        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'count' => 1, // valeur par défaut
            ]);
        }
    }
