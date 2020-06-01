<?php

namespace OAuth2\ServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="oauth_authorization_code")
 * @ORM\Entity()
 */
class AuthorizationCode
{
    /**
     * @ORM\Column(name="code", type="string", length=40)
     * @ORM\Id
     */
    private ?string $code = null;

    /**
     * @ORM\Column(name="expires", type="datetime")
     */
    private \DateTimeInterface $expires;

    /**
     * @ORM\Column(name="user_id", type="string", length=100, nullable=true)
     */
    private ?string $user_id = null;

    /**
     * @ORM\Column(name="redirect_uris", type="simple_array", nullable=true)
     */
    private array $redirect_uri = [];

    /**
     * @ORM\Column(name="scope", type="string", length=255, nullable=true)
     */
    private ?string $scope = null;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="client_id", onDelete="CASCADE", onUpdate="CASCADE")
     */
    private ?Client $client;

    /**
     * @ORM\Column(name="id_token", type="string", length=2000, nullable=true)
     */
    private ?string $id_token;

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setExpires($expires): self
    {
        if (!$expires instanceof \DateTimeInterface) {
            // @see https://github.com/bshaffer/oauth2-server-bundle/issues/24
            $dateTime = new \DateTime();
            $dateTime->setTimestamp($expires);
            $expires = $dateTime;
        }

        $this->expires = $expires;

        return $this;
    }

    public function getExpires(): \DateTimeInterface
    {
        return $this->expires;
    }

    public function setUserId(?string $userId): self
    {
        $this->user_id = $userId;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->user_id;
    }

    public function setRedirectUri(string $redirectUri): self
    {
        $this->redirect_uri = explode(' ', $redirectUri);

        return $this;
    }

    public function getRedirectUri(): array
    {
        return $this->redirect_uri;
    }

    public function setScope(?string $scope): self
    {
        $this->scope = $scope;

        return $this;
    }

    public function getScope(): ?string
    {
        return $this->scope;
    }

    public function setClient(?\OAuth2\ServerBundle\Entity\Client $client = null): self
    {
        $this->client = $client;

        return $this;
    }

    public function getClient(): ?\OAuth2\ServerBundle\Entity\Client
    {
        return $this->client;
    }

    public function getIdToken(): ?string
    {
        return $this->id_token;
    }

    public function setIdToken(?string $idToken): self
    {
        $this->id_token = $idToken;

        return $this;
    }
}
