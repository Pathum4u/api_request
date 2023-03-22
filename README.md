API Request for Multiple source With GuzzleHttp
========================================

Simple Laravel\Lumen Micro service api request package(service to service).


Installation 
------------

```
composer require pathum4u/api_request
```


Insert in app.php

```
$app->register(Pathum4u\ApiRequest\ApiRequestServiceProvider::class);
```

publish config

```
php artisan vendor:publish
```

or 

config -> services.php

```
<?php

return [
    'user' => [
        'base_uri' => env('USER_SERVICE_URI'),
        'secret' => env('USER_SERVICE_SECRET')
    ],

    'notification' => [
        'base_uri' => env('NOTIFICATION_SERVICE_URI'),
        'secret' => env('NOTIFICATION_SERVICE_SECRET')
    ],
];
```
Then

Limen -> app.php

```
$app->configure('services');
```

Request
-------


```
use Pathum4u\ApiRequest\ApiRequest;

$client = new ApiRequest();
$client->service('notification')->post('/test', $request->all());
```

```
$client = new ApiRequest();
$client->service('notification')
->dd()
->adForm()
->post(['email'=> 'tese@tes.com']); // $request->all()
```


Other End
---------

Create & Register Middleware on other end to validate each request with token. Use same key on both ends

```
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $allowedSecrets = explode(',', env('MY_SECRETS_TOKEN'));

        if (in_array($request->header('Secret'), $allowedSecrets)) {
            return $next($request);
        }

        // 
        return response()->json(['message' => 'unauthorized token'], 401);
    }
```

Acknowledgments
---------------

This project created specific requirements for one of my projects, this may not for everyone.


Worked & Tested 
-------

Laravel/Lumen


License
-------

Composer is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
