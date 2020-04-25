<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Intervencion
 *
 * @ORM\Table(name="intervenciones", indexes={@ORM\Index(name="medico_id", columns={"medico_id"}), @ORM\Index(name="quirofano_id", columns={"quirofano_id"}), @ORM\Index(name="paciente_id", columns={"paciente_id"})})
 * @ORM\Entity
 */
class Intervencion
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_programada", type="datetime", nullable=false)
     */
    private $fechaProgramada;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="duracion_estimada", type="time", nullable=true)
     */
    private $duracionEstimada;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="duracion_real", type="time", nullable=true)
     */
    private $duracionReal;

    /**
     * @var \Quirofano
     *
     * @ORM\ManyToOne(targetEntity="Quirofano")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="quirofano_id", referencedColumnName="id")
     * })
     */
    private $quirofano;

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

    public function getFechaProgramada(): ?\DateTimeInterface
    {
        return $this->fechaProgramada;
    }

    public function setFechaProgramada(\DateTimeInterface $fechaProgramada): self
    {
        $this->fechaProgramada = $fechaProgramada;

        return $this;
    }

    public function getDuracionEstimada(): ?\DateTimeInterface
    {
        return $this->duracionEstimada;
    }

    public function setDuracionEstimada(?\DateTimeInterface $duracionEstimada): self
    {
        $this->duracionEstimada = $duracionEstimada;

        return $this;
    }

    public function getDuracionReal(): ?\DateTimeInterface
    {
        return $this->duracionReal;
    }

    public function setDuracionReal(?\DateTimeInterface $duracionReal): self
    {
        $this->duracionReal = $duracionReal;

        return $this;
    }

    public function getQuirofano(): ?Quirofano
    {
        return $this->quirofano;
    }

    public function setQuirofano(?Quirofano $quirofano): self
    {
        $this->quirofano = $quirofano;

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
