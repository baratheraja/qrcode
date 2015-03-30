<?php    

    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    $PNG_WEB_DIR = 'temp/';

    include "qrlib.php";
    include "MPDF57/mpdf.php";  
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';

    $errorCorrectionLevel = 'L';

   $matrixPointSize =3;

	
	if(isset($_REQUEST['data']))
		$data=$_REQUEST['data'];
       
          if(isset($_REQUEST['end']))
		$dataend=$_REQUEST['end'];
       if(isset($_REQUEST['data']) && isset($_REQUEST['end']))
            {
        $qr=substr($data, -6);
	$qrend=substr($dataend, -6);
	$html='<table width="100%">';	
	for($i=$qr;$i<=$qrend;$i++)	
	{	$html=$html."<tr>";
		$data="KQ".$i;
		$filename = $PNG_TEMP_DIR.'test'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';				
		if(!file_exists ( $filename ))		
			QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);				
		for($j=1;$j<=10 ;$j++){
		$html=$html."<td>";   
		$html=$html.'<img src="'.$PNG_WEB_DIR.basename($filename).'" /><center>'.$data.'</center></td>';		
		}		
		$html=$html."</tr>";
	} 
	$html=$html."</table>";
	$mpdf=new mPDF('utf-8','A3',7,'digital-7',5,5,5,5,0,0);
	$mpdf->WriteHTML($html);
	$mpdf->Output('mpdf.pdf','I');

		
	//echo $html;

}
//display generated file
      
    
    //config form
    echo '<form action="index.php" method="post">
        Start qr:&nbsp;<input name="data" value="'.(isset($_REQUEST['data'])?htmlspecialchars($_REQUEST['data']):'').'" />&nbsp;
        End qr:&nbsp;<input name="end" value="'.(isset($_REQUEST['end'])?htmlspecialchars($_REQUEST['end']):'').'"/>
        &nbsp;';
        
    //for($i=1;$i<=10;$i++)
      //  echo '<option value="'.$i.'"'.(($matrixPointSize==$i)?' selected':'').'>'.$i.'</option>';
        
    echo '
        <input type="submit" value="GENERATE"></form><hr/>';
        
    // benchmark
    //QRtools::timeBenchmark();    

    
