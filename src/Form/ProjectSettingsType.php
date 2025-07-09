<?php

    namespace App\Form;

    use App\Entity\Media;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\IntegerType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class ProjectSettingsType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('projectDisplay', IntegerType::class, [
                    'label' => 'Nombre de projets affichés',
                ])
                ->add('projectPerRow', IntegerType::class, [
                    'label' => 'Nombre de projets par ligne',
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Enregistrer',
                ]);
            ;
        }

        public function configureOptions(OptionsResolver $resolver): void
        {

        }
    }
