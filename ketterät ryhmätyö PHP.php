<?php

    ini_set('display_errors',  '1');
    ini_set('display_startup_errors',  '1');
    error_reporting(E_ALL);


$json = file_get_contents('ryhmätyö.json');
$json_data = json_decode($json,true);
if ($json_data === null) {
    echo "Virhe JSONia";
    exit;
}

$data = array();

foreach ($json_data as $record) {
    $person = array(
'id' => $record['id'],
'first_name'=> $record['first_name'],
'last_name' => $record['last_name'],
'email' => $record['email'],
'gender' => $record['gender'],
'ip_address' => $record['ip_address'],
'car' => $record['car'],
'hash' => $record['hash'],
    );

$data[] = $person;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ryhmätyö</title>
 <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
    
</head>
<body>
<h1>Asiakaslista</h1>
 
<form id="form">
    <input type="search" id="query" name="q"
    placeholder="...">
    <button>Etsi</button>
</form>
<table>
     <tr>
         <th>Id</th>
         <th>First Name</th>
         <th>Last Name</th>
         <th>Email</th>
         <th>Gender</th>
         <th>IP Address</th>
         <th>Car</th>
         <th>Hash</th>
 </tr>

    <?php foreach ($data as $person): ?>
        <tr>
            <td><?php echo $person['id']; ?></td>
            <td><?php echo $person['first_name']; ?></td>
            <td><?php echo $person['last_name']; ?></td>
            <td><?php echo $person['email']; ?></td>
            <td><?php echo $person['gender']; ?></td>
            <td><?php echo $person['ip_address']; ?></td>
            <td><?php echo $person['car']; ?></td>
            <td><?php echo $person['hash']; ?></td>
    </tr>
<?php endforeach; ?>
    </table>
    </body>
    </html>



