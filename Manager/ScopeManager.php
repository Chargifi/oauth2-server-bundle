<?php

namespace OAuth2\ServerBundle\Manager;

use Doctrine\ORM\EntityManager;
use OAuth2\ServerBundle\Entity\Scope;

class ScopeManager implements ScopeManagerInterface
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Creates a new scope
     *
     * @return Scope
     */
    public function createScope(string $scope, string $description = '')
    {
        if ($scopeObject = $this->findScopeByScope($scope)) {
          return $scopeObject;
        }

        $scopeObject = new Scope();
        $scopeObject->setScope($scope);
        $scopeObject->setDescription($description);

        // Store Scope
        $this->em->persist($scopeObject);
        $this->em->flush();

        return $scopeObject;
    }

    /**
     * Find a single scope by the scope
     *
     * @return Scope
     */
    public function findScopeByScope(string $scope)
    {
        $scopeObject = $this->em->getRepository(Scope::class)->find($scope);

        return $scopeObject;
    }

    /**
     * Find all the scopes by an array of scopes
     *
     * @param array $scopes
     * @return mixed|void
     */
    public function findScopesByScopes(array $scopes)
    {
        $scopeObjects = $this->em->getRepository(Scope::class)
            ->createQueryBuilder('a')
            ->where('a.scope in (?1)')
            ->setParameter(1, $scopes)
            ->getQuery()->getResult();

        return $scopeObjects;
    }
}
