<?php

return [
  'driver' =>'sendmail',
  'host' =>'smtp.sendgrid.net',
  'port' =>587,
  'from' => ['address' => 'roshansingh9450@gmail.com' , 'name' => 'Legalease' ],
  'encryption' =>'tls',
  'username' =>'roshansingh9450',
  'password' =>'tabmindsingh9',
  'sendmail' => '/usr/sbin/sendmail -bs',
  'pretend' => false,

];
