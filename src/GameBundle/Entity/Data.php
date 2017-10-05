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
}
