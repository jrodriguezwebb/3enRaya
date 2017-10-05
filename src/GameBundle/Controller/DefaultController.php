<?php

namespace GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GameBundle\Entity\Data;
use \Doctrine\ORM\ORMException;

class DefaultController extends Controller
{
    //[[1,0,1],[0,1,1],[1,0,1]]
    private $tablero = [];
    public function indexAction()
    {
        return $this->render('GameBundle:Default:index.html.twig');
    }

    public function recibeJugadaAction( $jugador = null, $posicion = null)
    {
        
        try{
            $em = $this->getDoctrine()->getManager();
            $data = new Data();
            $data->setTablero("asd");
            $data->setActivo(1);
            $em->persist($data);
            $em->flush();
        }catch(ORMException $e){
            var_dump( $e->getMessage());
        }
       
        /* var_dump($em);
        var_dump($data); */
        var_dump($posicion);
        var_dump($jugador);die();
        return $this->render('GameBundle:Default:index.html.twig');
    }
}
