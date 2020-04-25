<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cita
 *
 * @ORM\Table(name="citas", indexes={@ORM\Index(name="medico_id", columns={"medico_id"}), @ORM\Index(name="paciente_id", columns={"paciente_id"})})
 * @ORM\Entity
 */
class Cita
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
     * @var bool|null
     *
     * @ORM\Column(name="urgencia", type="boolean", nullable=true, options={"default"="b'0'"})
     */
    private $urgencia = 'b\'0\'';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_programada", type="datetime", nullable=false)
     */
    private $fechaProgramada;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_registro", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $fechaRegistro = 'CURRENT_TIMESTAMP';

    /**
     * @var int|null
     *
     * @ORM\Column(name="numero_orden", type="integer", nullable=true)
     */
    private $numeroOrden;

    /**
     * @var \Medico
     *
     * @ORM\ManyToOne(targetEntity="Medico")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="medico_id", referencedColumnName="id")
     * })
     */
    private $medico;

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

    public function getUrgencia(): ?bool
    {
        return $this->urgencia;
    }

    public function setUrgencia(?bool $urgencia): self
    {
        $this->urgencia = $urgencia;

        return $this;
    }

    public function getFechaProgramada(): ?\DateTimeInterface
    {
        return $this->fechaProgramada;
    }

    public function setFechaProgramada(\DateTimeInterface $fechaProgramada): self
    {
        $this->fechaProgramada = $fechaProgramada;

        return $this;
    }

    public function getFechaRegistro(): ?\DateTimeInterface
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro(?\DateTimeInterface $fechaRegistro): self
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    public function getNumeroOrden(): ?int
    {
        return $this->numeroOrden;
    }

    public function setNumeroOrden(?int $numeroOrden): self
    {
        $this->numeroOrden = $numeroOrden;

        return $this;
    }

    public function getMedico(): ?Medico
    {
        return $this->medico;
    }

    public function setMedico(?Medico $medico): self
    {
        $this->medico = $medico;

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
