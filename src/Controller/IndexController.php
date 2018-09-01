<?php
namespace App\Controller;

use App\Entity\Url;
use App\Service\UidConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends AbstractController
{
    /**
     * Index page
     *
     * @param UidConverter $converter
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, UidConverter $converter)
    {
        $url = new Url();

        $form = $this->createFormBuilder($url)
            ->add('url', UrlType::class)
            ->add('expiredAt', DateTimeType::class, [
                'required' => false,
                'widget' => 'single_text', 'html5' => false,
                'attr' => ['class' => 'js-datepicker']
            ])->add('save', SubmitType::class, ['label' => 'Уменьшить'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($url);
            $em->flush();

            return $this->render('success.html.twig', [
                'link' => $request->getSchemeAndHttpHost() . '/' . $converter->encode($url->getId()),
                'id' => $url->getId(),
            ]);
        }

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
