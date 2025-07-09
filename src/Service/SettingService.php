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

    }