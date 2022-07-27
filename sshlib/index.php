<?php
 try{   
    set_time_limit(0);
    ini_set('mysql.connect_timeout','0');   
    ini_set('max_execution_time', '0'); 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include_once('Net/SSH2.php');
    /*$host = 'sftp.secure-booker.com';
    $username ='SkinLaundryDubai';
    $password ='hPA`8J8\xvFy'; 
    $command = 'php version';*/

    $host = '159.89.173.96';
    $username ='root';
    $password ='rgyan@123'; 
    $command = 'php version';

    $startTime = microtime(true); 

    $sftp = new Net_SSH2($host);
    if (!$sftp->login($username,$password)) {
        echo ('Login Failed');
        echo '-------------------------------';
        $endTime = microtime(true);
        $diff = round($endTime - $startTime);
        $minutes = floor($diff / 60); //only minutes
        $seconds = $diff % 60;//remaining seconds, using modulo operator
        echo "script execution time: minutes:$minutes, seconds:$seconds"; //value in seconds
    }else{
        echo ('<strong>Login Success</strong>');
        echo '-------------------------------';
        echo '<br/>';
        echo '<pre>';
        echo $sftp->exec('pwd');
        echo $sftp->exec('ls -la');
        die('testing');
          
    }
   
}catch(Throwable $e){
    print_r($e->getMessage());

}

