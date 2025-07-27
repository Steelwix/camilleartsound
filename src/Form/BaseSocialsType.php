<?php

    namespace App\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use Symfony\Component\Form\Extension\Core\Type\IntegerType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class BaseSocialsType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
                ->add('network', ChoiceType::class, [
                    'choices' => [
                        'LinkedIn' => 'linkedin',
                        'Instagram' => 'instagram',
                        'Facebook' => 'facebook',
                        'X' => 'twitter',
                        'WhatsApp' => 'whatsapp',
                        'Discord' => 'discord',
                        'YouTube' => 'youtube',
                        'Twitch' => 'twitch',
                        'Pinterest' => 'pinterest',
                        'TikTok' => 'tiktok',
                        'Snapchat' => 'snapchat',
                        'Spotify' => 'spotify',
                        'Github' => 'github',

                    ],
                    'placeholder' => '',
                    'required' => false,
                ])
                ->add('customNetwork', TextType::class, [
                    'required' => false,
                ])
                ->add('link', TextType::class, [
                    'required' => true,
                ])
                ->add('position', IntegerType::class, [
                    'required' => true,
                ]);
        }

        public function configureOptions(OptionsResolver $resolver): void
        {
//        $resolver->setDefaults([
//            'data_class' => Media::class,
//        ]);
        }
    }