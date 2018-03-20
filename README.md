# pftp
This is a php ftp library that helps mostly to connect client with the server and be able to read and write files and folders remotely.

To be able to run this
First include this library to your existing project.

require 'pft.php'

# How to use it
To you use this you must make a call to this library like calling other classes.

$_server = '192.168.1.1.4'
$_user = 'root'
$_password = 'password'

$pftp = new pftp($_server,$_user,$_password);

# How to use it's methods 

There are plent of methods that you can use. e.g
creating a directory to the server

$pftp->mkdir('Test')

Changing directory

$pftp->chdir('Test');

Listing directory

$pftp->drl();
