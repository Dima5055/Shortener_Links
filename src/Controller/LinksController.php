<?php

namespace App\Controller;

use App\Entity\Links;
use App\Form\LinksForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\LinksRepository;

final class LinksController extends AbstractController
{

    #[Route('/', name: 'main_page', methods: ['GET', 'POST'])]
    public function index(Request $request, LinksRepository $linksRepository): Response
    {
        $shortUrl = null;

        $link = new Links();
        $form = $this->createForm(LinksForm::class, $link);


        $form->handleRequest($request);
        if  ($form->isSubmitted() && $form->isValid()) {
            do {
                $slug = $this->generateShortCode();
                $existingLink = $linksRepository->findOneBy(['shortUrl' => $slug]);
            } while ($existingLink !== null);
            is_null($link->getExpirationDate()) ?? $link->setExpirationDate(null);
            $linksRepository->saveNewLink($link, $slug);
//            $linksRepository->saveNewLink($link);


            $shortUrl = $linksRepository->fullShortLink($link->getShortUrl(), $request->getSchemeAndHttpHost());
        }

        return $this->render('links/index.html.twig', [
            'form' => $form->createView(),
            'shortUrl' => $shortUrl,
        ]);
    }

    #[Route('/all-links', name: 'all_links_page')]
    public function showAllLinks(LinksRepository $linksRepository): Response
    {
        $links = $linksRepository->findAll();
        return $this->render('links/all_links.html.twig', [
            'links' => $links,
        ]);
    }

    #[Route('/short/{slug}', name: 'redirect_short')]
    public function redirectUrl(string $slug, LinksRepository $linksRepository): Response
    {
        $link = $linksRepository->findOneBy(['shortUrl' => $slug]);
        if (!$link) {
            throw $this->createNotFoundException('Короткая ссылка не найдена.');
        }
        $linksRepository->updateClickLink($link);
        return $this->redirect($link->getOriginalUrl());
    }

    #[Route('/delete-links', name: 'delete_links', methods: ['POST'])]
    public function deleteSelectedLinks(Request $request, LinksRepository $linksRepository): Response
    {
        $selectedIds = $request->request->all('selected_links');
        $linksRepository->deleteByIds($selectedIds);
        return $this->redirectToRoute('all_links_page');
    }

    public function generateShortCode($length = 6): string {
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($str), 0, $length);
    }
}
