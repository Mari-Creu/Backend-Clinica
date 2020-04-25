<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Habitacion
 *
 * @ORM\Table(name="habitaciones", indexes={@ORM\Index(name="planta_id", columns={"planta_id"})})
 * @ORM\Entity
 */
class Habitacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numero", type="integer", nullable=true)
     */
    private $numero;

    /**
     * @var \Planta
     *
     * @ORM\ManyToOne(targetEntity="Planta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="planta_id", referencedColumnName="id")
     * })
     */
    private $planta;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(?int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getPlanta(): ?Planta
    {
        return $this->planta;
    }

    public function setPlanta(?Planta $planta): self
    {
        $this->planta = $planta;

        return $this;
    }


}
