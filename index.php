<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.10.1/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.js"
            integrity="sha512-+IpCthlNahOuERYUSnKFjzjdKXIbJ/7Dd6xvUp+7bEw0Jp2dg6tluyxLs+zq9BMzZgrLv8886T4cBSqnKiVgUw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.20/c3.min.css"
      integrity="sha512-cznfNokevSG7QPA5dZepud8taylLdvgr0lDqw/FEZIhluFsSwyvS81CMnRdrNSKwbsmc43LtRd2/WMQV+Z85AQ=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />


      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<?php
SESSION_START();
if(!isset($_SESSION['login']))
{
  header("Location:login.php");
}
include "menu.html";
include "bd.php";
$Year=date("Y");

$query ="SELECT count(*) from association where status like 'منخرط'";
$stat=$con->prepare($query);
$stat->execute();
$data=$stat->fetchall(PDO::FETCH_NUM);
$associationAd=$data[0][0];



$queryAssNumber ="SELECT count(*) from association ";
$statAssNumber=$con->prepare($queryAssNumber);
$statAssNumber->execute();
$dataAssNumber=$statAssNumber->fetchall(PDO::FETCH_NUM);
$associationNumber=$dataAssNumber[0][0];



$queryAssNonAde ="SELECT count(*) from association where activeOuNon like 'نشيطة'";
$statAssNonAde=$con->prepare($queryAssNonAde);
$statAssNonAde->execute();
$dataAssNonAde=$statAssNonAde->fetchall(PDO::FETCH_NUM);
$associationNonAde=$dataAssNonAde[0][0];


$provinceList = array();
$provinceCountList = array();


$queryNomProvince ="SELECT * from province   ";
$statNomProvince=$con->prepare($queryNomProvince);
$statNomProvince->execute();
$dataNomProvince=$statNomProvince->fetchall();
 $idPro=$dataNomProvince[0];

 foreach($dataNomProvince as $data)
 {
    array_push($provinceList, $data[1]);
$queryNumberPro ="SELECT count(*) as 'nbr' from association where idProvince='$data[0]'";
$statNumberPro=$con->prepare($queryNumberPro);
$statNumberPro->execute();
$dataNumberPro=$statNumberPro->fetchall();
$count=$dataNumberPro[0][0];
array_push($provinceCountList, $count);
 }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 $ThemeList = array();
$ThemeCountList = array();

 $queryNomTheme ="SELECT * from theme";
 $statNomTheme=$con->prepare($queryNomTheme);
 $statNomTheme->execute();
 $dataNomTheme=$statNomTheme->fetchall();
  $idTheme=$dataNomTheme[0];

  foreach($dataNomTheme as $dataTheme)
  {
    
     array_push($ThemeList, $dataTheme[1]);

 $queryNumberThem ="SELECT count(*) as 'nbr' from association where idTheme='$dataTheme[0]'";
 $statNumberThem=$con->prepare($queryNumberThem);
 $statNumberThem->execute();
 $dataNumberThem=$statNumberThem->fetchall();
 $countTheme=$dataNumberThem[0][0];
 array_push($ThemeCountList, $countTheme);
  }
  //////////////////////////////////////////////////////

?>


<body>
    <div class="d-flex justify-content-center">
    <div  class="col-5" id="chart"></div>
    <div  class="col-5" id="chart2"></div>
 
   
    </div>
   
    <div class="d-flex justify-content-center">
       <div class="col-5">
       <h5 class=" text-center pt-5 "> <?=date('Y')?> عدد المنخرطين في كل شهر سنة </h5>
    <div  class="d-flex justify-content-center mt-5 " id="chart6"></div>
       </div>
 
       <div class="border "></div>
    <div class="col-5">
    <h5 class=" text-center pt-5 "> <?=date('Y')?> عدد القاعات المحجوزة كل شهر سنة </h5>
    <div  class="d-flex justify-content-center mt-5 " id="chart7"></div>
    </div>
 
    </div>
   
   
    <h3 class="text-center pt-5">العمالات و الأقاليم</h3>
<div class="d-flex" >
    <div class="col-1"></div>

<div class="col-10  w-100 mt-5  "   id="chart4"> </div>
<div class="col-1"></div>
</div>
<h3 class="text-center pt-5">التخصصات </h3>
<div class="d-flex" >
    <div class="col-1"></div>
<div class="col-10  w-100 mt-5  "   id="chart5"></div>
<div class="col-1"></div>
</div>

