<!DOCTYPE html>
<html>
<head>
<style type="text/css">
.box-model-ajax{
	display: block;
    position:fixed;
    height:auto;
    bottom:50%;
    top:25%;
    left:30%;
    right:30%;
    background-color: #F2F2FC;
    border:2px solid  #A1A1AF;
}
img {
	top:35%;
	position: fixed;
    display: block;
    margin-left:19%;
}
.wa{
	color:red;
	font-size:18px;
	text-align: center;
}
.tle{
	font-size:18px;
	color:red;
	text-align: center;
}
.ac{
	font-size:18px;
	color:green;
	text-align: center;
}
.rte{
	font-size:18px;
	color:red;
	text-align: center;
}
.ce{
	font-size:18px;
	color:red;
	text-align: center;

}
.text-result{
	position:fixed;
	top:28%;
	left:30%;
	right:30%;
}
</style>
</head>
<div class="box-model-ajax">
<?php
include "conn_db.php";
ob_start();
session_start();
$client = new SoapClient( "http://ideone.com/api/1/service.wsdl" );
// checing the list of languages supported and their lang ID's
//$result=$client->getLanguages($username,$password);
//print_r($result);
$user="chandan11111";
$pass="chandan";
$run=true;
$private=true;
$user_id=-1;

$user_id=$_SESSION['sess_user_id'];

//echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
//echo $user_id;
//$code = $_POST['code'];
$code = stripcslashes($_POST['code']);
//$code=str_replace("&lt;",'<',$code);
//$code=str_replace("&gt;",'>',$code);
//$code=str_replace("<br>",'\n',$code);

echo "<br><br><br><br><br><br><br><br><br><br>";
//$code = htmlspecialchars($code);
$code=str_replace("<br>","",$code);
$code=str_replace('\n',"",$code);
//echo "<textarea rows='50' cols='120'>".$code."</textarea>";
$lang = stripcslashes($_POST['lang']);
$lang=str_replace(" ","",$lang);

$problem_code=($_POST['problem_code']);
$problem_code=str_replace(" ","",$problem_code);

