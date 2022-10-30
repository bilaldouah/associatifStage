<?php

    require("pdf/vendor/setasign/tcpdf/tcpdf.php");
    require("bd.php");
//---association

if(!isset($_GET['id']))
{
  $id="";
}
else
{
  $id = $_GET['id'];
}

if(!isset($_GET['idTheme']))
{
  $idTheme="";
}
else
{
  $idTheme = $_GET['idTheme'];
}
if(!isset($_GET['status']))
{
  $status="";
}
else
{
  $status = $_GET['status'];
}
if(!isset($_GET['active']))
{
  $active="";
}
else
{
  $active = $_GET['active'];
}

$provinceQeury="true";
$themeQeury="true";
$statusQeury="true";
$activeQeury="true";
if(!empty($id)){$provinceQeury="association.idProvince='$id'";} 
if(!empty($idTheme)){$themeQeury="association.idTheme='$idTheme'";} 
if(!empty($status)){ $statusQeury="association.status='$status'";}
if(!empty($active)){$activeQeury="association.activeOuNon='$active'";} 

$queryAll="SELECT * FROM theme inner join association  on theme.idTheme=association.idTheme 
inner join province on association.idProvince=province.idProvince where {$provinceQeury}
and {$themeQeury} and {$statusQeury} and {$activeQeury} ";

$stmtAll=$con->prepare($queryAll);
$stmtAll->execute();
$data =$stmtAll->fetchall(); 

//Création d'un nouveau doc pdf (Portrait, en mm , taille A5)
$pdf = new TCPDF('P', 'mm','A4');

// set some language dependent data:
$lg = Array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'fa';
$lg['w_page'] = 'page';

// set some language-dependent strings (optional)
$pdf->setLanguageArray($lg);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//Ajouter une nouvelle page
$pdf->AddPage('L', 'A4');


// entete
$pdf->SetFont('aefurat ', '', 15);

$pdf->Image('image/logo.png', 50, 3, 35, 25);
$pdf->Cell(30);
$pdf->Write(5,"المملكة المغربية \n");

$pdf->Cell(30);
$pdf->Write(5,"فضاء تكوين وتنشيط النسيج الجمعوي جهة الشرق\n");
// Saut de ligne
$pdf->Ln(10);


// Police dejavusans gras 16
$pdf->SetFont('aealarabiya', '', 20);
// Titre
if(empty( $idTheme)) {
$pdf->Cell(0, 10, 'لائحة الجمعيات ', 'TB', 1, 'C');
}
else{
  $pdf->Cell(0, 10,' لائحة الجمعيات مجال التدخل : '.$data[0]["nomThem"] , 'TB', 1, 'C');
}
// Saut de ligne
$pdf->Ln(5);

// Début en police dejavusans normale taille 10

$pdf->SetFont('dejavusans', '', 7.5);
$h=10;


//tableux
$html='
<style>
    
      table {
          border-collapse:collapse;

      }
      
      th,td {
          border:1px solid black;
          text-align: center; 
          padding: auto !important;

 
      }
   
      table tr th {
          background-color:rgb(216, 216, 216);
          color:black;

      }

      </style>
<table>
   
';
if(empty( $idTheme)) {
  $html.='
      <tr  style="line-height: 250%; font-size: 8px; " >
          <th width="19%">إسم الجمعية</th>
          <th width="8%">تاريخ تأسيس</th>    
          <th width="11%">العمالة أو الإقليم</th>
          <th width="19%" style="  padding: 3px;">العنوان</th>
          <th width="10%">إسم الرئيس</th>
          <th width="9%">الهاتف</th>
          <th width="15%">البريد الإلكتروني</th>   
          <th width="9%">مجال التدخل</th>
      </tr>
    
  ';
  foreach($data as $row){	
    $html .= '
        <tr  style=" line-height: 200%;">
  
        <td>'.  $row["nom"].'</td>
        <td >'.$row["date_de_creation"].'</td>
        <td >'.$row["nomProvince"].'</td>
        <td>'.$row["adresse"].'</td>
        <td >'. $row["nomPresident"].'</td>
        <td >'.$row["telefix"].'</td>
        <td >'.$row["email"].'</td>
        <td >'.$row["nomThem"].'</td>
        </tr>
        ';
  }
}
else{
  $html.='   
    <tr  style="line-height: 250%; font-size: 8px; " >
      <th width="20%">إسم الجمعية</th>
      <th width="10%">تاريخ تأسيس</th>    
      <th width="10%">العمالة أو الإقليم</th>
      <th width="20%" style="  padding: 3px;">العنوان</th>
      <th width="12%">إسم الرئيس</th>
      <th width="11%">الهاتف</th>
      <th width="16%">البريد الإلكتروني</th>
    </tr>
    
  ';
  foreach($data as $row){	
    $html .= '
        <tr  style=" line-height: 200%;">
  
        <td>'.  $row["nom"].'</td>
        <td >'.$row["date_de_creation"].'</td>
        <td >'.$row["nomProvince"].'</td>
        <td>'.$row["adresse"].'</td>
        <td >'. $row["nomPresident"].'</td>
        <td >'.$row["telefix"].'</td>
        <td >'.$row["email"].'</td>
        </tr>
        ';
  }
}




$html .= "
	</table>
	";
//WriteHTMLCell
$pdf->WriteHTML($html);	

/*$pdf->SetFillColor(224,235,255);
$pdf->Cell(30.5,5,'إسم الجمعية',1,0,'C',1);
$pdf->Cell(30.5,5,'تاريخ الإنشاء',1,0,'C',1);
$pdf->Cell(30.5,5,'العمالة أو الإقليم',1,0,'C',1);
$pdf->Cell(65,5,'العنوان',1,0,'C',1);
$pdf->Cell(30.5,5,'إسم الرئيس',1,0,'C',1);
$pdf->Cell(30.5,5,'GSM الهاتف',1,0,'C',1);
$pdf->Cell(30.5,5,'البريد الإلكتروني',1,0,'C',1);
$pdf->Cell(30.5,5,'مجال التدخل',1,0,'C',1);
$pdf->SetFillColor(255,255,255);

foreach($data as $row){	
  $pdf->ln(5.1);
$pdf->Cell(30.5,5, $row['nom'],1,0,'C',1);
$pdf->Cell(30.5,5, $row['date_de_creation'],1,0,'C',1);
$pdf->Cell(30.5,5, $row['nomProvince'],1,0,'C',1);
$pdf->Cell(65,5, $row['adresse'],1,0,'C',1);
$pdf->Cell(30.5,5, $row['nomPresident'],1,0,'C',1);
$pdf->Cell(30.5,5, $row['telegsm'],1,0,'C',1);
$pdf->Cell(30.5,5, $row['email'],1,0,'C',1);
$pdf->Cell(30.5,5, $row['nomThem'],1,0,'C',1);

}*/

//footer





//Afficher le pdf
$pdf->Output();
?>



