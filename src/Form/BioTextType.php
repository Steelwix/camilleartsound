<?php

    namespace App\Form;

    use FOS\CKEditorBundle\Form\Type\CKEditorType;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\Validator\Constraints\File;

    class BioTextType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('text', TextareaType::class, [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'style' => 'display: none;', // on le masque
                        'id' => 'bio_text',
                    ],
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
