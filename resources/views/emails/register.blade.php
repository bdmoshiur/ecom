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
       <td>Welcome to our e-commerce website. your account is activated and details are as below</td>
   </tr>
   <tr>
      <td>&nbsp;</td>
   </tr>
   <tr>
    <td>Name: {{$name}}</td>
   </tr>
   <tr>
    <td>&nbsp;</td>
   </tr>
   <tr>
    <td>Email: {{$email}}</td>
   </tr>
   <tr>
    <td>&nbsp;</td>
   </tr>
   <tr>
    <td>Mobile: {{$mobile}}</td>
   </tr>
   <tr>
    <td>&nbsp;</td>
   </tr>
   <tr>
    <td>Password: ******** (as chooses by you)</td>
   </tr>
   <tr>
    <td>Thanks & Regards/td>
   </tr>
   <tr>
    <td>e-commerce website/td>
   </tr>
</table>
</body>
</html>
