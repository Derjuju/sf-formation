<?php

namespace AppBundle\Controller;

use AppBundle\Form\Domain\Contact;
use AppBundle\Form\Type\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact_us")
     * @Method({ "GET", "POST" })
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);
        $form->add('submit', 'submit');
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
            $body = $this->renderView('Contact/contact.txt.twig', [
                'contact' => $contact,
            ]);

            $message = \Swift_Message::newInstance()
                ->setFrom($contact->emailAddress, $contact->fullName)
                ->setTo('admin@monsite.com')
                ->setSubject($contact->subject)
                ->setBody($body)
            ;

            $this->get('mailer')->send($message);
            
            return $this->redirect($this->generateUrl('contact_us'));
        }

        return $this->render('Contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
