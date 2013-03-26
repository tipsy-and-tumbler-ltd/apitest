<?php
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

/**
 *  Returns basic html to the client
 */
$app->get('/', function () {
    $template = <<<EOT
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
            <title>API Test</title>
        </head>
        <body>
            <div>
                <h3>Welcome to API Test</h3>
                <p>This is a basic api used for testing pruposes.</p>
            </div>
        </body>
    </html>
EOT;
    echo $template;
});


$app->notFound(function () use ($app) {
    $app->response()->status(404);
    echo "API route not found. Are you sure you know what your looking for...";
});


/**
 * USERS SECTION
 -----------------------------------------------------------------------------*/

/* @xgenapi_start
 * sectionName == Users | Handles Adding, updating, retrieving and deleting users
 * endpointRoute == GET | /users/retrieve
 * description == Retrieve all users
 * responseCodes == 200 | Successfully retrieved all users
 * @xgenapi_end */
$app->get('/users/retrieve', function(){
    $timeStart = microtime(true);
    usleep(750000); //sleep for micro seconds
    $timeEnd = microtime(true);
    $executionTime = $timeEnd - $timeStart;
    $returnObject = array('error' => null, 'data' => array(array('id' => 1, 'username' => 'usernameOne'), 
        array('id' => 2, 'username' => 'usernameTwo')), 'executionTime' => round($executionTime, 4));
    echo json_encode($returnObject);
});

/* @xgenapi_start
 * sectionName == Users
 * endpointRoute == GET | /users/:id/retrieve
 * description == Retrieve a single user
 * responseCodes == 200
 * urlParameters == :id | id | The users id | true | int
 * @xgenapi_end */
$app->get('/users/:id/retrieve', function($id){
    $timeStart = microtime(true);
    usleep(50000); //sleep for micro seconds
    
    $returnObject = array('error' => null, 'data' => null, 'executionTime' => 0);
    
    if($id == 1){
        $returnObject['data'] = array('id' => 1, 'username' => 'usernameOne');
    }else if($id == 2){
        $returnObject['data'] = array('id' => 2, 'username' => 'usernameOne');
    }else{
        $returnObject['error'] = array('message' => 'No user found with that id, try to use 1 or 2');
    }
    
    $timeEnd = microtime(true);
    $executionTime = $timeEnd - $timeStart;
    $returnObject['executionTime'] = round($executionTime, 4);
    echo json_encode($returnObject);
});

/* @xgenapi_start
 * sectionName == Users
 * endpointRoute == POST | /users/:id/update
 * description == Update a user (test using form-data)
 * responseCodes == 200 | User updated successfully <> 400 | Bad request (incorrect parameters set)
 * bodyParameters == username | The users username to update | true | string <> firstName | The users first name | optional | string
 * urlParameters == :id | id | The users id who you are updating | true | int
 * @xgenapi_end */
$app->post('/users/:id/update', function($id) use ($app){
    $timeStart = microtime(true);
    usleep(58000); //sleep for micro seconds
    
    // The params are passed in a json string object
    $req = $app->request();
//    $body = $req->getBody();
//    $bodyParams = json_decode($body);
    $username = $req->post('username');
    
    $timeEnd = microtime(true);
    $executionTime = $timeEnd - $timeStart;
    
    if($username != null){
        $returnObject = array('error' => null, 'data' => array('message' => 'User ' . $username . ' updated successfully'), 'executionTime' => round($executionTime, 4));
        echo json_encode($returnObject);
    }else{
        $app->response()->status(400);
        $res = $app->response();
        $res->body('Bad Request: username needs to be set');
    }
});

/* @xgenapi_start
 * sectionName == Users
 * endpointRoute == POST | /users/:id/update/test/with/rawdata
 * description == Update a user (test using raw data) | This api endpoint requires you to pass in a json object as a raw string, NOT as form-data.
 * responseCodes == 200 | User updated successfully <> 400 | Bad request (incorrect parameters set)
 * bodyParameters == username | The users username to update | true | string <> firstName | The users first name | optional | string
 * urlParameters == :id | id | The users id who you are updating | true | int
 * @xgenapi_end */
$app->post('/users/:id/update/test/with/rawdata', function($id) use ($app){
    $timeStart = microtime(true);
    usleep(58000); //sleep for micro seconds
    
    // The params are passed in a json string object
    $req = $app->request();
    $body = $req->getBody();
    $bodyParams = json_decode($body);
    
    $timeEnd = microtime(true);
    $executionTime = $timeEnd - $timeStart;
    
    if($bodyParams->username != null){
        $returnObject = array('error' => null, 'data' => array('message' => 'User ' . $bodyParams->username . ' updated successfully'), 'executionTime' => round($executionTime, 4));
        echo json_encode($returnObject);
    }else{
        $app->response()->status(400);
        $res = $app->response();
        $res->body('Bad Request: username needs to be set');
    }
});

/* @xgenapi_start
 * sectionName == Users
 * endpointRoute == DELETE | /users/:id/delete
 * description == Delete a user
 * responseCodes == 200
 * urlParameters == :id | id | The users id who you are updating | true | int
 * @xgenapi_end */
$app->delete('/users/:id/delete', function($id) use ($app){
    $timeStart = microtime(true);
    usleep(38000); //sleep for micro seconds
    
    $timeEnd = microtime(true);
    $executionTime = $timeEnd - $timeStart;
    $returnObject = array('error' => null, 'data' => array('message' => 'User deleted successfully'), 'executionTime' => round($executionTime, 4));
    echo json_encode($returnObject);
});

