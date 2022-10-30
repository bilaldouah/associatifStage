<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .width{
            width:20rem;
            font-size: 1.5rem !important;
        }
        .last{
            font-size: 1.5rem !important;

        }
        .height{
            height:100% !important;
        }
        body {
        min-height: 100vh;
        padding: 0;
        }
    </style>
</head>
<body>
    <?php
        require "menu.html";

    ?>
    <div class=" mt-5 d-flex  flex-column height justify-content-around  align-items-center">
    <div class=" d-flex  justify-content-around">
        <div class="d-flex flex-column mr-5">
            <a class="btn btn-primary m-1 width mt-5" href="pdf/attestation.pdf">Attestation </a>
            <a class="btn btn-primary m-1 width mt-5" href="pdf/استمارة الجمعية.pdf">استمارة الجمعية </a>
            <a class="btn btn-primary m-1 width mt-5" href="pdf/استمارة المؤسسات.pdf">استمارة المؤسسات </a>
        </div>
        <div class="d-flex flex-column ml-5 ">
            <a class="btn btn-primary m-1 width mt-5" href="pdf/بطاقة_الانخراط.pdf">بطاقة_الانخراط  </a>
            <a class="btn btn-primary m-1 width mt-5" href="pdf/طلب عنوان بريدي.pdf">طلب عنوان بريدي </a>
            <a class="btn btn-primary m-1 width mt-5" href="pdf/مواضيع الدورة 2022 بالتواريخ.pdf">مواضيع الدورة 2022 بالتواريخ </a>
        </div>
    </div>  
            <a class="btn btn-primary mt-5 last"  href="pdf/liste des annimateurs et programme de formation.pdf">liste des annimateurs et programme de formation </a>
    
    </div>

    


    
</body>
</html>