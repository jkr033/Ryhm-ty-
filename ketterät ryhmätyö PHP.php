<?php
    ini_set('display_errors',  '1');
    ini_set('display_startup_errors',  '1');
    error_reporting(E_ALL);

function saveDataToJson($data) {
        $json_data = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents('ryhmätyö.json', $json_data);
    }

$json = file_get_contents('ryhmätyö.json');
$json_data = json_decode($json, true);
if ($json_data === null) {
    echo "Virhe";
    exit;
}
//Asiakkaan lisäys
 if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_customer'])) {
        $new_person = array(
            'id' => uniqid(), 
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'gender' => $_POST['gender'],
            'ip_address' => $_POST['ip_address'],
            'car' => $_POST['car'],
            'hash' => $_POST['hash']
        );
        $json_data[] = $new_person;
        saveDataToJson($json_data);
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    }

$data = $json_data;

$filtered_data = $data;
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['q']) && isset ($_GET['haku'])) {
    $search_query = $_GET['q']; 
    $search_field = $_GET['haku'];

    $filtered_data = array_filter($data, function ($person) use ($search_query, $search_field) {
        $search_field = strtolower($search_field);
        return stripos($person[$search_field], $search_query) !== false;
    });
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
 
<form id="form" method="GET"> 
    <input type="search" id="query" name="q" 
    placeholder="...">
    <select name="haku" id="haku">
        <option value="id">Id</option>
        <option value="first_name">First Name</option>
        <option value="last_name">Last Name</option>
        <option value="email">Email</option>
        <option value="gender">Gender</option>
        <option value="ip_address">IP Address</option>
        <option value="car">Car</option>
        <option value="hash">Hash</option>
    </select>
    <button type="submit">Etsi</button>
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


