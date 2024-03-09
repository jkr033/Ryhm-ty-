<?php

    ini_set('display_errors',  '1');
    ini_set('display_startup_errors',  '1');
    error_reporting(E_ALL);

function saveDataToJson($data) {
        $json_data = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents('asiakasdata.json', $json_data);
    }

$json = file_get_contents('asiakasdata.json');
$json_data = json_decode($json,true);
if ($json_data === null) {
    echo "Virhe JSONia";
    exit;
}
//Asiakkaan lisäys
 if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_customer'])) {
        $new_person = array(
            'id' => uniqid(), 
            'first_name' => $_POST['etunimi'],
            'last_name' => $_POST['sukunimi'],
            'email' => $_POST['email'],
            'phone' => $_POST['puhelin'],
            'city' => $_POST['kaupunki'],
            'country' => $_POST['maa'],
            'address' => $_POST['osoite'],
            //'gender' => $_POST['gender'],
            //'ip_address' => $_POST['ip_address'],
            //'car' => $_POST['car'],
            //'hash' => $_POST['hash']
        );
        $json_data[] = $new_person;
        saveDataToJson($json_data);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    }

$data = array();

foreach ($json_data as $record) {
    $person = array(
'id' => $record['id'],
'etunimi'=> $record['etunimi'],
'sukunimi' => $record['sukunimi'],
'email' => $record['email'],
'puhelin' => $record['puhelin'],
'kaupunki' => $record['kaupunki'],
'maa' => $record['maa'],
'osoite' => $record['osoite'],
//'gender' => $record['gender'],
//'ip_address' => $record['ip_address'],
//'car' => $record['car'],
//'hash' => $record['hash'],
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
         <th>Phone</th>
         <th>City</th>
         <th>Country</th>
         <th>Address</th>
        <!-- <th>Gender</th>
         <th>IP Address</th>
         <th>Car</th>
         <th>Hash</th> -->
 </tr>

    <?php foreach ($data as $person): ?>
        <tr>
            <td><?php echo $person['id']; ?></td>
            <td><?php echo $person['etunimi']; ?></td>
            <td><?php echo $person['sukunimi']; ?></td>
            <td><?php echo $person['email']; ?></td>
            <td><?php echo $person['puhelin']; ?></td>
            <td><?php echo $person['kaupunki']; ?></td>
            <td><?php echo $person['maa']; ?></td>
            <td><?php echo $person['osoite']; ?></td>
    </tr>
<?php endforeach; ?>
    </table>
    </body>
    </html>