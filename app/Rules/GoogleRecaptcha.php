<?php

namespace App\Rules;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;

class GoogleRecaptcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->verify($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }

    // 驗證 funcation
    private function verify(string $token = null): bool
    {
        // 送 api 以進行驗證
        $url = 'https://www.google.com/recaptcha/api/siteverify';

        $response = (new Client())->request('POST', $url, [
            'form_params' => [
                'secret' => env('RECAPTCHA_SECRET_KEY',false),
                'response' => $token,
            ],
        ]);
        $code = $response->getStatusCode();
        $content = json_decode($response->getBody()->getContents());
        return $code == 200 && $content->success == true;
    }
}
