<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Informe
 *
 * @ORM\Table(name="informes", indexes={@ORM\Index(name="medico_id", columns={"medico_id"}), @ORM\Index(name="paciente_id", columns={"paciente_id"})})
 * @ORM\Entity
 */
class Informe
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
     * @ORM\Column(name="evaluacion", type="string", length=500, nullable=true)
     */
    private $evaluacion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observaciones", type="string", length=500, nullable=true)
     */
    private $observaciones;

    /**
     * @var string|null
     *
     * @ORM\Column(name="diagnostico", type="string", length=500, nullable=true)
     */
    private $diagnostico;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tratamiento", type="string", length=500, nullable=true)
     */
    private $tratamiento;

    /**
     * @var \Paciente
     *
     * @ORM\ManyToOne(targetEntity="Paciente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="paciente_id", referencedColumnName="id")
     * })
     */
    private $paciente;

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
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_informe", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $fechaInforme = 'CURRENT_TIMESTAMP';

    public function getFechaInforme(): ?\DateTimeInterface
    {
        return $this->fechaInforme;
    }

    public function setFechaInforme(?\DateTimeInterface $fechaInforme): self
    {
        $this->fechaInforme = $fechaInforme;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvaluacion(): ?string
    {
        return $this->evaluacion;
    }

    public function setEvaluacion(?string $evaluacion): self
    {
        $this->evaluacion = $evaluacion;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getDiagnostico(): ?string
    {
        return $this->diagnostico;
    }

    public function setDiagnostico(?string $diagnostico): self
    {
        $this->diagnostico = $diagnostico;

        return $this;
    }

    public function getTratamiento(): ?string
    {
        return $this->tratamiento;
    }

    public function setTratamiento(?string $tratamiento): self
    {
        $this->tratamiento = $tratamiento;

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

    public function getMedico(): ?Medico
    {
        return $this->medico;
    }

    public function setMedico(?Medico $medico): self
    {
        $this->medico = $medico;

        return $this;
    }


}
