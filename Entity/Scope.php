<?php

namespace OAuth2\ServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="oauth_scope")
 * @ORM\Entity()
 */
class Scope
{
    /**
     * @ORM\Column(name="scope", type="string", length=255)
     * @ORM\Id
     */
    private ?string $scope = null;

    /**
     * @ORM\Column(name="description", type="string", length=255)
     */
    private string $description;

    public function setScope(string $scope): self
    {
        $this->scope = $scope;

        return $this;
    }

    public function getScope(): ?string
    {
        return $this->scope;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
