<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<table>
   <tr>
      <td>Dear {{ $userDetails['name'] }}</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
       <td>Your exchange request for order no. {{ $exchangeDetails['order_id'] }}
        with e-commerce website is {{ $exchange_status }} </td>
   </tr>
   <tr>
      <td>&nbsp;</td>
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