<div class="m-5">
    <h3 class="text-center pt-4 pb-3"> <?=date('Y')?> عدد الحجوزات في كل قاعة لسنة</h3>
    <?php
    $queryNumberResSalle ="SELECT nomSalle,numeroSalle,count(*) as 'numberReservation'
    from reservation r inner join salle s on r.idSalle=s.id
    WHERE YEAR(date_de_rese) like YEAR(CURDATE())
    GROUP BY idSalle 
    order by count(*) desc";
    $statNumberResSalle=$con->prepare($queryNumberResSalle);
    $statNumberResSalle->execute();
    $dataNumberResSalle=$statNumberResSalle->fetchall();
 
    ?>
  <table class="table table-white table-hover">
    <thead class="thead-dark">
      <tr>
      <th class="text-center">عدد المرات المحجوزة</th>
      <th class="text-center">رقم القاعة</th>
      <th class="text-center">إسم القاعة</th>
      </tr>
    </thead>
    <tbody>
        <?php
        foreach ($dataNumberResSalle as $data)
        {

        
        ?>
      <tr>
      <td class="text-center"><?= $data["numberReservation"]?></td>
      <td class="text-center"><?=$data["numeroSalle"]?></td>
      <td class="text-center"><?=$data["nomSalle"]?></td>
        
        
      </tr>
      <?php
        }
      ?>
    </tbody>
  </table>

</div>


<script>

var chart = c3.generate({
    bindto: "#chart",
    data: {
        columns: [
            ['الجمعيات المنخرطة', 0]
        ],
        type: 'gauge',
        onclick: function (d, i) { console.log("onclick", d, i); },
        onmouseover: function (d, i) { console.log("onmouseover", d, i); },
        onmouseout: function (d, i) { console.log("onmouseout", d, i); }
    },
    gauge: {
    label: {
           format: function(value, ratio) {
               return value;
           },
           show: true // to turn off the min/max labels.
      },
//    min: 0, // 0 is default, //can handle negative min e.g. vacuum / voltage / current flow / rate of change
   max: <?=$associationNumber?>, // 100 is default
    units: 'جمعيات',
//    width: 39 // for adjusting arc thickness
    },
    color: {
        pattern: ['#FF0000', '#F97600', '#F6C600', '#60B044'], // the three color levels for the percentage values.
        threshold: {
//            unit: 'value', // percentage is default
//            max: 200, // 100 is default
            values: [30, 60, 90, 100]
        }
    },
    size: {
        height: 180
    }
});

setTimeout(function () {
    chart.load({
        columns: [['الجمعيات المنخرطة', <?=$associationAd?>]]
    });
}, 1000);




var chart2 = c3.generate({
    bindto: "#chart2",
    data: {
        columns: [
            ['الجمعيات النشيطة', 0]
        ],
        type: 'gauge',
        onclick: function (d, i) { console.log("onclick", d, i); },
        onmouseover: function (d, i) { console.log("onmouseover", d, i); },
        onmouseout: function (d, i) { console.log("onmouseout", d, i); }
    },
    gauge: {
    label: {
           format: function(value, ratio) {
               return value;
           },
           show: true // to turn off the min/max labels.
      },
//    min: 0, // 0 is default, //can handle negative min e.g. vacuum / voltage / current flow / rate of change
   max: <?=$associationNumber?>, // 100 is default
    units: 'جمعيات',
//    width: 39 // for adjusting arc thickness
    },
    color: {
        pattern: [ '#60B044'], // the three color levels for the percentage values.
        threshold: {
//            unit: 'value', // percentage is default
//            max: 200, // 100 is default
            values: [30, 60, 90, 100]
        }
    },
    size: {
        height: 180
    }
});

setTimeout(function () {
    chart2.load({
        columns: [['الجمعيات النشيطة', <?=$associationNonAde?>]]
    });
}, 1000);




var chart4 = c3.generate({
    bindto: "#chart4",
    data: {
  
        columns:  
            [
     <?php
     for ($i=0; $i<count($provinceList);$i++)
     {
        ?>

            ['<?=$provinceList[$i]?>',0],


     <?php
     }
      ?>
             ],
    
        type: 'bar',
        colors: {
            data1: '#ff0000',
            data2: '#00ff00',
            data3: '#0000ff'
        },
        labels: true
    }
});
setTimeout(function () {
    chart4.load({
        columns: [
            <?php
            for ($i=0; $i<count($provinceList);$i++)
     {
        ?>

            ['<?=$provinceList[$i]?>', <?=$provinceCountList[$i]?>],


     <?php
     }
      ?>
             
        ]
    });
}, 1000);



