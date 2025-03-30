<?php

    namespace App\Controller\Back;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;
    use Symfony\Component\Security\Http\Attribute\IsGranted;
    use Symfony\UX\Turbo\TurboBundle;

    class DashboardController extends AbstractController
    {
        #[Route('/dashboard', name: 'app_dashboard')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function index(Request $request): Response
        {
            return $this->render('dashboard/index.html.twig');

        }

        #[\Symfony\Component\Routing\Annotation\Route('/dashboard/media', name: 'app_settings_media')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function settingsMedia(Request $request){
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('dashboard/settings/media.html.twig');
        }
    }