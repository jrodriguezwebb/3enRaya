<?php

namespace GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GameBundle\Entity\Data;
use \Doctrine\ORM\ORMException;

class DefaultController extends Controller
{    
    private $tablero = [[0,0,0],[0,0,0],[0,0,0]];
    private $cantidadMovimientos = 0;
    private $ultimoEnJugar = 1;

    public function indexAction(){
        //declaraciones
        $em = $this->getDoctrine()->getManager();

        //buscar data si existe y asignarla a la variable local de tablero
        $Data = $this->buscaTableroGuardado($em)[0];
        if(!empty($Data) && count($Data)>0){
            $this->tablero = json_decode($Data->getTablero()); 
            $this->ultimoEnJugar =  $Data->getUltimoenjugar();
            $this->cantidadMovimientos = $Data->getCantidadmovimientos();
        }

        //pinta tablero
        return $this->render('GameBundle:Default:index.html.twig', array(
            'tablero'=>$this->tablero,
            'ganador'=>$this->compruebaGanador(),
            'ultimo_en_jugar'=>$this->ultimoEnJugar,
            'cantidad_movimientos'=>$this->cantidadMovimientos
        ));
    }

    public function recibeJugadaAction( $jugador = null, $posicion = null){

        try{
            $posicionArray = explode("-",$posicion);
            //entity manager y entidad
            $em = $this->getDoctrine()->getManager();
            $Data = $this->buscaTableroGuardado($em)[0];

            //si hay algun tablero guardado
            if(!empty($Data) && count($Data)>0){
                $this->tablero = json_decode($Data->getTablero());
                $this->cantidadMovimientos = $Data->getCantidadmovimientos()+1;
                $this->tablero[$posicionArray[0]][$posicionArray[1]] = (int)$jugador;
                $this->ultimoEnJugar = (int)$jugador;
                if($this->ultimoEnJugar == 1){
                    $this->ultimoEnJugar++;                   
                }elseif ($this->ultimoEnJugar == 2){
                    $this->ultimoEnJugar--;
                } 
                $Data->setTablero(json_encode($this->tablero));
                $Data->setCantidadmovimientos($this->cantidadMovimientos);                
                $Data->setUltimoenjugar($this->ultimoEnJugar);
                $em->persist($Data); 
                //var_dump($Data);          
            }
            else
            {
                //si no hay tablero activo
                $this->tablero[$posicionArray[0]][$posicionArray[1]] = (int)$jugador;
                $Data = new Data();
                var_dump(array_values($this->tablero));
                $Data->setTablero(json_encode(array_values($this->tablero)));
                $Data->setCantidadmovimientos(1);
                $Data->setUltimoenjugar(2);
                $Data->setActivo(1);
                $em->persist($Data);
                //var_dump($Data);
            }
            $em->flush();            
        }catch(ORMException $e){
            var_dump( $e->getMessage());
        }     
        //die();   
        return $this->redirectToRoute('game_homepage');
    }

    public function reiniciarJuegoAction(){

        $em = $this->getDoctrine()->getManager();
        $juegos = $this->buscaTableroGuardado($em);
        var_dump($juegos);
        foreach($juegos as $juego){
            $juego->setActivo(0);
            $em->persist($juego);
            $em->flush(); 
        }
        //die();
        return $this->redirectToRoute('game_homepage');
    }

    private function buscaTableroGuardado($em){
        $entidadData = $em->getRepository("GameBundle:Data");
        
        //busco la partida que este activa guardada en bd
        return $entidadData->findBy(
            array(
                "activo" => true
            )
        ) ? $entidadData->findBy(array("activo" => true)) : []; 
    }

    private function compruebaGanador(){
        $tablero = $this->tablero;
        
        //linea horizontal superior          
        if($tablero[0][0]!=0 && $tablero[0][0]==$tablero[0][1] && $tablero[0][1]==$tablero[0][2])
            return $tablero[0][0];
        
        //linea horizontal media      
        if($tablero[1][0]!=0 && $tablero[1][0]==$tablero[1][1] && $tablero[1][1]==$tablero[1][2])
            return $tablero[1][0];
          
        if($tablero[2][0]!=0 && $tablero[2][0]==$tablero[2][1] && $tablero[2][1]==$tablero[2][2])
            return $tablero[2][0];

        //linea vertical izq        
        if($tablero[0][0]!=0 && $tablero[0][0]==$tablero[1][0] && $tablero[1][0]==$tablero[2][0])
            return $tablero[0][0];

        //linea vertical media        
        if($tablero[0][1]!=0 && $tablero[0][1]==$tablero[1][1] && $tablero[1][1]==$tablero[2][1])
            return $tablero[0][1];

        //linea vertical der        
        if($tablero[0][2]!=0 && $tablero[0][2]==$tablero[1][2] && $tablero[1][2]==$tablero[2][2])
            return $tablero[0][2];
        
        //linea diagonal 1        
        if($tablero[0][0]!=0 && $tablero[0][0]==$tablero[1][1] && $tablero[1][1]==$tablero[2][2])
            return $tablero[0][0];

        //linea diagonal 2        
        if($tablero[0][2]!=0 && $tablero[0][2]==$tablero[1][1] && $tablero[1][1]==$tablero[2][0])
            return $tablero[0][2];        
        
        return -1;
    }
}
