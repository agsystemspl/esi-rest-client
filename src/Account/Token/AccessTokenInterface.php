<?php

namespace AGSystems\Esi\REST\Account\Token;

interface AccessTokenInterface extends \League\OAuth2\Client\Token\AccessTokenInterface
{
    public function saveAuth(\League\OAuth2\Client\Token\AccessTokenInterface $accessToken);
}
