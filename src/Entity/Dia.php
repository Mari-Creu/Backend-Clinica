<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dia
 *
 * @ORM\Table(name="dias", indexes={@ORM\Index(name="medico_id", columns={"medico_id"}), @ORM\Index(name="horario_id", columns={"horario_id"})})
 * @ORM\Entity
 */
class Dia
{
    /**
     * @var string
     *
     * @ORM\Column(name="dia", type="string", length=1, nullable=false, options={"fixed"=true})
     * @ORM\Id

     */
    private $dia;

    /**
     * @var \Horario
     *
     * @ORM\ManyToOne(targetEntity="Horario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="horario_id", referencedColumnName="id")
     * })
     */
    private $horario;

    /**
     * @var \Medico
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Medico")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="medico_id", referencedColumnName="id")
     * })
     */
    private $medico;

    public function setDia(int $dia): self
    {
        $this->dia = $dia;

        return $this;
    }
    public function getDia(): ?string
    {
        return $this->dia;
    }

    public function getHorario(): ?Horario
    {
        return $this->horario;
    }

    public function setHorario(?Horario $horario): self
    {
        $this->horario = $horario;

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
