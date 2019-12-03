<?php
require_once('vendor/autoload.php'); 
use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
 
$spreadsheet = new Spreadsheet(); 
$sheet = $spreadsheet->getActiveSheet(); 

include("db.php");
$query="select * from user";
$sql=mysqli_query($con,$query);
$data[]=array("User id","User name","User email","User Password");//Column Name
while($row=mysqli_fetch_assoc($sql))
{
	array_push($data,array("id"=>$row['id'],
	             "name"=>$row['name'],
				 "email"=>$row['email'],
				 "pass"=>$row['pass']
				 )
			   );
}

$cell=["A","B","C","D"];
$count=1;
foreach($data as $keys)
{
	$temp=array();
	foreach($keys as $values)
	{
		array_push($temp,$values);
	}
    for($i=0; $i<sizeof($temp); $i++)
	{
	
	$sheet->setCellValue($cell[$i]."$count", $temp[$i]);
	
	//Border
	$spreadsheet->getActiveSheet()->getStyle($cell[$i]."$count")
		->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
	$spreadsheet->getActiveSheet()->getStyle($cell[$i]."$count")
		->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
	$spreadsheet->getActiveSheet()->getStyle($cell[$i]."$count")
		->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
	$spreadsheet->getActiveSheet()->getStyle($cell[$i]."$count")
		->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		
	}
	$count++;
}

$writer = new Xlsx($spreadsheet); 
$title="myexcel.xls";
$writer->save($title);

?>