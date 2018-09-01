<?php
namespace App\Controller;

use App\Entity\Url;
use App\Entity\UrlClick;
use App\Repository\UrlClickRepository;
use App\Repository\UrlRepository;
use App\Service\UidConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IndexController
 * @package App\Controller
 */
class LinkController extends AbstractController
{
    /**
     * Find url in db by uid and send redirect
     * @param string        $uid
     * @param Request       $request
     * @param UidConverter  $converter
     * @param UrlRepository $urlRepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function go(string $uid, Request $request, UidConverter $converter, UrlRepository $urlRepo)
    {
        $id = $converter->decode($uid);
        $url = $urlRepo->find($id);
        if ($url === null) {
            return $this->render('link.html.twig', ['text' => "Ссылка '{$uid}' не найдена!"]);
        }
        if ($url->getExpiredAt() !== null && $url->getExpiredAt() < new \DateTime()) {
            return $this->render('link.html.twig', ['text' => "Ссылка '{$uid}' просрочена!"]);
        }

        // save statistic to the db
        $click = new UrlClick();
        $click->setUrl($url)
            ->setIpStr($request->getClientIp())
            ->setReferer($request->headers->get('referer', ''))
            ->setUseragent($request->headers->get('User-Agent', ''));
        $em = $this->getDoctrine()->getManager();
        $em->persist($click);
        $em->flush();

        return $this->redirect($url->getUrl());
    }

    /**
     * Show a url clicks statistics
     * @param int                $urlId
     * @param UrlClickRepository $ucRepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function stat(int $urlId, UrlClickRepository $ucRepo)
    {
        $clicks = $ucRepo->findBy(['url' => $urlId]);

        return $this->render('stat.html.twig', ['clicks' => $clicks]);
    }
}
