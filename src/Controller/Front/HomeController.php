<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Turbo\TurboBundle;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        return $this->render('home/index.html.twig');

    }

    #[Route('/home/about', name: 'app_home_about')]
    public function homeAbout(Request $request): Response
    {
        $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
        return $this->render('home/about.html.twig');

    }

    #[Route('/home/project', name: 'app_home_project')]
    public function homeProject(Request $request): Response
    {
        $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
        return $this->render('home/project.html.twig');

    }
}
