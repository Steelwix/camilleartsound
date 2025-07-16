<?php

    namespace App\Form;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\CollectionType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class ContactsCollectionType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder->add('contacts', CollectionType::class, [
                'entry_type'   => ContactsType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
            ]);
        }

        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
// 'data_class' => TaClasse::class, si tu veux binder à une entité
                                   ]);
        }
    }
