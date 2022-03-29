<?php
session_start();
include_once("../Service/Service.php");
include_once("../Entities/Response.php");
$method = null;
$data = null;

if (isset($_GET["method"])) {
    $method = $_GET["method"];
    if (isset($_GET["data"])) {
        $data = $_GET["data"];
    }
} else if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0) {
    $json = file_get_contents('php://input');
    $json_decoded = json_decode($json);
    $method = $json_decoded->method;
    if (isset($json_decoded->data)) {
        $data = $json_decoded->data;
    }
}
//todo: call service methods to handle requests

$service = new Service();

switch ($method) {
    case 'getAllTasks':
        getAllTasks();
        break;
    case 'getTaskById':
        getTaskById($data);
        break;
    case 'createTask':
        createTask(new Task($data->title, $data->content));
        break;
    case 'deleteTask':
        deleteTask($data);
        break;

    default:
        header('Content-Type: application/json');
        http_response_code(300);
        break;
}

function getAllTasks()
{
    global $service;
    $tasks = $service->getAllTasks();
    $header = 'Content-Type: application/json';
    $jsonTasksArray = taskArrayToJson($tasks);
    $response = new Response($header, 200, $jsonTasksArray);
    $response->sendJson();
}

function getTaskById($id)
{
    global $service;

    try {
        $task = $service->getTaskById($id);
        $header = 'Content-Type: application/json';
        $response = new Response($header, 200, $task->serialize());
        $response->sendJson();
    } catch (TaskNotFoundException $e) {
        $header = 'Content-Type: text/html';
        $response = new Response($header, 404, $e->getMessage());
        $response->sendHtml();
    } catch (TaskValidationException $e) {
        $header = 'Content-Type: text/html';
        $response = new Response($header, 422, $e->getMessage());
        $response->sendHtml();
    }
}

function createTask($task)
{
    global $service;
    try {
        $newTask = $service->createTask($task);
        $header = 'Content-Type: application/json';
        //echo $task->title;
        $response = new Response($header, 200, $newTask->serialize());
        $response->sendJson();
    } catch (TaskValidationException $e) {
        $header = 'Content-Type: text/html';
        $response = new Response($header, 422, $e->getMessage());
        $response->sendHtml();
    }
}

function deleteTask($task)
{
    global $service;
}

function taskArrayToJson($tasks)
{
    $tasksArray = [];
    foreach ($tasks as $task) {
        array_push($tasksArray, $task->serialize());
    }
    return $tasksArray;
}
