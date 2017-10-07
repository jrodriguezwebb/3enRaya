<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Data
 *
 * @ORM\Table(name="data")
 * @ORM\Entity
 */
class Data
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tablero", type="string", length=255, nullable=false)
     */
    private $tablero;

    /**
     * @var integer
     *
     * @ORM\Column(name="activo", type="smallint", nullable=false)
     */
    private $activo;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad_movimientos", type="integer", nullable=false)
     */
    private $cantidadmovimientos;

    /**
     * @var integer
     *
     * @ORM\Column(name="ultimo_en_jugar", type="integer", nullable=false)
     */
    private $ultimo_en_jugar;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tablero
     *
     * @param string $tablero
     *
     * @return Data
     */
    public function setTablero($tablero)
    {
        $this->tablero = $tablero;

        return $this;
    }

    /**
     * Get tablero
     *
     * @return string
     */
    public function getTablero()
    {
        return $this->tablero;
    }

    /**
     * Set activo
     *
     * @param integer $activo
     *
     * @return Data
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return integer
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set cantidadmovimientos
     *
     * @param integer $cantidadmovimientos
     *
     * @return cantidadmovimientos
     */
    public function setCantidadmovimientos($cantidadmovimientos)
    {
        $this->cantidadmovimientos = $cantidadmovimientos;

        return $this;
    }
 
    /**
     * Get cantidadmovimientos
     *
     * @return integer
     */
    public function getCantidadmovimientos()
    {
        return $this->cantidadmovimientos;
    }

    /**
     * Set ultimo_en_jugar
     *
     * @param integer $ultimo_en_jugar
     *
     * @return ultimo_en_jugar
     */
    public function setUltimoenjugar($ultimo_en_jugar)
    {
        $this->ultimo_en_jugar = $ultimo_en_jugar;

        return $this;
    }
  
     /**
      * Get ultimo_en_jugar
      *
      * @return integer
      */
    public function getUltimoenjugar()
    {
        return $this->ultimo_en_jugar;
    }
}
