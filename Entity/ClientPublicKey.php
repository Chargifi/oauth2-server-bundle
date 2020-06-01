<?php

namespace OAuth2\ServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="oauth_client_public_key")
 * @ORM\Entity()
 */
class ClientPublicKey
{
    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="client_id", onDelete="CASCADE", onUpdate="CASCADE")
     * @ORM\Id
     */
    private ?Client $client_id;

    /**
     * @ORM\Column(name="public_key", type="text")
     */
    private string $public_key;

    public function setClient(?Client $client = null): self
    {
        $this->client_id = $client;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client_id;
    }

    public function setPublicKey(string $public_key): self
    {
        $this->public_key = $public_key;

        return $this;
    }

    public function getPublicKey(): string
    {
        return $this->public_key;
    }
}
