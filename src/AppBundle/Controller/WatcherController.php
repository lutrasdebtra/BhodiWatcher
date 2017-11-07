<?php
// src/AppBundle/Controller/WatcherController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class WatcherController extends Controller
{
    /**
     * @Route("/watcher/search", name="watcher_search")
     */
    public function searchAction(Request $request, \Swift_Mailer $mailer)
    {
        $defaultData = array('column_name' => 'Field 1', 'column_value' => '');
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
            $message = (new \Swift_Message('Failed Job'))
                ->setFrom('synbioadmin@lanzatech.com')
                ->setTo('stuart.bradley@lanzatech.com')
                ->setBody(
                    $this->renderView(
                        'Emails/job.html.twig'
                    ),
                    'text/html'
                );
            #$mailer->send($message);
        }

        return $this->render('watcher/search.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}