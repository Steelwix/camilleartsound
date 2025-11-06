<?php

    namespace App\Controller\Back;

    use AllowDynamicProperties;
    use App\Entity\Venture;
    use App\Form\VentureType;
    use App\Service\MediaService;
    use App\Service\SettingService;
    use App\Service\VentureService;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;
    use Symfony\Component\Security\Http\Attribute\IsGranted;
    use Symfony\UX\Turbo\TurboBundle;

    #[AllowDynamicProperties] class VentureController extends AbstractController
    {
        public function __construct(MediaService $mediaService, SettingService $settingService, EntityManagerInterface $em, VentureService $ventureService)
        {
            $this->mediaService = $mediaService;
            $this->settingService = $settingService;
            $this->em = $em;
            $this->ventureService = $ventureService;
        }
        #[Route('/home/venture/edit', name: 'app_venture_page_edit')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function venturePageEdit(Request $request): Response
        {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('home/venture.html.twig', ['editMode' => true]);

        }

        #[Route('/home/venture/edit/add', name: 'app_home_venture_edit_add')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function ventureAdd(Request $request): Response
        {
            $ventureForm = $this->createForm(VentureType::class);
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('home/venture/add.html.twig', ['ventureForm' => $ventureForm->createView()]);

        }

        #[Route('/home/venture/edit/create', name: 'app_home_venture_edit_create')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function ventureCreate(Request $request): Response
        {
            $form = $request->request->all()['venture'];
            $media = $request->files->all()['venture'];
            $datas = array_merge($form, $media);
            $this->ventureService->createVenture($datas);
            $this->em->flush();
            return $this->redirectToRoute('app_venture_page_edit');
        }

        #[Route('/home/venture/edit/edit', name: 'app_home_venture_edit_edit')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function ventureEdit(Request $request): Response
        {

            $id = $request->query->all()['id'];
            $venture = $this->em->getRepository(Venture::class)->find($id);
            $ventureForm = $this->createForm(VentureType::class, $venture);
            $ventureForm->handleRequest($request);

            if($ventureForm->isSubmitted() && $ventureForm->isValid()){
                $form = $request->request->all()['venture'];
                $media = $request->files->all()['venture'];
                $datas = array_merge($form, $media);
                $this->ventureService->updateVenture($venture, $datas);
                $this->em->flush();
                return $this->redirectToRoute('app_venture_page_edit');
            }
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
            return $this->render('home/venture/edit.html.twig', ['ventureForm' => $ventureForm->createView(), 'venture' => $venture]);

        }

        #[Route('/home/venture/edit/delete', name: 'app_home_venture_edit_delete')]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function ventureDelete(Request $request): Response
        {
            $id = $request->query->all()['id'];
            $venture = $this->em->getRepository(Venture::class)->find($id);
            $this->mediaService->globalRemoveSpotMedia('venture' . $venture->getId());
            $this->em->remove($venture);
            $this->em->flush();
            
            return $this->redirectToRoute('app_venture_page_edit');


        }

        #[Route('/home/venture/edit/confirm', name: 'app_home_venture_edit_confirm', methods: ['POST'])]
        #[IsGranted('ROLE_ADMIN', message: 'Vous n\'avez pas les droits suffisants pour intéragir avec cette route')]
        public function ventureConfirm(Request $request, EntityManagerInterface $em): JsonResponse
        {
            // Récupère les données JSON envoyées par fetch
            $data = json_decode($request->getContent(), true);

            if (!isset($data['order']) || !is_array($data['order'])) {
                return new JsonResponse(['status' => 'error', 'message' => 'Order missing'], 400);
            }

            $order = $data['order'];

            foreach ($order as $spot => $ventureId) {
                $venture = $this->em->getRepository(Venture::class)->find($ventureId);
                if ($venture) {
                    $venture->setSpot($spot); // met à jour le champ spot selon la position dans le tableau
                }
            }

            $em->flush();

            return new JsonResponse(['status' => 'success']);
        }

        
    }