<?php

    namespace App\Service;

    use AllowDynamicProperties;
    use App\Entity\Media;
    use App\Entity\Setting;
    use App\Factory\MediaFactory;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Component\DependencyInjection\Attribute\Autowire;

    #[AllowDynamicProperties] class ProjectService extends SettingService
    {
        public function __construct(EntityManagerInterface $em)
        {
            $this->em = $em;
        }

        public function manageProjectSettings($form): void
        {
            $formSettings['projectDisplay'] = $form->get('projectDisplay')->getData();
            $formSettings['projectPerRow'] = $form->get('projectPerRow')->getData();
            foreach ($formSettings as $key => $formValue) {
                $setting = $this->em->getRepository(Setting::class)->findOneBy(['type' => 'project', 'label' => $key]);
                if (!$setting) {
                    $setting = new Setting();
                    $setting->setLabel($key);
                    $setting->setType('project');
                    $this->em->persist($setting);
                }
                $setting->setValue($formValue);
            }
            $this->em->flush();

        }

    }