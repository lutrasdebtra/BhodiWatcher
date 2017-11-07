<?php
// src/AppBundle/Controller/WatcherController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class WatcherController extends Controller
{
    /**
     * @Route("/watcher/search", name="watcher_search")
     */
    public function searchAction(Request $request)
    {
        $jobs = array(
            '1' => array('id' => '1', 'field_1' => 'test', 'field_2' => 'test'),
            '2' => array('id' => '2', 'field_1' => 'test', 'field_2' => 'test'),
        );
        $defaultData = array('column_name' => 'Field 1', 'column_value' => 'Field 1');
        $form = $this->createFormBuilder($defaultData)
            ->add('column_name', ChoiceType::class, array(
                'choices' => array(
                    'Field 1' => 'Field 1',
                    'Field 2' => 'Field 2'
                )))
            ->add('column_value', TextType::class)
            ->getForm();


        $form->handleRequest($request);
        // On submission.
        if ($form->isSubmitted() && $form->isValid()) {
        }

        return $this->render('watcher/search.html.twig', array(
            'form' => $form->createView(),
            'jobs' => $jobs
        ));
    }

    /**
     * @Route("/watcher/email/{id}", name="watcher_email")
     */
    public function emailAction(Request $request, \Swift_Mailer $mailer, $id)
    {
        $jobs = array(
            '1' => array('id' => '1', 'field_1' => 'test', 'field_2' => 'test'),
            '2' => array('id' => '2', 'field_1' => 'test', 'field_2' => 'test'),
        );
        $message = (new \Swift_Message('Failed Job'))
            ->setFrom('synbioadmin@lanzatech.com')
            ->setTo($request->get('WatchInputEmail'))
            ->setBody(
                $this->renderView(
                    'Emails/job.html.twig',
                    array('job' => $jobs[$id])
                ),
                'text/html'
            );
        $mailer->send($message);

        return $this->redirectToRoute("watcher_search");
    }
}