//echo "<textarea rows='50' cols='120'>".$problem_code."</textarea>";
$getInput=mysqli_query($con,"SELECT * FROM judge_problem WHERE problem_code='$problem_code'") or die(mysqli_error($con));
$row=mysqli_fetch_array($getInput);
//echo $getInput->num_rows; 
$input=$row['test_case_input'];
//echo $input;
$contest_code=$row['contest_code'];
$problem_id=$row['problem_id'];
$output=$row['test_case_output'];
$time_limit=$row['time_limit'];
$getcontestcode=mysqli_query($con,"SELECT * FROM judge_contest WHERE contest_code='$contest_code'") or die(mysqli_error($con));
$row=mysqli_fetch_array($getcontestcode);
$contest_id=$row['contest_id'];
$result = $client->createSubmission( $user, $pass, $code, $lang, $input, $run, $private );
//if submission is complaitation free
while(1){
if ( $result['error'] == 'OK' )
{
    $status = $client->getSubmissionStatus( $user, $pass, $result['link'] );
    //echo $result['link'];
    if ($status['error'] == 'OK' )
    {
        //check if the status is 0, otherwise getSubmissionStatus again
        while ( $status['status'] != 0 ) {
            sleep( 3 ); //sleep 3 seconds
            $status = $client->getSubmissionStatus( $user, $pass, $result['link'] );
        }
        //finally get the submission results
        $details = $client->getSubmissionDetails( $user, $pass, $result['link'], true, true, true, true, true );
        if ( $details['error'] == 'OK' ) 
       	{
       		//no error is there now checking status of getsubmissiondetails 
       
       		//1.) <0 waiting for compilation
			//2.) 0 program has finished
			//3.) 1 compilation
			//4.) running
       		
			while($details['status']!=0)
			{
				$compiling=1;
				sleep(2);
				// run whle waiting for complaitaion ,run and excecuted
			}
			if($details['status']==0)
			{
				if($details['result']==0)
				{
					var_dump($details);
					echo "Error :not running – the submission has been created with run parameter set to false";
					break;
				}
				else
				{
					if($details['result']==11)
					{
						//var_dump($details);
						//compilataion error
						// insert into DB
						$date=$details['date'];
						$time=-1;
						$out="-1";
						$res="CE";
						$memory=$details['memory'];
						$langName=$details['langName'];
						mysqli_query($con,"INSERT INTO judge_submission (user_id,contest_id,problem_id,result,time_taken,memory_taken,source_code,language,time_of_submission) 
						VALUES ('$user_id','$contest_id','$problem_id','$res','$time','$memory','$code','$langName','$date')") or die(mysqli_error($con));
						
						echo '<div class="ce">';
						echo '<div class="text-result">';
						echo "<b>Compilation Error</b><br>";
						echo "</div>";
						echo "</div>";
						echo '<img src="/codejudge/ce-icon.gif">';
						break;
					}
					else if($details['result']==13)
					{
						//var_dump($details);
						//time limit exceed
						$res="TLE";
						mysqli_query($con,"INSERT INTO judge_submission (user_id,contest_id,problem_id,result,time_taken,memory_taken,source_code,language,time_of_submission) 
						VALUES ('$user_id','$contest_id','$problem_id','$res','$time','$memory','$code','$langName','$date')") or die(mysqli_error($con));
						
						echo '<div class="tle">';
						echo '<div class="text-result">';
						
						echo "<b>Time Limit Exceed</b><br>";		
						echo "</div>";
						echo "</div>";
						
						echo '<img src="/codejudge/tle-icon.png">';	
						break;
					}
					else if($details['result']==15)
					{
						//success ful submission check output
						$date=$details['date'];
						$time=$details['time'];
						$out=$details['output'];
						$memory=$details['memory'];
						$langName=$details['langName'];
						
						//$out=str_replace('\n','',$out);
						//$out=str_replace(' ','',$out);
						//var_dump($details);
						//str_replace(" ","$",$out);
						//str_replace(" ","$",$output);
						//echo strlen($output);
						//echo " ";
						//echo strlen($out);
						if (strcmp($out,$output)==0)
						{
							if($time<=$time_limit){
							$res="AC";
							mysqli_query($con,"INSERT INTO judge_submission (user_id,contest_id,problem_id,result,time_taken,memory_taken,source_code,language,time_of_submission) 
						VALUES ('$user_id','$contest_id','$problem_id','$res','$time','$memory','$code','$langName','$date')") or die(mysqli_error($con));
						
							echo '<div class="ac">';
							echo '<div class="text-result">';
					
							echo "<b>Accepted</b><br>";
							echo "Time : ".$time." "."Sec";
							echo "</div>";
							
							echo "</div>";
							echo '<img src="/codejudge/ac-icon.gif">';
							}
							else
							{
								$res="TLE";
								mysqli_query($con,"INSERT INTO judge_submission (user_id,contest_id,problem_id,result,time_taken,memory_taken,source_code,language,time_of_submission) 
						VALUES ('$user_id','$contest_id','$problem_id','$res','$time','$memory','$code','$langName','$date')") or die(mysqli_error($con));
						
								echo '<div class="tle">';
								echo '<div class="text-result">';
						
								echo "<b>Time Limit Exceed</b><br>";		
								echo "</div>";
								echo "</div>";
								echo '<img src="/codejudge/tle-icon.png">';	
							}
							
						}
						else
						{
							$res="WA";
							mysqli_query($con,"INSERT INTO judge_submission (user_id,contest_id,problem_id,result,time_taken,memory_taken,source_code,language,time_of_submission) 
						VALUES ('$user_id','$contest_id','$problem_id','$res','$time','$memory','$code','$langName','$date')") or die(mysqli_error($con));
						
							echo '<div class="wa">';
							echo '<div class="text-result">';
							
							echo "<b>Wrong Answer</b><br>";
							echo "</div>";
							echo "</div>";
							echo '<img src="/codejudge/wa-icon.gif">';		
						}
						break;
					}
					else
					{
						//run time error includes memory error bus error etc
						$date=$details['date'];
						$time=$details['time'];
						$out=$details['output'];
						$memory=$details['memory'];
						$langName=$details['langName'];
						$res="RTE";
						mysqli_query($con,"INSERT INTO judge_submission (user_id,contest_id,problem_id,result,time_taken,memory_taken,source_code,language,time_of_submission) 
						VALUES ('$user_id','$contest_id','$problem_id','$res','$time','$memory','$code','$langName','$date')") or die(mysqli_error($con));
						
						echo '<div class="rte">';
						echo '<div class="text-result">';
						
						echo "<b>Runtime Error</b><br>";
						echo "</div>";
						echo "</div>";
						echo '<img src="/codejudge/rte-icon.png">';
						//var_dump($details);
						break;
					}
				}
			}
            //var_dump( $details );
        } 
        else {
        	echo "IDEONE SERVER ERROR";
            //we got some error
            //var_dump( $details );
            break;
        }
    }
    else {
    	echo "IDEONE SERVER ERROR";
        //we got some error
        //var_dump( $status );
        break;
    }
} 
else {
 	echo "IDEONE SERVER ERROR";
    //we got some error
    //var_dump( $result );
    break;
}
}

?>
</div>
</div>
</html>
