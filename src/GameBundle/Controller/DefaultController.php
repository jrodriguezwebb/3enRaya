<?php

namespace GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GameBundle\Entity\Data;
use \Doctrine\ORM\ORMException;

class DefaultController extends Controller
{
    //[[1,0,1],[0,1,1],[1,0,1]]
    private $tablero = [];
    private $cantidadMovimientos = 0;
    
    public function indexAction()
    {
        //declaraciones
        $em = $this->getDoctrine()->getManager();

        //buscar data si existe y asignarla a la variable local de tablero
        $Data = $this->buscaTableroGuardado($em);
        if(!empty($Data) && count($Data)>0){
            $this->tablero = json_decode($Data->getTablero());  
        }

        var_dump($this->tablero);

        //funcion para comprobar ganador
        $ganador = $this->compruebaGanador();
        if(!is_null($ganador) && $ganador>=0){
            var_dump("asd");
            //hay un ganador
        }else if($this->cantidadMovimientos>=9){
            $ganador = "Empate";
        }

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
                $this->cantidadMovimientos = $Data->getCantidadmovimientos()+1;
                $this->tablero[$posicionArray[0]][$posicionArray[1]] = (int)$jugador; 
                $Data->setTablero(json_encode($this->tablero));
                $Data->setCantidadmovimiento($this->cantidadMovimientos);
                $em->persist($Data); 
                var_dump($Data);          
            }
            else
            {
                //si no hay tablero activo
                $this->tablero[$posicionArray[0]][$posicionArray[1]] = $jugador;
                $Data = new Data();
                $Data->setTablero(json_encode($this->tablero));
                $Data->setCantidadmovimiento(0);
                $Data->setActivo(1);
                $em->persist($Data);
                var_dump($Data);
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

    private function compruebaGanador(){
        $tablero = $this->tablero;
        
        //linea horizontal superior          
        if($tablero[0][0]==$tablero[0][1] && $tablero[0][1]==$tablero[0][2])
            return $tablero[0][0];
        
        //linea horizontal media      
        if($tablero[1][0]==$tablero[1][1] && $tablero[1][1]==$tablero[1][2])
            return $tablero[1][0];
          
        if($tablero[2][0]==$tablero[2][1] && $tablero[2][1]==$tablero[2][2])
            return $tablero[2][0];

        //linea vertical izq        
        if($tablero[0][0]==$tablero[1][0] && $tablero[1][0]==$tablero[2][0])
            return $tablero[0][0];

        //linea vertical media        
        if($tablero[0][1]==$tablero[1][1] && $tablero[1][1]==$tablero[2][1])
            return $tablero[0][1];

        //linea vertical der        
        if($tablero[0][2]==$tablero[1][2] && $tablero[1][2]==$tablero[2][2])
            return $tablero[0][2];
        
        //linea diagonal 1        
        if($tablero[0][0]==$tablero[1][1] && $tablero[1][1]==$tablero[2][2])
            return $tablero[0][0];

        //linea diagonal 2        
        if($tablero[0][2]==$tablero[1][1] && $tablero[1][1]==$tablero[2][0])
            return $tablero[0][2];        
        
        return -1;
    }
}
