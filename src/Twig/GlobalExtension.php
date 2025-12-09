<?php

    namespace App\Twig;

    use AllowDynamicProperties;
    use App\Entity\Setting;
    use App\Service\MediaService;
    use App\Service\SettingService;
    use Doctrine\ORM\EntityManagerInterface;
    use Twig\Extension\AbstractExtension;
    use Twig\Extension\GlobalsInterface;

    #[AllowDynamicProperties] class GlobalExtension extends AbstractExtension implements GlobalsInterface
    {

        public function __construct(MediaService $mediaService,SettingService $settingService, EntityManagerInterface $em)
        {
            $this->mediaService = $mediaService;
            $this->settingService = $settingService;
            $this->em = $em;
        }

        public function getGlobals(): array
        {

            return [
                'headerMedia' => $this->mediaService->getMedia('header'),
                'showreel' => $this->mediaService->getMedia('showreel'),
                'uploadDirectory' => $this->mediaService->uploadDirectory,
                'projectDisplay' => $this->settingService->getProjectDisplay(),
                'projectPerRow' => $this->settingService->getProjectPerRow(),
                'projects' => $this->mediaService->getProjects(),
                'bioText' => $this->settingService->getBioText(),
                'bioImage' => $this->mediaService->getMedia('bio'),
                'bioContacts' => $this->settingService->getBioContacts(),
                'bioMail' => $this->settingService->getBioMail(),
                'bioSocials' => $this->settingService->getBioSocials(),
                'ventures' => $this->settingService->getVentures(),
                'aboutTexts' => $this->settingService->getAboutText(),
                'aboutMedias' => $this->mediaService->getAboutMedias(),
                'aboutDisplay' => $this->settingService->getAboutDisplay(),
            ];
        }
    }