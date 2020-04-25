<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Medico
 *
 * @ORM\Table(name="medicos", indexes={@ORM\Index(name="especialidad_id", columns={"especialidad_id"})})
 * @ORM\Entity
 */
class Medico
{
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_contratacion", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $fechaContratacion = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_fin_contrato", type="datetime", nullable=true)
     */
    private $fechaFinContrato;

    /**
     * @var \Usuario
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    /**
     * @var \Especialidad
     *
     * @ORM\ManyToOne(targetEntity="Especialidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="especialidad_id", referencedColumnName="id")
     * })
     */
    private $especialidad;

    public function getFechaContratacion(): ?\DateTimeInterface
    {
        return $this->fechaContratacion;
    }

    public function setFechaContratacion(?\DateTimeInterface $fechaContratacion): self
    {
        $this->fechaContratacion = $fechaContratacion;

        return $this;
    }

    public function getFechaFinContrato(): ?\DateTimeInterface
    {
        return $this->fechaFinContrato;
    }

    public function setFechaFinContrato(?\DateTimeInterface $fechaFinContrato): self
    {
        $this->fechaFinContrato = $fechaFinContrato;

        return $this;
    }

    public function getId(): ?Usuario
    {
        return $this->id;
    }

    public function setId(?Usuario $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getEspecialidad(): ?Especialidad
    {
        return $this->especialidad;
    }

    public function setEspecialidad(?Especialidad $especialidad): self
    {
        $this->especialidad = $especialidad;

        return $this;
    }


}
