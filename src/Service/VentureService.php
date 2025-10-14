<?php

    namespace App\Service;

    use AllowDynamicProperties;
    use App\Entity\Venture;
    use Doctrine\ORM\EntityManagerInterface;

    #[AllowDynamicProperties] class VentureService
    {
        public function __construct(EntityManagerInterface $em, MediaService $mediaService)
        {
            $this->em = $em;
            $this->mediaService = $mediaService;
        }

        public function createVenture($form): Venture
        {
            $venture = new Venture();
            $this->em->persist($venture);
            $venture->setLabel($form['label']);
            $venture->setLink($form['link']);
            $lastId = $this->em->getRepository(Venture::class)->findMaxId();
            $lastId ++;
            $spot = 'venture' . $lastId;
            $media = $this->mediaService->createMedia($form['media'], $spot);
            $venture->setMedia($media);
            return $venture;
        }

        public function updateVenture(Venture $venture, $form): Venture
        {
            $venture->setLabel($form['label']);
            $venture->setLink($form['link']);
            if($form['media'] !== null){
                $this->mediaService->globalRemoveSpotMedia('venture' . $venture->getId());
                $media = $this->mediaService->createMedia($form['media'], 'venture' . $venture->getId());
                $venture->setMedia($media);
            }
            return $venture;
        }
    }