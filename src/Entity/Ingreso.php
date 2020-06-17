<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingreso
 *
 * @ORM\Table(name="ingresos", indexes={@ORM\Index(name="paciente_id", columns={"paciente_id"}), @ORM\Index(name="habitacion_id", columns={"habitacion_id"})})
 * @ORM\Entity
 */
class Ingreso
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_ingreso", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $fechaIngreso = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_salida", type="datetime", nullable=true)
     */
    private $fechaSalida;

    /**
     * @var \Habitacion
     *
     * @ORM\ManyToOne(targetEntity="Habitacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="habitacion_id", referencedColumnName="id")
     * })
     */
    private $habitacion;

    /**
     * @var \Paciente
     *
     * @ORM\ManyToOne(targetEntity="Paciente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="paciente_id", referencedColumnName="id")
     * })
     */
    private $paciente;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaIngreso(): ?\DateTimeInterface
    {
        return $this->fechaIngreso;
    }

    public function setFechaIngreso(?\DateTimeInterface $fechaIngreso): self
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    public function getFechaSalida(): ?\DateTimeInterface
    {
        return $this->fechaSalida;
    }

    public function setFechaSalida(?\DateTimeInterface $fechaSalida): self
    {
        $this->fechaSalida = $fechaSalida;

        return $this;
    }

    public function getHabitacion(): ?Habitacion
    {
        return $this->habitacion;
    }

    public function setHabitacion(?Habitacion $habitacion): self
    {
        $this->habitacion = $habitacion;

        return $this;
    }

    public function getPaciente(): ?Paciente
    {
        return $this->paciente;
    }

    public function setPaciente(?Paciente $paciente): self
    {
        $this->paciente = $paciente;

        return $this;
    }


}
