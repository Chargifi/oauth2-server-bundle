<?php

namespace OAuth2\ServerBundle\Manager;

use Doctrine\ORM\EntityManager;
use OAuth2\ServerBundle\Entity\Client;
use OAuth2\ServerBundle\Exception\ScopeNotFoundException;

class ClientManager
{
    private EntityManager $em;
    private ScopeManagerInterface $sm;

    public function __construct(EntityManager $entityManager, ScopeManagerInterface $scopeManager)
    {
        $this->em = $entityManager;
        $this->sm = $scopeManager;
    }

    /**
     * Creates a new client
     */
    public function createClient(string $identifier, array $redirect_uris = [], array $grant_types = [],
                                 array $scopes = []): Client
    {
        $client = new Client();
        $client->setClientId($identifier);
        $client->setClientSecret($this->generateSecret());
        $client->setRedirectUri($redirect_uris);
        $client->setGrantTypes($grant_types);

        // Verify scopes
        foreach ($scopes as $scope) {
            // Get Scope
            $scopeObject = $this->sm->findScopeByScope($scope);
            if (!$scopeObject) {
                throw new ScopeNotFoundException();
            }
        }

        $client->setScopes($scopes);

        // Store Client
        $this->em->persist($client);
        $this->em->flush();

        return $client;
    }

    /**
     * Creates a secret for a client
     */
    protected function generateSecret(): string
    {
        return base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }
}
