<?php

    namespace App\Controller\Back;

    use AllowDynamicProperties;
    use App\Entity\Media;
    use App\Form\MediaType;
    use App\Service\MediaService;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;
    use Symfony\Component\Security\Http\Attribute\IsGranted;
    use Symfony\UX\Turbo\TurboBundle;

    #[AllowDynamicProperties] class DashboardController extends AbstractController
    {
        public function __construct(MediaService $mediaService)
        {
            $this->mediaService = $mediaService;
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

            if ($form->isSubmitted() && $form->isValid()) {
                $this->mediaService->createMedia($form->get('media')->getData(), $spot);
                return $this->redirectToRoute('app_dashboard');
            }
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/media.html.twig', [
                'form' => $form->createView(), 'spot' => $spot
            ]);
        }
    }