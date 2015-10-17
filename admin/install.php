<?php
include('../include/functions.php');
include('../include/mysql.php');
include('../include/config.php');

$affstats = 'create table affstats (
	userID int(10),
	productID int(10),
	uniqueClicks int(20),
	rawClicks int(20),
	sales int(10),	
	salesPaid int(10)
)';

$comments = 'create table comments (
	id int(10) primary key auto_increment, 
	replyID int(10), 
	postedOn datetime, 
	postedBy varchar(30), 
	post text
)';

$downloads = 'create table downloads (
	id int(10),
	productID int(8),
	url varchar(256),
	name varchar(100)
)';

$news = 'create table newsletter (
	category varchar(20), 
	subject varchar(100),
	message text
)';

$notes = 'create table notes (
	id varchar(20),
	notes text
)'; 

$pageviews = 'create table pageviews ( 
	id	int(10) primary key auto_increment,
	page varchar(50),
	url varchar(100),
	uniqueViews	int(10),
	rawViews	int(10)
)';

$posts = 'create table posts (
	id int(10) primary key auto_increment, 
	subject varchar(100), 
	url varchar(100),
	tags varchar(256),
	postedBy varchar(30), 
	postedOn datetime, 
	post text, 
	live varchar(1)
)';

$products = 'create table products (
	id int(5) primary key auto_increment,
	itemName    varchar(128),   
	itemPrice   varchar(16),    
	itemNumber  varchar(128),               
	expires int(4),      
	upsellID int(5),       
	oto varchar(1),             
	otoName varchar(128),               
	otoPrice    varchar(16),                
	otoNumber   varchar(100),               
	affProgram  varchar(1),             
	affCenter varchar(1),
	salesPercent    int(3),             
	prelaunch   varchar(1),             
	prelaunchDate   datetime,               
	prelaunchPage   varchar(64),                
	folder  varchar(50),                
	image   varchar(50),                
	keywords    text,               
	description text, 
	download varchar(256),
	header varchar(64), 
	footer varchar(64),
	salespage varchar(64)
)';

$sales = 'create table sales( 
	id int(10) primary key auto_increment,
	productID int(5),
	transID varchar(50),
	itemName varchar(50),
	itemNumber varchar(50),
	amount varchar(20),
	payerEmail varchar(100), 
	contactEmail varchar(100),
	purchased datetime,
	firstName varchar(50),
	lastName varchar(50),
	paidTo varchar(100),
	affiliate varchar(5),
	status varchar(1),
	notes text,
	optout varchar(1),
	expires varchar(5)
)';

$memberpages = 'create table memberpages (
	id int(10) primary key auto_increment,
	url varchar(20),
	header varchar(30),
	footer varchar(30), 
	file varchar(30)
)';

$settings = 'create table settings (
	opt varchar(30),
	setting text
)';

$sysEmails = 'create table emails (
	productID int(5), 
	type varchar(50),
	subject varchar(100),
	message text 
)';

$users = 'create table users (
	id int(10) primary key auto_increment, 
	fname varchar(40),
	lname varchar(40),
	email varchar(100),
	paypal varchar(100),
	joinDate datetime, 
	username varchar(20),
	password varchar(20),
	sales varchar(5),
	optout varchar(1),
	status varchar(1)
)';


mysql_query($affstats, $conn) or print(mysql_error()).'<br />'; 
mysql_query($comments, $conn) or print(mysql_error()).'<br />';
mysql_query($downloads, $conn) or print(mysql_error()).'<br />'; 
mysql_query($news, $conn) or print(mysql_error()).'<br />';
mysql_query($memberpages, $conn) or print(mysql_error()).'<br />'; 
mysql_query($pageviews, $conn) or print(mysql_error()).'<br />'; 
mysql_query($products, $conn) or print(mysql_error()).'<br />'; 
mysql_query($posts, $conn) or print(mysql_error()).'<br />';
mysql_query($sales, $conn) or print(mysql_error()).'<br />';
mysql_query($sysEmails, $conn) or print(mysql_error()).'<br />'; 
mysql_query($settings, $conn) or print(mysql_error()).'<br />';
mysql_query($users, $conn) or print(mysql_error()).'<br />';


/* SMTP & Admin Settings */
$dbInsert = array(
'fromEmail' => $fromEmail, 
'fromName' => $fromName,
'smtpHost' => $smtpHost,
'smtpPass' => $smtpPass, 
'adminEmail' => $adminEmail,
'adminFrom' => $adminFrom, 
'paypalEmail' => $paypalEmail, 
'adminUser' => 'username',
'adminPass' => 'password',
'installDate' => date('Y-m-d'), 
'websiteName' => '',
'businessName' => '',
'websiteURL' => '',
'blogHeader' => '',
'blogFooter' => '',
'memHeader' => '',
'memFooter' => '',
'memAreaUpsell' => '',
'memAreaContent' => '',
'blogCustomContent' => '',
'memUpsellProductID' => '',
'memUpsellBackup' => '',
'memUpsellBackupID' => '',
'memUpsellFile' => '',
'memUpsellBackupFile' => '',
'sendDownloadEmailCopy' => '',
'sendDownloadEmailAddress' => ''
);

foreach($dbInsert as $opt => $setting)
{
    $sel = 'select opt from settings where opt="'.$opt.'"';
    $res = mysql_query($sel, $conn) or print(mysql_error()); 
    
    if(mysql_num_rows($res) == 0)
    {
        $ins = 'insert into settings (opt, setting) values ("'.$opt.'", "'.$setting.'")';
        mysql_query($ins, $conn) or print(mysql_error()); 
    }
}
?>
<h1>Install Sales Page Machine</h1>

<a href="./">Log in here</a>