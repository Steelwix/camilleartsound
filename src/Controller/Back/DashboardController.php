<?php

    namespace App\Controller\Back;

    use AllowDynamicProperties;
    use App\Form\AboutDisplayType;
    use App\Form\AboutTextType;
    use App\Form\BioMailType;
    use App\Form\BioTextType;
    use App\Form\AboutMediasType;
    use App\Form\ContactsCollectionType;
    use App\Form\MediaType;
    use App\Form\ProjectSettingsType;
    use App\Form\SocialsCollectionType;
    use App\Service\MediaService;
    use App\Service\SettingService;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;
    use Symfony\Component\Security\Http\Attribute\IsGranted;
    use Symfony\UX\Turbo\TurboBundle;

    #[AllowDynamicProperties] class DashboardController extends AbstractController
    {

        public function __construct(MediaService $mediaService, SettingService $settingService, EntityManagerInterface $em)
        {
            $this->mediaService = $mediaService;
            $this->settingService = $settingService;
            $this->em = $em;
        }

        #[Route('/dashboard', name: 'app_dashboard')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function index(Request $request): Response
        {
            return $this->render('dashboard/index.html.twig');

        }

        #[\Symfony\Component\Routing\Annotation\Route('/dashboard/media/{spot}', name: 'app_settings_media')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function settingsMedia(Request $request, $spot){

            $media = $this->mediaService->getMedia($spot);
            $form = $this->createForm(MediaType::class, $media);
            $form->handleRequest($request);
//            dd(
//                $form->isSubmitted(),
//                $form->isValid(),
//                $form->get('media')->getErrors(true),
//                $form->getErrors(true),
//                $request->files->all(), // important si tu uploades un fichier
//                $request->request->all()
//            );
            if ($form->isSubmitted() && $form->isValid()) {
                $this->mediaService->createMedia($form->get('media')->getData(), $spot);
                $this->em->flush();
                return $this->redirectToRoute('app_dashboard');
            }
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/media.html.twig', [
                'form' => $form->createView(), 'spot' => $spot, 'media' => $media
            ]);
        }

    #[\Symfony\Component\Routing\Annotation\Route('/dashboard/settings/projects', name: 'app_settings_projects')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function settingsProjects(Request $request){
            $projects = $this->mediaService->getProjects();
        $projectDisplay = $this->settingService->getProjectDisplay();
        $projectPerRow = $this->settingService->getProjectPerRow();
        $form = $this->createForm(ProjectSettingsType::class, [
            'projectDisplay' => $projectDisplay,
            'projectPerRow' => $projectPerRow]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->settingService->manageProjectSettings($form);
            return $this->redirectToRoute('app_dashboard');
        }
        $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
        return $this->render('dashboard/settings/projects.html.twig', [
            'form' => $form->createView(), 'projects' => $projects
        ]);
    }

        #[\Symfony\Component\Routing\Annotation\Route('/dashboard/settings/projects/media', name: 'app_settings_projects_media')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function settingsProjectsMedia(Request $request){
            $projectDisplay = $this->settingService->getProjectDisplay();
            $projectPerRow = $this->settingService->getProjectPerRow();
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/projectMedia.html.twig', ['projectDisplay' => $projectDisplay, 'projectPerRow' => $projectPerRow
            ]);
        }

        #[\Symfony\Component\Routing\Annotation\Route('/dashboard/settings/bio/text', name: 'app_settings_bio_text')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function settingsBioText(Request $request){
            $bio = $this->settingService->getBioText();
            $form = $this->createForm(BioTextType::class, ["text" => $bio]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                    $this->settingService->manageBioText($form->get('text')->getData());
                return $this->redirectToRoute('app_dashboard');

            }
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/bio/text.html.twig', [
                'form' => $form->createView()
            ]);
        }

        #[\Symfony\Component\Routing\Annotation\Route('/dashboard/settings/bio/contacts', name: 'app_settings_bio_contacts')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function settingsContacts(Request $request){
            $existingContacts = $this->settingService->getBioContacts();
            $form = $this->createForm(ContactsCollectionType::class, ['contacts' => $existingContacts]);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->settingService->manageContacts($form->get('contacts')->getData());
                return $this->redirectToRoute('app_dashboard');

            }
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/bio/contacts.html.twig', [
                'form' => $form->createView(), 'existingContacts' => $existingContacts
            ]);
        }

        #[\Symfony\Component\Routing\Annotation\Route('/dashboard/settings/bio/mail', name: 'app_settings_bio_mail')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function settingsBioMail(Request $request){
            $bio = $this->settingService->getBioMail();
            $form = $this->createForm(BioMailType::class, ["mail" => $bio]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->settingService->manageBioMail($form->get('mail')->getData());
                return $this->redirectToRoute('app_dashboard');

            }
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/bio/mail.html.twig', [
                'form' => $form->createView()
            ]);
        }


        #[\Symfony\Component\Routing\Annotation\Route('/dashboard/settings/bio/socials', name: 'app_settings_bio_socials')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function settingsSocials(Request $request){
            $socials = $this->settingService->getBioSocials();
            $form = $this->createForm(SocialsCollectionType::class, ['socials' => $socials]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->settingService->manageSocials($form->get('socials')->getData());
                return $this->redirectToRoute('app_dashboard');

            }
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/bio/socials.html.twig', [
                'form' => $form->createView(), 'socials' => $socials
            ]);
        }

        #[\Symfony\Component\Routing\Annotation\Route('/dashboard/settings/about/text', name: 'app_settings_about_text')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function settingsAboutText(Request $request){
            $about = $this->settingService->getAboutText();
            $data = [];
            foreach ($about as $setting) {
                $data[$setting->getLabel()] = $setting->getValue();
            }
            $display = $this->settingService->getAboutDisplay();

            $form = $this->createForm(AboutTextType::class,$data, ["textCount"=>$display]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->settingService->manageAboutText($form->getData());
                $this->em->flush();
                return $this->redirectToRoute('app_dashboard');

            }
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/about/text.html.twig', [
                'form' => $form->createView(), 'textCount' => $display
            ]);
        }

        #[\Symfony\Component\Routing\Annotation\Route('/dashboard/settings/about/display', name: 'app_settings_about_display')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function settingsAboutDisplay(Request $request){
            $display = $this->settingService->getAboutDisplay();

            $form = $this->createForm(AboutDisplayType::class, ['textCount' => $display]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->settingService->manageAboutDisplay($form->getData());
                $this->em->flush();
                return $this->redirectToRoute('app_dashboard');

            }
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/about/display.html.twig', [
                'form' => $form->createView()
            ]);
        }

        #[\Symfony\Component\Routing\Annotation\Route('/dashboard/settings/about/medias', name: 'app_settings_about_medias')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function settingsAboutMedias(Request $request){
            $display = $this->settingService->getAboutDisplay();
            $form = $this->createForm(AboutMediasType::class,null, ['count' => $display]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $i = 1;
                foreach ($form->getData() as $media) {
                    $this->mediaService->createMedia($media, 'about'.$i);
                    $i++;
                }
                $this->em->flush();
                return $this->redirectToRoute('app_dashboard');

            }
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/about/medias.html.twig', [
                'form' => $form->createView(), 'count' => $display
            ]);
        }
    }