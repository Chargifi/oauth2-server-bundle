<?php

namespace OAuth2\ServerBundle\Controller;

use OAuth2\Request;
use OAuth2\Response;
use OAuth2\Server;
use OAuth2\ServerBundle\Storage\Scope;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class AuthorizeController
{
    /**
     * @var Server
     */
    private $server;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var Scope
     */
    private $scopeStorage;

    public function __construct($server, $request, $response, $environment, $scopeStorage)
    {
        $this->server = $server;
        $this->request = $request;
        $this->response = $response;
        $this->environment = $environment;
        $this->scopeStorage = $scopeStorage;
    }

    /**
     * @Route("/authorize", name="_authorize_validate", methods="GET")
     */
    public function validateAuthorizeAction()
    {
        if (!$this->server->validateAuthorizeRequest($this->request, $this->response)) {
            return $this->server->getResponse();
        }

        // Get descriptions for scopes if available
        $scopes = array();
        foreach (explode(' ', $this->request->query->get('scope')) as $scope) {
            $scopes[] = $this->scopeStorage->getDescriptionForScope($scope);
        }

        $qs = array_intersect_key(
            $this->request->query->all(),
            array_flip(explode(' ', 'response_type client_id redirect_uri scope state nonce'))
        );

        return $this->environment->render('OAuth2ServerBundle:Authorize:authorize.html.twig', [
            'qs' => $qs,
            'scopes' => $scopes,
        ]);
    }

    /**
     * @Route("/authorize", name="_authorize_handle", methods="POST")
     */
    public function handleAuthorizeAction(Server $server, Request $request, Response $response)
    {
        return $server->handleAuthorizeRequest($request, $response, true);
    }
}
