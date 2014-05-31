<?php

namespace Salita\OtrosBundle\Controller;

use Salita\OtrosBundle\Form\Type\BarrioType;
use Salita\OtrosBundle\Entity\Barrio;
use Salita\OtrosBundle\Entity\Pais;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('SalitaOtrosBundle:Default:index.html.twig', array('name' => $name));
    }



    public function newBarrioAction(Request $request)
    {
        $barrio= new Barrio();
        $form = $this->createForm(new Barriotype(),$barrio);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($barrio);
                $em->flush();
            }
        }
        else
        {
            return $this->render('SalitaOtrosBundle:BarrioForm:new.html.twig', array('form' => $form->createView(),
            ));
        }
    }




    public function newPaisAction(Request $request)
    {
        $barrio= new Barrio();
        $form = $this->createForm(new Barriotype(),$barrio);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($barrio);
                $em->flush();
            }
        }
        else
        {
            return $this->render('SalitaOtrosBundle:BarrioForm:new.html.twig', array('form' => $form->createView(),
            ));
        }
    }

}
