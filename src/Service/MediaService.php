<?php

    namespace App\Service;

    use AllowDynamicProperties;
    use App\Entity\Media;
    use App\Entity\Setting;
    use App\Factory\MediaFactory;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Component\DependencyInjection\Attribute\Autowire;

    #[AllowDynamicProperties] class MediaService extends SettingService
    {
        public function __construct(MediaFactory $mediaFactory, EntityManagerInterface $em, #[Autowire('%upload_directory%')] $uploadDirectory)
        {
            $this->mediaFactory = $mediaFactory;
            $this->em = $em;
            $this->uploadDirectory = $uploadDirectory;
        }

        public function createMedia($file, $spot) {
            $newFilename = md5(uniqid()) . '.' . $file->guessExtension();
            $targetDirectory = $this->uploadDirectory . "/$spot/";

            $file->move(
                $targetDirectory,
                $newFilename
            );

            $this->globalRemoveSpotMedia($spot);

            $media = $this->mediaFactory->create([
                'name' => $newFilename,
                'type' => $spot
            ]);
            $this->em->persist($media);
            return $media;
        }

        public function globalRemoveSpotMedia($spot) :int {
            $qb = $this->em->createQueryBuilder();
            $qb->delete(Media::class, 'm')
                ->where('m.type = :spot')
                ->setParameter('spot', $spot);

            return $qb->getQuery()->execute(); // retourne le nombre d'entités supprimées
        }

        public function getMedia($spot) {
            $qb = $this->em->createQueryBuilder();
            $qb->select('m.name')
                ->from(Media::class, 'm')
                ->where('m.type = :spot')
                ->setParameter('spot', $spot);

            return $qb->getQuery()->getOneOrNullResult();
        }


        public function getProjects(): array
        {
            $projects = [];
            for($i=1; $i<=$this->getProjectDisplay(); $i++){
                $projects[$i] = $this->getMedia('project'.$i);
            }
            return $projects;
        }

        public function getAboutMedias(): array
        {
            $abouts = [];
            for($i=1; $i<=$this->getAboutDisplay(); $i++){
                $abouts[$i] = $this->getMedia('about'.$i);
            }
            return $abouts;
        }
    }