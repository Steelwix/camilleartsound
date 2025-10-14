<?php

    namespace App\Form;

    use App\Entity\Media;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class VentureMediaType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('file', FileType::class, [
                    'label' => 'Remplacer l’image',
                    'mapped' => false, // on ne lie pas directement au champ de l’entité
                    'required' => false,
                ])
                ->add('delete', CheckboxType::class, [
                    'label' => 'Supprimer l’image actuelle',
                    'mapped' => false,
                    'required' => false,
                ]);
        }

        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => Media::class,
            ]);
        }
    }