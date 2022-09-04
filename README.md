Simple API Request for Multiple source With GuzzleHttp
========================================

Requirement    
------------

"guzzlehttp/guzzle"


Installation 
------------

publish config

Limen
$app->configure('services');


Request
-------

use Pathum4u\ApiRequest\ApiRequest;

$client = new ApiRequest();
return $client->request('notification','POST', '/test', $request->all(),[]);

$client = new ApiRequest();
$client->service('notification');
$client->url('/');
$client->params(['email'=> 'tese@tes.com']);
$client->send();

$client = new ApiRequest();
$client->get('/');
$client->send();

Response
-------

Success
response()->json([$data], $statusCode)

Errors
response()->json(['error' => $response->getReasonPhrase(), 'message' => $this->errorMessage($responseBodyAsString)], $response->getStatusCode());


Acknowledgments
---------------

This project designed for specific needs of one of my project this may not for everyone. 


Worked & Tested 
-------

Laravel/Lumen


License
-------

Composer is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
