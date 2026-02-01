<?php

    namespace App\Service;

    use AllowDynamicProperties;
    use App\Entity\Demo;
    use Doctrine\ORM\EntityManagerInterface;

    #[AllowDynamicProperties] class DemoService
    {

        public function __construct(EntityManagerInterface $em){
            $this->em = $em;
        }

        public function getDemos(): array
        {
            $demos = $this->em->getRepository(Demo::class)->findBy([], ['updatedAt' => 'DESC', 'id' => 'DESC']);
            $return = [];
            //Incrémentation pour marcher avec le systeme de display dynamique
            foreach ($demos as $i => $demo){
                $return[$i+1] = $demo;
            }
            return $return ?? [];
        }


    }