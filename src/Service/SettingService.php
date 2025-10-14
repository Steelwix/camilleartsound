<?php

    namespace App\Service;

    use AllowDynamicProperties;
    use App\Entity\Setting;
    use App\Entity\Venture;
    use Doctrine\ORM\EntityManagerInterface;


    #[AllowDynamicProperties] class SettingService
    {
        const DEFAULT_MAIL = 'cs.sabycamille@gmail.com';

        public function __construct(EntityManagerInterface $em)
        {
            $this->em = $em;
        }


        public function getProjectDisplay()
        {
            $projectDisplay = 6;

            $settingProjectDisplay = $this->em->getRepository(Setting::class)->findOneBy(['label' => 'projectDisplay']);
            if ($settingProjectDisplay) {
                $projectDisplay = $settingProjectDisplay->getValue();
            }
            return $projectDisplay;
        }

        public function getProjectPerRow()
        {
            $projectPerRow = 3;

            $settingProjectPerRow = $this->em->getRepository(Setting::class)->findOneBy(['label' => 'projectPerRow']);
            if ($settingProjectPerRow) {
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

        public function getBioText()
        {
            $text = $this->em->getRepository(Setting::class)->findOneBy(['type' => 'bio', 'label' => 'text']);
            if (!$text) {
                return '';
            }
            return $text->getValue();
        }

        public function manageContacts($formContacts): void
        {
            $contacts = [];
            $savedContactsJson = $this->em->getRepository(Setting::class)->findOneBy(['type' => 'contacts']);

            if ($savedContactsJson) {
                $savedContacts = json_decode($savedContactsJson->getValue(), true);
                foreach ($savedContacts as $contact) {
                    $contacts[$contact['position']]['position'] = $contact['text'];
                }
            }

            if (!$savedContactsJson) {
                $savedContactsJson = new Setting();
                $savedContactsJson->setLabel('contacts');
                $savedContactsJson->setType('contacts');
                $this->em->persist($savedContactsJson);
            }


            foreach ($formContacts as $contact) {
                $contacts[$contact['position']]['position'] = $contact['position'];
                $contacts[$contact['position']]['text'] = $contact['text'];
            }

            $contactsJson = json_encode($contacts);
            $savedContactsJson->setValue($contactsJson);
            $this->em->flush();
        }

        public function manageBioMail($mail)
        {
            $bioMail = $this->em->getRepository(Setting::class)->findOneBy(['type' => 'bio', 'label' => 'email']);
            if (!$bioMail) {
                $bioMail = new Setting();
                $bioMail->setLabel('email');
                $bioMail->setType('bio');
                $this->em->persist($bioMail);
            }
            $bioMail->setValue($mail);
            $this->em->flush();
        }

        public function getBioContacts()
        {
            $contacts = $this->em->getRepository(Setting::class)->findOneBy(['type' => 'contacts']);
            if (!$contacts) {
                return [];
            }
            $contacts = json_decode($contacts->getValue(), true);
            usort($contacts, function($a, $b) {
                return $a['position'] <=> $b['position'];
            });
            return $contacts;
        }

        public function getBioMail()
        {
            $mail = $this->em->getRepository(Setting::class)->findOneBy(['type' => 'bio', 'label' => 'email']);
            if (!$mail) {
                return self::DEFAULT_MAIL;
            }
            return $mail->getValue();
        }

        public function manageSocials($formSocials)
        {
            $socials = [];
            $savedSocialsJson = $this->em->getRepository(Setting::class)->findOneBy(['type' => 'bio', 'label' => 'socials']);

            if ($savedSocialsJson) {
                $savedSocials = json_decode($savedSocialsJson->getValue(), true);
                foreach ($savedSocials as $social) {
                    $socials[$social['position']]['position'] = $social['position'];
                    $socials[$social['position']]['link'] = $social['link'];
                    $socials[$social['position']]['network'] = $social['network'];
                    $socials[$social['position']]['customNetwork'] = $social['customNetwork'];
                }
            }

            if (!$savedSocialsJson) {
                $savedSocialsJson = new Setting();
                $savedSocialsJson->setLabel('socials');
                $savedSocialsJson->setType('bio');
                $this->em->persist($savedSocialsJson);
            }


            foreach ($formSocials as $social) {
                $socials[$social['position']]['position'] = $social['position'];
                $socials[$social['position']]['link'] = $social['link'];
                if($social['network'])
                {
                    $socials[$social['position']]['network'] = $social['network'];
                }
                if(!$social['network']){
                    $socials[$social['position']]['network'] = null;
                    $socials[$social['position']]['customNetwork'] = $social['customNetwork'];
                }
                if(!$social['network'] && !$social['customNetwork']){
                    unset($socials[$social['position']]);
                    continue;
                }
            }

            $socialsJson = json_encode($socials);
            $savedSocialsJson->setValue($socialsJson);
            $this->em->flush();
        }

        public function getBioSocials()
        {
            $socials = $this->em->getRepository(Setting::class)->findOneBy(['type' => 'bio', 'label' => 'socials']);
            if (!$socials) {
                return [];
            }
            $socials = json_decode($socials->getValue(), true);
            usort($socials, function($a, $b) {
                return $a['position'] <=> $b['position'];
            });
            return $socials;
        }

        public function getVentures()
        {
            $ventures = $this->em->getRepository(Venture::class)->findAll();
            if(!$ventures){
                return [];
            }
            $array = [];
            foreach ($ventures as $venture) {
                $array[$venture->getId()] = $venture;
            }
            return $array;
        }

    }