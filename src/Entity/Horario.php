<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Horario
 *
 * @ORM\Table(name="horarios")
 * @ORM\Entity
 */
class Horario
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
     * @ORM\Column(name="horario_inicio", type="time", nullable=false)
     */
    private $horarioInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora_fin", type="time", nullable=false)
     */
    private $horaFin;

    /**
     * @var int
     *
     * @ORM\Column(name="cupos", type="integer", nullable=false)
     */
    private $cupos;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHorarioInicio(): ?\DateTimeInterface
    {
        return $this->horarioInicio;
    }

    public function setHorarioInicio(\DateTimeInterface $horarioInicio): self
    {
        $this->horarioInicio = $horarioInicio;

        return $this;
    }

    public function getHoraFin(): ?\DateTimeInterface
    {
        return $this->horaFin;
    }

    public function setHoraFin(\DateTimeInterface $horaFin): self
    {
        $this->horaFin = $horaFin;

        return $this;
    }

    public function getCupos(): ?int
    {
        return $this->cupos;
    }

    public function setCupos(int $cupos): self
    {
        $this->cupos = $cupos;

        return $this;
    }


}
