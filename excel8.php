<?php
require_once('vendor/autoload.php'); 
use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 
 
$spreadsheet = new Spreadsheet(); 
$sheet = $spreadsheet->getActiveSheet(); 

include("db.php");
$query="select * from user";
$sql=mysqli_query($con,$query);
$data[]=array("Id","Name","Email","Password");//Column Name
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
	}
	$count++;
}
//COLUMN DIMENSION , FONT SIZE

$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);

$spreadsheet->getActiveSheet()->getStyle("A1:D1")->getFont()->setBold(true);

$spreadsheet->getActiveSheet()->getStyle("A1:D1")->getFont()->setSize(12);

$spreadsheet->getActiveSheet()->mergeCells('C2:D2');

$spreadsheet->getActiveSheet()->insertNewRowBefore(3, 4); //start 3, no of rows-4

$writer = new Xlsx($spreadsheet); 
$title="myexcel.xls";
$writer->save($title);

?>