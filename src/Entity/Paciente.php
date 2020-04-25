<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paciente
 *
 * @ORM\Table(name="pacientes")
 * @ORM\Entity
 */
class Paciente
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="seguridad_social", type="string", length=50, nullable=true)
     */
    private $seguridadSocial;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mutua", type="string", length=50, nullable=true)
     */
    private $mutua;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

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

    public function getSeguridadSocial(): ?string
    {
        return $this->seguridadSocial;
    }

    public function setSeguridadSocial(?string $seguridadSocial): self
    {
        $this->seguridadSocial = $seguridadSocial;

        return $this;
    }

    public function getMutua(): ?string
    {
        return $this->mutua;
    }

    public function setMutua(?string $mutua): self
    {
        $this->mutua = $mutua;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

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


}
