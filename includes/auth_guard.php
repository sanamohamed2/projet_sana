<?php
 if ( session_status () !== PHP_SESSION_ACTIVE ) {
 session_start () ;
 }

 if (! isset ( $_SESSION [ " ine " ]) ) {
 header ( " Location : connexion . php " ) ;
 exit ;
 }
 ?>