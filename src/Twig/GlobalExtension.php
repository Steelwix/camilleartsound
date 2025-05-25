<?php

    namespace App\Twig;

    use App\Service\MediaService;
    use Twig\Extension\AbstractExtension;
    use Twig\Extension\GlobalsInterface;

    class GlobalExtension extends AbstractExtension implements GlobalsInterface
    {
        private MediaService $mediaService;

        public function __construct(MediaService $mediaService)
        {
            $this->mediaService = $mediaService;
        }

        public function getGlobals(): array
        {
            return [
                'headerMedia' => $this->mediaService->getMedia('header'),
                'uploadDirectory' => $this->mediaService->uploadDirectory
            ];
        }
    }