<?php
class Task
{

    private $id;
    private $title;
    private $content;

    function __construct($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    function setId($id)
    {
        $this->id = $id;
    }
    
    function getId()
    {
       return $this->id;
    }

    function getTitle(){
        return $this->title;
    }
    function getContent(){
        return $this->content;
    }

   function serialize(){
       return get_object_vars($this);
   }
   

}
