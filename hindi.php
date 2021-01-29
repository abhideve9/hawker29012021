<?php

$message2 =[                     
		        
		        'H1'=>'आज की कुल कॉल्स',         
		        'E1'=>"Today's Total Calls",             
		                      
		        'H2'=>'आज की कुल  Adv क्लिकस ',   
		        'E2'=>"Total Adv click today",  
	               
		        'H3'=>'आपके बिज़नेस वर्ग को आज सर्च किया गया',   
		        'E3'=>'No. of times your business category searched today',  
		        
		    
];

echo json_encode(array('status'=>1,'data'=>$message2));exit;

?>