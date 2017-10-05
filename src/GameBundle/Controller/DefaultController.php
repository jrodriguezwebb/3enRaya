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
        //declaraciones
        $em = $this->getDoctrine()->getManager();

        //buscar data si existe y asignarla a la variable local de tablero
        $Data = $this->buscaTableroGuardado($em);
        if(!empty($Data) && count($Data)>0){
            $this->tablero = json_decode($Data->getTablero());  
        }

        //TODO: funcion para comprobar ganador

        //TODO: pintar tablero
        return $this->render('GameBundle:Default:index.html.twig');
    }

    public function recibeJugadaAction( $jugador = null, $posicion = null)
    {        
        try{
            $posicionArray = explode("-",$posicion);
            //entity manager y entidad
            $em = $this->getDoctrine()->getManager();
            $Data = $this->buscaTableroGuardado($em);

            //si hay algun tablero guardado
            if(!empty($Data) && count($Data)>0){
                $this->tablero = json_decode($Data->getTablero());  
                $this->tablero[$posicionArray[0]][$posicionArray[1]] = $jugador; 
                $Data->setTablero(json_encode($this->tablero));
                $em->persist($Data); 
                var_dump($Data);          
            }
            else
            {
                //si no hay tablero activo
                $this->tablero[$posicionArray[0]][$posicionArray[1]] = $jugador;
                $data = new Data();
                $data->setTablero(json_encode($this->tablero));
                $data->setActivo(1);
                $em->persist($data);
                var_dump($data);
            }
            $em->flush();            
        }catch(ORMException $e){
            var_dump( $e->getMessage());
        }
        
        die();
        //TODO: redirect to index
        return $this->render('GameBundle:Default:index.html.twig');
    }

    private function buscaTableroGuardado($em){
        $entidadData = $em->getRepository("GameBundle:Data");
        
        //busco la partida que este activa guardada en bd
        return $entidadData->findBy(
            array(
                "activo" => true
            )
        )[0]; 
    }
}
