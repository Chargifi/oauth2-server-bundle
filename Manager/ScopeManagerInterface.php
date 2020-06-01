<?php

namespace OAuth2\ServerBundle\Manager;

use Doctrine\ORM\EntityManager;
use OAuth2\Storage\ScopeInterface;

interface ScopeManagerInterface
{
    public function __construct(EntityManager $entityManager);

    /**
     * Creates a new scope
     *
     * @return Scope
     */
    public function createScope(string $scope, string $description = '');

    /**
     * Find a single scope by the scope
     * @return Scope
     */
    public function findScopeByScope(string $scope);

    /**
     * Find all the scopes by an array of scopes
     *
     * @param array $scopes
     * @return mixed
     */
    public function findScopesByScopes(array $scopes);
}
