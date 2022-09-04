API Request for Multiple source With GuzzleHttp
========================================

Requirement    
------------

"guzzlehttp/guzzle"


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
return $client->request('notification','POST', '/test', $request->all(),[]);
```

```
$client = new ApiRequest();
$client->service('notification');
$client->url('/');
$client->params(['email'=> 'tese@tes.com']);
$client->send();
```

```
$client = new ApiRequest();
$client->get('/');
$client->send();
```


Responses
-------

Success

```
response()->json([$data], $statusCode)
```

Errors

```
response()->json(['error' => $response->getReasonPhrase(), 'message' => $this->errorMessage($responseBodyAsString)], $response->getStatusCode());
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
