<?php

namespace AGSystems\Esi\REST;

use GuzzleHttp\Psr7\Response;
use League\OAuth2\Client\Provider\AbstractProvider;
use AGSystems\OAuth2\Client\Token\AccessTokenInterface;

class Client extends \AGSystems\REST\AbstractClient
{
    /**
     * @var AccessTokenInterface
     */
    protected $accessToken;

    /**
     * @var AbstractProvider
     */
    protected $provider;

    public function __construct(
        AccessTokenInterface $accessToken,
        AbstractProvider $provider
    )
    {
        $this->accessToken = $accessToken;
        $this->provider = $provider;
    }

    protected function withOptions(): array
    {
        if ($this->accessToken->hasExpired()) {
            $accessToken = $this->provider->getAccessToken('refresh_token', [
                'refresh_token' => $this->accessToken->getRefreshToken()
            ]);

            $accessToken->saveAuth($accessToken);
        }

        return [
            'base_uri' => 'https://esi.evetech.net/latest/',
            'headers' => [
                'authorization' => 'Bearer ' . $this->accessToken->getToken(),
            ],
            'query' => [
                'datasource' => 'tranquility',
            ],
        ];
    }
}
