<?php

    namespace App\Service;

    use AllowDynamicProperties;
    use App\Entity\Setting;
    use Doctrine\ORM\EntityManagerInterface;

    #[AllowDynamicProperties] class SettingService
    {
        public function __construct(EntityManagerInterface $em)
        {
            $this->em = $em;
        }


        public function getProjectDisplay() {
            $projectDisplay = 6;

            $settingProjectDisplay = $this->em->getRepository(Setting::class)->findOneBy(['label' => 'projectDisplay']);
            if($settingProjectDisplay){
                $projectDisplay = $settingProjectDisplay->getValue();
            }
            return $projectDisplay;
        }

        public function getProjectPerRow() {
            $projectPerRow = 3;

            $settingProjectPerRow = $this->em->getRepository(Setting::class)->findOneBy(['label' => 'projectPerRow']);
            if($settingProjectPerRow){
                $projectPerRow = $settingProjectPerRow->getValue();
            }
            return $projectPerRow;
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

        public function manageBioText($rawHtmlText): void
        {
            $cleanHtmlText = preg_replace('#^<div>(.*)</div>$#s', '$1', $rawHtmlText);
            $text = $this->em->getRepository(Setting::class)->findOneBy(['type' => 'bio', 'label' => 'text']);
            if (!$text) {
                $text = new Setting();
                $text->setLabel('text');
                $text->setType('bio');
                $this->em->persist($text);
            }

            $text->setValue($cleanHtmlText);
            $this->em->flush();
            return;
        }

        public function getBioText() {
            $text = $this->em->getRepository(Setting::class)->findOneBy(['type' => 'bio', 'label' => 'text']);
            if(!$text) return '';
            return $text->getValue();
        }

    }