<?php

    namespace App\Form;

    use App\Entity\Venture;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class VentureType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('label', TextType::class, [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                    ],
                ])
                ->add('media', FileType::class, [
                    'label' => 'Fichier',
                    'mapped' => false,
                    'required' => false,
                ])
                ->add('link', TextType::class, [
                    'label' => 'Lien',
                ])

                ->add('save', SubmitType::class, [
                    'label' => 'Enregistrer',
                ]);
            ;
        }

        public function configureOptions(OptionsResolver $resolver): void
        {
        $resolver->setDefaults([
            'data_class' => Venture::class,
        ]);
        }
    }
