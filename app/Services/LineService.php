<?php

namespace App\Services;

use GuzzleHttp\Client;

class LineService
{
    public function getLoginBaseUrl($provider,$parameter = null)
    {
        // 組成 Line Login Url
        $url = config('line.authorize_base_url') . '?';
        $url .= 'response_type=code';
        $url .= '&client_id=' . config('line.channel_id');
        $url .= '&redirect_uri=' . config('app.url') . '/login/callback/'.$provider;
        $url .= '&state='.'parameter='.$parameter; // 暫時固定方便測試
        $url .= '&scope=profile%20openid%20email';

        return $url;
    }

    public function getLineToken($code)
    {
        $client = new Client();
        $response = $client->request('POST', config('line.get_token_url'), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => config('app.url') . '/login/callback/line',
                'client_id' => config('line.channel_id'),
                'client_secret' => config('line.secret')
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getUserProfile($response)
    {
        $client = new Client();
        $headers = [
            'Authorization' => 'Bearer ' . $response['access_token'],
            'Accept'        => 'application/json',
        ];
        $response = $client->request('POST', config('line.get_user_profile_url'), [
            'headers' => $headers,
            'form_params' => [
                'id_token'=> $response['id_token'],
                'client_id' => config('line.channel_id'),
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);

    }
}