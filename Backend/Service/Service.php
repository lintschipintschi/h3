<?php
include_once("../Persistence/TaskDemoDb.php");
include_once("../Exceptions/TaskNotFoundException.php");
include_once("../Exceptions/TaskValidationException.php");

class Service
{

    private $demoDb;

    function __construct()
    {
        $this->demoDb = new TaskDemoDb();
    }

    function getAllTasks()
    {
        return $this->demoDb->getAllTasks();
    }

    /**
     * @throws TaskNotFoundException when a task with this specified id is not found 
     */
    function getTaskById($id)
    {
        if (!is_numeric($id)){
            throw new TaskValidationException("Invalid id: Id must be a positive integer. Non numeric id was prvided");
        }
        if ($id < 0) {
            throw new TaskValidationException("negative Id was provided, Id must be greater or equal to 0");
        }
       // try {
            return $this->demoDb->getTaskById($id);
      //  } catch (TaskNotFoundException $e) {
            //log before re-throwing
       //     throw new $e;
      //  }
    }

    function createTask(Task $task)
    {
        if ($task == null) {
            throw new TaskValidationException("Null is not a valid task");
        }
        if ($task->getTitle() == null || $task->getTitle() == "") {
            throw new TaskValidationException("invalid title was provided");
        }
        if ($task->getContent() == null || $task->getContent() == "") {
            throw new TaskValidationException("invalid content was provided");
        }
        return $this->demoDb->createTask($task);
    }

    function deleteTask(Task $task)
    {
        if ($task == null) {
            throw new TaskValidationException("Null is not a valid task");
        }
        if ($task->getId() == null || $task->getId() == "" || $task->getId() < 0) {
            throw new TaskValidationException("invalid ID was provided");
        }
        //try {
            $this->demoDb->deleteTask($task);
       // } catch (TaskNotFoundException $e) {
             //log before re-throwing
       //      throw new $e;
       // }
    }
}
