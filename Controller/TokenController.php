<?php

namespace OAuth2\ServerBundle\Controller;

use OAuth2\GrantType\AuthorizationCode;
use OAuth2\GrantType\ClientCredentials;
use OAuth2\GrantType\RefreshToken;
use OAuth2\GrantType\UserCredentials;
use OAuth2\Request;
use OAuth2\Response;
use OAuth2\Server;
use OAuth2\ServerBundle\Event\OauthTokenResponseErrorEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Routing\Annotation\Route;

class TokenController
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
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @var ClientCredentials
     */
    private $clientCredentials;

    /**
     * @var AuthorizationCode
     */
    private $authorizationCode;

    /**
     * @var RefreshToken
     */
    private $refreshToken;

    /**
     * @var UserCredentials
     */
    private $userCredentials;

    public function __construct($server, $request, $response, $eventDispatcher, $clientCredentials, $authorizationCode,
                                $refreshToken, $userCredentials)
    {
        $this->server = $server;
        $this->request = $request;
        $this->response = $response;
        $this->eventDispatcher = $eventDispatcher;
        $this->clientCredentials = $clientCredentials;
        $this->authorizationCode = $authorizationCode;
        $this->refreshToken = $refreshToken;
        $this->userCredentials = $userCredentials;
    }

    /**
     * This is called by the client app once the client has obtained
     * an authorization code from the Authorize Controller (@see \OAuth2\ServerBundle\Controller\AuthorizeController).
     * returns a JSON-encoded Access Token or a JSON object with
     * "error" and "error_description" properties.
     *
     * @Route("/token", name="_token")
     */
    public function tokenAction()
    {
        // Add Grant Types
        $this->server->addGrantType($this->clientCredentials);
        $this->server->addGrantType($this->authorizationCode);
        $this->server->addGrantType($this->refreshToken);
        $this->server->addGrantType($this->userCredentials);

        $newResponse = $this->server->handleTokenRequest($this->request, $this->response);

        if ($newResponse->getStatusCode() < 200 || $newResponse->getStatusCode() >= 300) {
            $requestParameters = $this->request->request->all();

            if (isset($requestParameters['password'])) {
                unset($requestParameters['password']);
            }

            $oauthTokenRequestErrorEvent = new OauthTokenResponseErrorEvent($newResponse->getStatusCode(),
                $newResponse->getParameter('error'), $newResponse->getParameter('error_description'),
                $requestParameters);
            $eventDispatcher->dispatch($oauthTokenRequestErrorEvent, OauthTokenResponseErrorEvent::NAME);
        }

        return $newResponse;
    }
}