/* @xgenapi_start
 * sectionName == Users
 * endpointRoute == PUT | /users/new
 * description == Add a user
 * responseCodes == 201 | User updated successfully
 * bodyParameters == username | The users username to add | true | string 
 * @xgenapi_end */
$app->put('/users/new', function() use ($app) {
    $timeStart = microtime(true);
    usleep(145000); //sleep for micro seconds
    
    // the params are passed in as form data NOT WORKING
    $req = $app->request();
    $username = $req->put('username');
    
    $timeEnd = microtime(true);
    $executionTime = $timeEnd - $timeStart;
    $returnObject = array('error' => null, 'data' => array('id' => 3, 'username' => $username), 'executionTime' => round($executionTime, 4));
    $app->response()->status(201);
    echo json_encode($returnObject);
});

/* @xgenapi_start
 * sectionName == Users
 * endpointRoute == GET | /users/:id/favourites?custom1=value1&custom2=value2&custom3=value3&custom4=value4&apikey=value5
 * description == Retrieve the user's favourites. This is a long short description to see what happens.
 * responseCodes == 200 | Success
 * urlParameters == :id | id | The users id | true | int <> value1 | param1 | Just a testing parameter | optional | string <> value2 | param2 | Just a testing parameter | optional | string <> value3 | param3 | Just a testing parameter | optional | string <> value4 | param4 | Just a testing parameter | optional | string <> value5 | apikey | The api key to access the public api | true | string
 * @xgenapi_end */
$app->get('/users/:id/favourites', function() use ($app){
    $returnObject = array('error' => null, 'data' => null);
    $timeStart = microtime(true);
    usleep(145000); //sleep for micro seconds
    
    $req = $app->request();
    $key = $req->get('apikey');
    $param1 = $req->get('custom1');
    $param2 = $req->get('custom2');
    $param3 = $req->get('custom3');
    $param4 = $req->get('custom4');
    
    $timeEnd = microtime(true);
    $executionTime = $timeEnd - $timeStart;
    
    if($key != null){
        $returnObject['data'] = array('key' => $key, 'custom1' => $param1, 'custom2' => $param2, 'custom3' => $param3, 'custom4' => $param4, 'executionTime' => round($executionTime, 4));
    }else{
        $returnObject['error'] = array('message' => 'Incorrect API key', 'key' => $key);
    }
    echo json_encode($returnObject);
});





/**
 * ERRORS SECTION
 -----------------------------------------------------------------------------*/
/* @xgenapi_start
 * sectionName == Errors | Api endpoints to test different response codes and errors
 * endpointRoute == GET | /errors/internalServerError
 * description == Test returning 500 Internal server error
 * responseCodes == 500 | Internal server error
 * @xgenapi_end */
$app->get('/errors/internalServerError', function() use ($app){
    $app->response()->status(500);
    $res = $app->response();
    $res->body('Internal server error, Sorry about this.');
});

/* @xgenapi_start
 * sectionName == Errors
 * endpointRoute == GET | /errors/tryusepost
 * description == Test 404 route not found
 * responseCodes == 200 | Success <> 404 | Route not found
 * @xgenapi_end */
$app->get('/errors/tryusepost', function() use ($app){
    $returnObject = array('error' => null, 'data' => array('message' => 'Try to make this api call using the POST method.'), 'executionTime' => 0);
    echo json_encode($returnObject);
});

/* @xgenapi_start
 * sectionName == Errors
 * endpointRoute == GET | /errors/unauthorized
 * description == Test setting X-Token header for authorization
 * responseCodes == 200 | Success <> 401 | Not authorized
 * @xgenapi_end */
$app->get('/errors/unauthorized', function() use ($app){
    $req = $app->request();
    
    $token = $req->headers('X-Token');
    if($token == '123456789'){
        $returnObject = array('error' => null, 'data' => array('message' => 'You have access'), 'executionTime' => 0);
        echo json_encode($returnObject);
    }else{
        $app->response()->status(401);
        $res = $app->response();
        $res->body('Unauthorised access: Please set the X-Token in the headers to 123456789');
    }
});



/**
 * HEADERS SECTION
 -----------------------------------------------------------------------------*/
/* @xgenapi_start
 * sectionName == Headers | Testing custom headers
 * endpointRoute == GET | /headers/usertoken
 * description == Test setting X-Token header for authorization
 * responseCodes == 200 | Success <> 401 | Not authorized
 * @xgenapi_end */
$app->get('/headers/usertoken', function() use ($app){
    $req = $app->request();
    
    $token = $req->headers('X-Token');
    if($token == '123456789'){
        $returnObject = array('error' => null, 'data' => array('message' => 'You have access'), 'executionTime' => 0);
        echo json_encode($returnObject);
    }else{
        $app->response()->status(401);
        $res = $app->response();
        $res->body('Unauthorised access: Please set the X-Token in the headers to 123456789');
    }
});

/* @xgenapi_start
 * sectionName == Headers
 * endpointRoute == GET | /headers/customheader
 * description == Test setting X-Custom-Param header for fun
 * @xgenapi_end */
$app->get('/headers/customheader', function() use ($app){
    $req = $app->request();
    
    $custom = $req->headers('X-Custom-Param');
    if($custom == '123'){
        $returnObject = array('error' => null, 'data' => array('message' => 'You set the header to the correct value'), 'executionTime' => 0);
        echo json_encode($returnObject);
    }else{
        $returnObject = array('error' => array('message' => 'Please set the header X-Custom-Param to 123'), 'data' => null, 'executionTime' => 0);
        echo json_encode($returnObject);
    }
});


$app->run();
