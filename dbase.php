<?php
   $host        = "host = ec2-54-217-234-157.eu-west-1.compute.amazonaws.com";
   $port        = "port = 5432";
   $dbname      = "dbname = dav5nd421ipu74";
   $credentials = "user = lfpegwcrzqkfgp password=52bc85c5bec01bb9563d98e20dcad713319986829d6321939892fe4f3787227c";

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db) {
      echo "Error : Unable to open database\n";
   } else {
    global $db;
  
   }



?>