var chart5 = c3.generate({
    bindto: "#chart5",
    data: {
  
        columns:  
            [
     <?php
     for ($i=0; $i<count($ThemeList);$i++)
     {
        ?>

            ['<?=$ThemeList[$i]?>',0],


     <?php
     }
      ?>
             ],
    
        type: 'bar',
        colors: {
            data1: '#ff0000',
            data2: '#00ff00',
            data3: '#0000ff'
        },
        labels: true
    }
});
setTimeout(function () {
    chart5.load({
        columns: [
            <?php
            for ($i=0; $i<count($ThemeList);$i++)
     {
        ?>

            ['<?=$ThemeList[$i]?>', <?=$ThemeCountList[$i]?>],


     <?php
     }
      ?>
             
        ]
    });
}, 1000);


var chart6 = c3.generate({
    bindto: "#chart6",
    data: {
        columns: [
            <?php
        for($i=1; $i<=12;$i++)
{
    $queryYearAdesion ="SELECT count(*)  from association  WHERE YEAR(date_dadession)=YEAR(NOW()) and MONTH(date_dadession)=$i";
    $statYearAdesion=$con->prepare($queryYearAdesion);
    $statYearAdesion->execute();
    $dataYearAdesion=$statYearAdesion->fetchall();
    $countYearAdesion=$dataYearAdesion[0][0];
    $dateObj   = DateTime::createFromFormat('!m', $i);
    $monthName = $dateObj->format('F'); 
    ?>
            ['<?=$monthName?>',0],
            <?php
}
       
  ?>
          
        ],
        type: 'pie'
    },
    pie: {
        label: {
            format: function (value, ratio, id) {
                return d3.format('')(value);
            }
        }
    }
});

setTimeout(function () {
    chart6.load({
       
columns:[ <?php
        for($i=1; $i<=12;$i++)
{
    $queryYearAdesion ="SELECT count(*)  from association  WHERE YEAR(date_dadession)=YEAR(NOW()) and MONTH(date_dadession)=$i";
    $statYearAdesion=$con->prepare($queryYearAdesion);
    $statYearAdesion->execute();
    $dataYearAdesion=$statYearAdesion->fetchall();
    $countYearAdesion=$dataYearAdesion[0][0];
    $dateObj   = DateTime::createFromFormat('!m', $i);
$monthName = $dateObj->format('F'); 
?> ['<?=$monthName?>', <?=$countYearAdesion?>],
 
<?php
}
       
  ?>
    ]
    });
}, 1000);



var chart7 = c3.generate({
    bindto: "#chart7",
    data: {
        columns: [
            <?php
        for($i=1; $i<=12;$i++)
{
    $queryYearSalle =" SELECT  count(*) FROM stage.reservation
	where year(date_de_rese) like $Year and  month(date_de_rese)  like $i";

    $statYearSalle=$con->prepare($queryYearSalle);
    $statYearSalle->execute();
    $dataYearSalle=$statYearSalle->fetchall();
    $countYearSalle=$dataYearSalle[0][0];
    $dateObj   = DateTime::createFromFormat('!m', $i);
    $monthName = $dateObj->format('F'); 
    ?>
            ['<?=$monthName?>',0],
            <?php
}
       
  ?>
          
        ],
        type: 'pie'
    },
    pie: {
        label: {
            format: function (value, ratio, id) {
                return d3.format('')(value);
            }
        }
    }
});

setTimeout(function () {
    chart7.load({
       
columns:[ <?php
        for($i=1; $i<=12;$i++)
{
    $queryYearSalle =" SELECT  count(*) FROM stage.reservation
	where  year(date_de_rese) like $Year and  month(date_de_rese)  like $i";

    $statYearSalle=$con->prepare($queryYearSalle);
    $statYearSalle->execute();
    $dataYearSalle=$statYearSalle->fetchall();
    $countYearSalle=$dataYearSalle[0][0];
    $dateObj   = DateTime::createFromFormat('!m', $i);
$monthName = $dateObj->format('F'); 
?> ['<?=$monthName?>',<?=$countYearSalle?>],
 
<?php
}
       
  ?>
    ]
    });
}, 1000);

    </script>

</body>
</html>