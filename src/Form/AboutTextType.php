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

    class AboutTextType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $count = $options['textCount'] ?? 1;
            for ($i = 1; $i <= $count; $i++) {
                $builder->add('text_' . $i, TextareaType::class, [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'style' => 'height: 200px;',
                        'class' => 'dynamic-textarea',
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
                'textCount' => 1, // valeur par défaut
            ]);
        }
    }
