<?php
    require('./database/db.php');
    
    /* Enregistrement d'une tache
    a)On teste si l'input n'est pas vide
    b)On recupere la tache a enregistree
    b)On enregistre ca dans la base    
    */
        // a)
    if(!empty($_POST['task'])){
        $task = strip_tags($_POST['task']);
        if($task!=""){
            $reqTask =$bdd->PREPARE('INSERT INTO tasks (name) VALUE (:name)');
            $reqTask->execute(array(':name'=>$task));
            $id= $bdd->lastInsertId();
            $reqTask->closeCursor();
           
           //Pour utiliser Ajax, on doit faire: 
            $response = array(
              'success'=>true,
              'task'=>$task,
              'id'=>$id  
            );
            
            echo json_encode($response); exit;
        }
        unset($_POST['task']);
        
    }
    
    // Je selecctionne tout le contenu de la table tasks
    $req = $bdd->PREPARE('SELECT * FROM tasks ORDER BY id DESC');
    $req->execute();
    $tasks = $req->fetchAll(PDO::FETCH_OBJ);
    // var_dump($tasks);
    $req->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List en AJAX</title>
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="./public/bootstrap/css/bootstrap.min.css">
    <style>body{margin-top:5%;}</style>
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand">Todo List</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
        <!-- Pour le menu -->
        <!-- <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">about</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul> -->
        </div>
    </div>
    </nav>
    <div class="container">
    <form action="index.php" id="form" method="post">
    <input type="text" name="task" id="task" placeholder="Tache" class="form-control">
    <br>
    <input type="submit" value="Ajouter" class="btn btn-success">
    </form>
    <br>
    <form action="delete.php" id="deleteForm" method="post">
        <table class="table">
            <thead>
                <tr>
                <th>T&acirc;che</th>
                <th><input type="checkbox" id="checkAll"></th>
                </tr>
            </thead>
            <tbody>
            <?php if($tasks){
                foreach($tasks as $element){?>
                    <tr id="<?=$element->id;?>">
                        <td class="tache"><?=$element->name; ?> </td>
                        <td><input type="checkbox" id="<?=$element->id;?>" class="del" name="task[]"></td>
                    </tr>
                <?php }}?> 
            </tbody>
        </table>
        <button class="btn btn-danger" id="button">Supprimer les t&acirc;ches</button>
        </form> 
    </div>
</body>
<!-- Bootstrap Core Javascript -->>
<script src="./public/bootstrap/js/bootstrap.min.js"></script>
<script src="./public/bootstrap/js/jquery.min.js"></script>
<script src="./public/js/script.js"></script>
</html>