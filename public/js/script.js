$(function(){
   var $tache = $('.tache'), $form = $('#form'), $checkAll=$('#checkAll'), del=$('.del'), deleteForm=$('.deleteForm');
  
//   For add and Load data with Ajax 
   $form.on({
    'submit':function(e){
        e.preventDefault();
        var data = $(this).serialize(), url = $(this).attr('action'), method= $(this).attr('method');
        
        $.ajax({
           type:method,
           url:url,
           data:data,
           dataType:'json',
           success: function(response){
            //    console.log(response);
               if(response.success){
                   $('tbody').prepend('<tr id="'+response.id+'"><td class="tache">'+response.task+'</td><td><input type="checkbox" id="'+response.id+'" class="del" name="task[]" value="'+response.id+'"/></td></tr>');
                   $('#task').val('');
               }
           }
        });
    }
   });
   
//    For Update data with Ajax, using contenteditable...
    $tache.each(function(){ //Pour chaque tache
        $(this).on({
           'click':function(){ //Lors du click
               $(this).attr('contenteditable',true); //on fait passer a TRUE l'attribut contenteditable            
           },
           'blur':function(){
               $(this).removeAttr('contenteditable');
               var $task = $(this).text(), $id=$(this).closest('tr').attr('id');
               console.log(`${$id} - ${$task}`);
               $.ajax({
                   type:'post',
                   url:'../../../PHP/phpScript/update.php',
                   data:{id:$id,task:$task},
                   dataType:'json',
                   success:function(response){
                       if(response.success){
                           console.log('update');                           
                       }
                   }
               });
           } 
        });
    });
    
});