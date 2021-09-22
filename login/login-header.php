<?php 

ob_start();
session_start();

include '../tkpan/database/baglan.php';
date_default_timezone_set('Europe/Istanbul');


if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
  header("Location:giris.php"); 
  exit();
}

$korunan1 = $_SERVER['REQUEST_URI'];
$korunan2 = $_SERVER['SERVER_NAME'];

$hedefler = array('chr(', 'chr=', 'chr%20', '%20chr', 'wget%20', '%20wget', 'wget(',
  'cmd=', '%20cmd', 'cmd%20', 'rush=', '%20rush', 'rush%20',
  'union%20', '%20union', 'union(', 'union=', 'echr(', '%20echr', 'echr%20', 'echr=',
  'esystem(', 'esystem%20', 'cp%20', '%20cp', 'cp(', 'mdir%20', '%20mdir', 'mdir(',
  'mcd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', '%20rm',
  'mcd(', 'mrd(', 'rm(', 'mcd=', 'mrd=', 'mv%20', 'rmdir%20', 'mv(', 'rmdir(',
  'chmod(', 'chmod%20', '%20chmod', 'chmod(', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', 'chgrp(',
  'locate%20', 'grep%20', 'locate(', 'grep(', 'diff%20', 'kill%20', 'kill(', 'killall',
  'passwd%20', '%20passwd', 'passwd(', 'telnet%20', 'vi(', 'vi%20',
  'insert%20into', 'select%20', 'nigga(', '%20nigga', 'nigga%20', 'fopen', 'fwrite', '%20like', 'like%20',
  '$_request', '$_get', '$request', '$get', '.system', 'HTTP_PHP', '&aim', '%20getenv', 'getenv%20',
  'new_password', '&icq','/etc/password','/etc/shadow', '/etc/groups', '/etc/gshadow',
  'HTTP_USER_AGENT', 'HTTP_HOST', '/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id',
  '/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+', 'bin/python',
  'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', '/usr/X11R6/bin/xterm', 'lsof%20',
  '/bin/mail', '.conf', 'motd%20', 'HTTP/1.', '.inc.php', 'config.php', 'cgi-', '.eml',
  'file\://', 'window.open', '<SCRIPT>', 'javascript\://','img src', 'img%20src','.jsp','ftp.exe',
  'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd',
  'servlet', '/etc/passwd', 'wwwacl', '~root', '~ftp', '.js', '.jsp', 'admin_', '.history',
  'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20', 'halt%20',
  'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con',
  '<script', '/robot.txt' ,'/perl' ,'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from',
  'select from', 'drop%20', '.system', 'getenv', 'http_', '_php', 'php_', 'phpinfo()', '<?php', '?>', 'sql=', '.htaccess','AspxSpy','CyberSpy5','EFSO.ASP','R57Shell.PHP','C99Shell.PHP','.cookie%2b','%2bdocument','DATE_LOCAL','.cookie+','/Image()','wp-config.php','sitemap.xml');

$yakala1 = str_replace($hedefler, '*', $korunan1);
$yakala2 = str_replace($hedefler, '*', $korunan2);

if ($korunan1 != $yakala1) {
	header("Location:https://goo.gl/ma3X2h");
}elseif  ($korunan2 != $yakala2){
  header("Location:https://goo.gl/ma3X2h");
}

if (isset($_SESSION['uye_code'])) {
	header("Location:../index.php");
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>


  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">	
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>İNSAN KAYNAKLARI YÖNETİMİ</title>	



  <meta name="theme-color" content="#187cb1">

  <meta name="msapplication-navbutton-color" content="#187cb1">

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="#187cb1">

  <link rel="shortcut icon" href="../yimg/favicon.png" type="image/x-icon" />
  <link rel="apple-touch-icon" href="../yimg/favicon.png">


  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">



  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/login.css">

  


</head>

<body>


