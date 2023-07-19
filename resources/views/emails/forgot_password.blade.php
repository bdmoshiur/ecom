<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table>
   <tr>
      <td>Dear {{ $name }}</td>
   </tr>
   <tr>
       <td>You have requested to recover your password. New password is as below</td>
   </tr>
   <tr>
    <td>Password: {{ $password }}</td>
   </tr>
    <tr>
    <td>&nbsp;</td>
   </tr>
   <tr>
    <td>Thanks & Regards</td>
   </tr>
   <tr>
    <td>e-commerce website</td>
   </tr>
</table>
</body>
</html>
