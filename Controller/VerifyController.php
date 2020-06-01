<?php

namespace OAuth2\ServerBundle\Controller;

use OAuth2\Request;
use OAuth2\Response;
use OAuth2\Server;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class VerifyController
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

    public function __construct($server, $request, $response)
    {
        $this->server = $server;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * This is called with an access token, details
     * about the access token are then returned.
     * Used for verification purposes.
     *
     * @Route("/verify", name="_verify_token")
     */
    public function verifyAction()
    {
        if (!$this->server->verifyResourceRequest($this->request, $this->response)) {
            return $this->server->getResponse();
        }

        $tokenData = $this->server->getAccessTokenData($this->request, $this->response);

        return new JsonResponse($tokenData);
    }
}
