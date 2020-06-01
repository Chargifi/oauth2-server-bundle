<?php

namespace OAuth2\ServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="oauth_client")
 * @ORM\Entity()
 */
class Client
{
    /**
     * @ORM\Column(name="client_id", type="string", length=50)
     * @ORM\Id
     */
    private ?string $client_id = null;

    /**
     * @ORM\Column(name="client_secret", type="string", length=40, nullable=true)
     */
    private ?string $client_secret = null;

    /**
     * @ORM\Column(name="redirect_uri", type="simple_array")
     */
    private array $redirect_uri = [];

    /**
     * @ORM\Column(name="grant_types", type="simple_array", nullable=true)
     */
    private ?array $grant_types = null;

    /**
     * @ORM\Column(name="scopes", type="simple_array", nullable=true)
     */
    private ?array $scopes = null;

    public function setClientId(?string $clientId): self
    {
        $this->client_id = $clientId;

        return $this;
    }

    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    public function setClientSecret(?string $clientSecret): self
    {
        $this->client_secret = $clientSecret;

        return $this;
    }

    public function getClientSecret(): ?string
    {
        return $this->client_secret;
    }

    public function setRedirectUri(array $redirectUri): self
    {
        $this->redirect_uri = $redirectUri;

        return $this;
    }

    public function getRedirectUri(): array
    {
        return $this->redirect_uri;
    }

    public function setGrantTypes(?array $grantTypes = null): self
    {
        $this->grant_types = $grantTypes;

        return $this;
    }

    public function getGrantTypes(): ?array
    {
        return $this->grant_types;
    }

    public function setScopes(?array $scopes = null): self
    {
        $this->scopes = $scopes;

        return $this;
    }

    public function getScopes(): ?array
    {
        return $this->scopes;
    }
}
