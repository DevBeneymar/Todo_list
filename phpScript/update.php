<?php
    require('../database/db.php');
    if(!empty($_POST)){
        extract($_POST);
        $id = strip_tags($id);
        $task = strip_tags($task);
        if($id !="" && $task!=""){
            //script for update data
            $repUpdate = $bdd->prepare('UPDATE tasks SET name = :name WHERE id = :id');
            $repUpdate->execute(array(':id'=>$id,':name'=>$task));
            $repUpdate->closeCursor(); 
        }
    }
   
?>