<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formation</title>
    <style type="text/css">
        .hover:hover 
        { 
            color: red !important; 
            font-weight: bold !important;
        }
        .size{
            font-size:1.5em !important;
        }
       
    </style>
</head>

<body>
    <?php
        SESSION_START();
        if(!isset($_SESSION['login']))
        {
        header("Location:login.php");
        }
        require "menu.html";
        
        
    ?>
    <div class="h-25 p-3">
    <div class="  d-flex justify-content-center  w-75 m-auto">
        <form method="post" class="mb-5  py-5" id="formContent" >
            <div id="add">
                <label class="d-flex text-right mr-5  flex-column text-info size">Name</label>  
                <input type="text"  class="fadeIn second" name="nom" placeholder="name"  >

            <div class="  d-flex justify-content-between mr-5">  
               <label class="ml-5 mt-3 text-info size hover" onclick="ajouter()">Add topic</label> 
                <label class="d-flex flex-column text-right  mt-3 text-info size">Topics</label>            
            </div>
            
            <div class="  d-flex justify-content-between mr-5 ml-5" id="ajou">  
                <input type="text"  class="fadeIn second" name="1_" placeholder="date"  >
                <input type="text"  class="fadeIn second" name="1" placeholder="topic"  >
            </div>
            
            </div>

            <input type="submit" class="fadeIn fourth mt-5" value="Send" onclick="actionform()">

        </form>
    </div>
    </div>
    <script>
        var clic=1;
        function ajouter() {
            
            clic++;
            var objTo = document.getElementById('add')
            var divtest = document.createElement("div");
            divtest.classList.add('d-flex');
            divtest.classList.add('justify-content-between');
            divtest.classList.add('mr-5');
            divtest.classList.add('ml-5');
            var ajou = '<input type="text"  class="fadeIn second" name="'+clic+'_" placeholder="المواضيع"  ><input type="text"  class="fadeIn second" name="'+clic+'" placeholder="المواضيع"  >';
            divtest.innerHTML=ajou;
            objTo.appendChild(divtest);
            
        }
        function actionform(){
            document.getElementById('formContent').action="pdf/attestation.php?clic="+clic;
        }
    </script>
</body>
</html>