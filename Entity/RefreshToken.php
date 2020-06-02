<?php

namespace OAuth2\ServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="oauth_refresh_token")
 * @ORM\Entity()
 */
class RefreshToken
{
    /**
     * @ORM\Column(name="token", type="string", length=40)
     * @ORM\Id
     */
    private ?string $token = null;

    /**
     * @ORM\Column(name="user_id", type="string", length=100, nullable=true)
     */
    private ?string $user_id = null;

    /**
     * @ORM\Column(name="expires", type="datetime")
     */
    private \DateTimeInterface $expires;

    /**
     * @ORM\Column(name="scope", type="string", length=255, nullable=true)
     */
    private ?string $scope = null;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="client_id", onDelete="CASCADE")
     */
    private ?Client $client = null;

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
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

    public function setScope(?string $scope = null): self
    {
        $this->scope = $scope;

        return $this;
    }

    public function getScope(): ?string
    {
        return $this->scope;
    }

    public function setClient(?Client $client = null): self
    {
        $this->client = $client;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }
}
