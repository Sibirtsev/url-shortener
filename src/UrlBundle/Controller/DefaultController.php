<?php

namespace UrlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use UrlBundle\Entity\Url;
use UrlBundle\Event\VisitEvent;
use UrlBundle\Form\UrlType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        $form = $this->createForm(UrlType::class, null, [
            'action' => $this->generateUrl('create')
        ]);
        return $this->render('UrlBundle:Default:index.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $url = new Url();
        $form = $this->createForm(UrlType::class, $url, [
            'action' => $this->generateUrl('create')
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form->getData();
            $url->setCreated(new \Datetime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($url);
            $em->flush();
        }

        return $this->render('UrlBundle:Default:create.html.twig', [
            'form' => $form->createView(),
            'url' => $url
        ]);
    }

    /**
     * @Route("/go/{short}", name="redirect")
     * @param string  $short
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectAction(string $short)
    {
        $repository = $this->getDoctrine()->getRepository(Url::class);
        $url = $repository->findOneBy(['shortUrl' => $short]);

        $event = new VisitEvent($url);
        $dispatcher = $this->get('event_dispatcher');
        $dispatcher->dispatch(VisitEvent::NAME, $event);

        return $this->redirect($url->getUrl(), 302);
    }

    /**
     * @Route("/i/{short}", name="info")
     * @param string $short
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function infoAction(Request $request, string $short)
    {
        $repository = $this->getDoctrine()->getRepository(Url::class);
        $url = $repository->getInfo($short);

        return $this->render('UrlBundle:Default:info.html.twig', [
            'url' => $url
        ]);
    }
}
