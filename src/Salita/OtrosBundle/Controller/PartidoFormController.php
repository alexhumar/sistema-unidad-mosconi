<?php
namespace Salita\OtrosBundle\Controller;
use Salita\OtrosBundle\Form\Type\PartidoType;
use Salita\OtrosBundle\Entity\Partido;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PartidoFormController extends Controller
{

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $partido = new Partido();
        $form = $this->createForm(new PartidoType(), $partido);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);      
            if ($form->isValid())
            {        
                $em->persist($partido);
                $em->flush();
                return $this->render('SalitaOtrosBundle:PartidoForm:mensaje.html.twig', array('mensaje' => 'El partido se cargo exitosamente en el sistema',
            ));
            }
            else 
            {
                return $this->render('SalitaOtrosBundle:PartidoForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar cargar un partido en el sistema',
            ));
            }
            
        }
        else
        {
            return $this->render('SalitaOtrosBundle:PartidoForm:new.html.twig', array('form' => $form->createView(),
            ));
        }
    }
    
    
    function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repoPartidos = $em->getRepository('SalitaOtrosBundle:Partido');
        $partidos = $repoPartidos->encontrarTodosOrdenadosPorNombre();
        return $this->render('SalitaOtrosBundle:PartidoForm:listado.html.twig', array('partidos' => $partidos,
            ));
    }
    

    public function modifAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repoPartidos = $em->getRepository('SalitaOtrosBundle:Partido');
        $partido = $repoPartidos->find($id);
        $form = $this->createForm(new PartidoType(), $partido);
        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);          
            if ($form->isValid())
            {
                $em->persist($partido);
                $em->flush();
                return $this->render('SalitaOtrosBundle:PartidoForm:mensaje.html.twig', array('mensaje' => 'El partido fue modificado exitosamente',
            ));
            }
            else 
            {
                return $this->render('SalitaOtrosBundle:PartidoForm:mensaje.html.twig', array('mensaje' => 'Se produjo un error al intentar modificar el partido seleccionado',
            ));
            }
            
        }
        else
        {
            return $this->render('SalitaOtrosBundle:PartidoForm:modif.html.twig', array('form' => $form->createView(),'id' => $id,
            ));
        }
    }
}
