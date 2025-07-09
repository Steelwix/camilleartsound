<?php

    namespace App\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class ProjectMediaType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $projectDisplay = $options['projectDisplay'];
            for ($i = 1; $i <= $projectDisplay; $i++) {
                $builder
                    ->add('media'.$i, FileType::class, [
                        'label' => 'Fichier',
                    ]);
            }
            $builder->add('save', SubmitType::class, [
                    'label' => 'Enregistrer',
                ]);
            ;
        }

        public function configureOptions(OptionsResolver $resolver): void
        {
        $resolver->setDefaults([
            'projectDisplay' => 6
        ]);
        }
    }
