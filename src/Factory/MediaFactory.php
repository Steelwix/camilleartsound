<?php

    namespace App\Factory;

    use App\Entity\Media;

    class MediaFactory
    {
        public function create($datas){
            $media = new Media();
            $media->setName($datas['name']);
            $media->setType($datas['type']);
            return $media;
        }
    }