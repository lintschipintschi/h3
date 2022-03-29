<?php

include("../Entities/Task.php");
include("../Exceptions/TaskNotFoundException.php");

class TaskDemoDb
{
    private static $id = 0;
    private  $demoDb = array();

    function __construct()
    {
        $task = new Task("Wash Dishes", "Dirty Stuff needs wash");
        $this->createTask($task);
        $task = new Task("Wash clothes", "Dirty Stuff needs instant wash");
        $this->createTask($task);
        $task = new Task("Wash Face", "Dirty Face needs wash");
        $this->createTask($task);
        $task = new Task("Wash Hands", "Please wash hands after peeing");
        $this->createTask($task);
        $task = new Task("Stay seriuos", "Me needs stay siriäs!");
        $this->createTask($task);
    } 

    function getAllTasks()
    {
        return $this->demoDb;
    }

    /**
     * @throws TaskNotFoundException when a task with this specified id is not found 
     */
    function getTaskById($id)
    {
        for ($i=0; $i < count($this->demoDb); $i++) { 
           if ($this->demoDb[$i]->getId()==$id){
               return $this->demoDb[$i];
           }
        }
        throw new TaskNotFoundException("Task not found!");
    }

    function createTask(Task $task)
    {
        $task->setId(TaskDemoDb::nextId());
        array_push($this->demoDb, $task);
        return $task;
    }

    /**
     *  @throws TaskNotFoundException  when a Task cannot be deleted because it was not found
     */
    function deleteTask(Task $task)
    {
        for ($i=0; $i < count($this->demoDb); $i++) { 
            if ($this->demoDb[$i]->getId()==$task->getId()){
                unset($this->demoDb[$i]);
                return true;
               
            }
         }
         throw new TaskNotFoundException("Cannot delete. Task not found!");
    }

    private static function nextId()
    {
        return TaskDemoDb::$id++;
    }
}
