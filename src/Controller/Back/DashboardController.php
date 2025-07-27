<?php

    namespace App\Controller\Back;

    use AllowDynamicProperties;
    use App\Form\BioMailType;
    use App\Form\BioTextType;
    use App\Form\ContactsCollectionType;
    use App\Form\MediaType;
    use App\Form\ProjectSettingsType;
    use App\Form\SocialsCollectionType;
    use App\Service\MediaService;
    use App\Service\SettingService;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;
    use Symfony\Component\Security\Http\Attribute\IsGranted;
    use Symfony\UX\Turbo\TurboBundle;

    #[AllowDynamicProperties] class DashboardController extends AbstractController
    {
        public function __construct(MediaService $mediaService, SettingService $settingService)
        {
            $this->mediaService = $mediaService;
            $this->settingService = $settingService;
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

            $form = $this->createForm(MediaType::class);
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
                return $this->redirectToRoute('app_dashboard');
            }
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/media.html.twig', [
                'form' => $form->createView(), 'spot' => $spot
            ]);
        }

    #[\Symfony\Component\Routing\Annotation\Route('/dashboard/settings/projects', name: 'app_settings_projects')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
    public function settingsProjects(Request $request){
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
            'form' => $form->createView()
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
            $form = $this->createForm(ContactsCollectionType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->settingService->manageContacts($form->get('contacts')->getData());
                return $this->redirectToRoute('app_dashboard');

            }
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/bio/contacts.html.twig', [
                'form' => $form->createView()
            ]);
        }

        #[\Symfony\Component\Routing\Annotation\Route('/dashboard/settings/bio/mail', name: 'app_settings_bio_mail')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function settingsBioMail(Request $request){
            $bio = $this->settingService->getBioText();
            $form = $this->createForm(BioMailType::class);
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
            $form = $this->createForm(SocialsCollectionType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->settingService->manageSocials($form->get('socials')->getData());
                return $this->redirectToRoute('app_dashboard');

            }
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/bio/socials.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }