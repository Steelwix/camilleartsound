<?php

    namespace App\Controller\Back;

    use AllowDynamicProperties;
    use App\Entity\Media;
    use App\Form\MediaType;
    use App\Form\ProjectMediaType;
    use App\Form\ProjectSettingsType;
    use App\Service\MediaService;
    use App\Service\ProjectService;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;
    use Symfony\Component\Security\Http\Attribute\IsGranted;
    use Symfony\UX\Turbo\TurboBundle;

    #[AllowDynamicProperties] class DashboardController extends AbstractController
    {
        public function __construct(MediaService $mediaService, ProjectService $projectService)
        {
            $this->mediaService = $mediaService;
            $this->projectService = $projectService;
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
        $form = $this->createForm(ProjectSettingsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->projectService->manageProjectSettings($form);
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
            $projectDisplay = 6; //TODO: get from DB
            $projectPerRow = 3;
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/projectMedia.html.twig', ['projectDisplay' => $projectDisplay, 'projectPerRow' => $projectPerRow
            ]);
        }
    }