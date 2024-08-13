<?php

require_once '../controllers/PostController.php';

// Get the full request URI
$request = $_SERVER['REQUEST_URI'];

// Base path to be removed
$basePath = '/blog-api/public';
if (strpos($request, $basePath) === 0) {
    $request = substr($request, strlen($basePath));
}

$queryString = parse_url($request, PHP_URL_QUERY);
$request = parse_url($request, PHP_URL_PATH);
$request = trim($request, '/');
$parts = explode('/', $request);
$endpoint = $parts[1] ?? '';
$id = $parts[2] ?? '';

$queryParams = [];
if ($queryString) {
    parse_str($queryString, $queryParams);
}



$postController = new PostController();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if ($endpoint === 'posts') {
            $postController->create();
        }
        break;

    case 'GET':
        if ($endpoint === 'posts') {
            if ($id) {
                $postController->readOne($id);
            } else {
                $page = $queryParams['page'] ?? 1;
                $limit = $queryParams['limit'] ?? 10;
                $postController->read($page, $limit);
            }
        }
        break;

    case 'PUT':
        if ($endpoint === 'posts' && $id) {
            $postController->update($id);
        }
        break;

    case 'DELETE':
        if ($endpoint === 'posts' && $id) {
            $postController->delete($id);
        }
        break;

    default:
        Response::send(['message' => 'Method not allowed.'], 405);
        break;
}

?>
