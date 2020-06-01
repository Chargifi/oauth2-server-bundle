<?php

namespace OAuth2\ServerBundle\Controller;

use OAuth2\ServerBundle\Event\OauthTokenResponseErrorEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TokenController extends AbstractController
{
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
        $server = $this->get('oauth2.server');

        // Add Grant Types
        $server->addGrantType($this->get('oauth2.grant_type.client_credentials'));
        $server->addGrantType($this->get('oauth2.grant_type.authorization_code'));
        $server->addGrantType($this->get('oauth2.grant_type.refresh_token'));
        $server->addGrantType($this->get('oauth2.grant_type.user_credentials'));

        /** @var \OAuth2\HttpFoundationBridge\Response $response */
        $response = $server->handleTokenRequest($this->get('oauth2.request'), $this->get('oauth2.response'));

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            $requestParameters = $this->get('oauth2.request')->request->all();

            if (isset($requestParameters['password'])) {
                unset($requestParameters['password']);
            }

            $oauthTokenRequestErrorEvent = new OauthTokenResponseErrorEvent($response->getStatusCode(), $response->getParameter('error'),
                $response->getParameter('error_description'), $requestParameters);
            $this->get('event_dispatcher')->dispatch(OauthTokenResponseErrorEvent::NAME, $oauthTokenRequestErrorEvent);
        }

        return $response;
    }
}
