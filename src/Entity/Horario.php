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
     * @var int
     *
     * @ORM\Column(name="horario_inicio", type="integer", nullable=false)
     */
    private $horarioInicio;

    /**
     * @var int
     *
     * @ORM\Column(name="hora_fin", type="integer", nullable=false)
     */
    private $horaFin;

    /**
     * @var int|null
     *
     * @ORM\Column(name="cupos", type="integer", nullable=true)
     */
    private $cupos;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHorarioInicio(): ?int
    {
        return $this->horarioInicio;
    }

    public function setHorarioInicio(int $horarioInicio): self
    {
        $this->horarioInicio = $horarioInicio;

        return $this;
    }

    public function getHoraFin(): ?int
    {
        return $this->horaFin;
    }

    public function setHoraFin(int $horaFin): self
    {
        $this->horaFin = $horaFin;

        return $this;
    }

    public function getCupos(): ?int
    {
        return $this->cupos;
    }

    public function setCupos(?int $cupos): self
    {
        $this->cupos = $cupos;

        return $this;
    }


}
