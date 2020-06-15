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
     * @var string|null
     *
     * @ORM\Column(name="urgencia", type="string",  length=10000, nullable=true)
     */
    private $urgencia = 'b\'0\'';

    /**
     * @var string|null
     *
     * @ORM\Column(name="fecha_programada",type="string", length=100, nullable=false)
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
     * @ORM\Column(name="hora_cita", type="integer", nullable=true)
     */
    private $horaCita;

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

    public function getUrgencia(): ?string
    {
        return $this->urgencia;
    }

    public function setUrgencia(string $urgencia): self
    {
        $this->urgencia = $urgencia;

        return $this;
    }

    public function getFechaProgramada(): ?string
    {
        return $this->fechaProgramada;
    }

    public function setFechaProgramada(string $fechaProgramada): self
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

    public function getHoraCita(): ?int
    {
        return $this->horaCita;
    }

    public function setHoraCita(?int $horaCita): self
    {
        $this->horaCita = $horaCita;

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
