<html>
 <head>
 <Title>Registration Form</Title>
 <style type="text/css">
 	body { background-color: #055186;
 	    color: #333; font-size: .85em; margin: 20; padding: 20;
 	    font-family: Helvetica, Sans-Serif;
 	}
 	h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
 	h1 { font-size: 2em; }
 	h2 { font-size: 1.75em; }
 	h3 { font-size: 1.2em; }
 	table { margin-top: 0.75em; }
 	th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
 	td { padding: 0.2em; border: 0 none; }
    input[type="text"] {
        padding: 8px;
        font-size: 14px;
        border: 1px solid #d7dbe8;
        border-radius: 4px;
        width: 100% !important;
        margin-bottom: 8px !important;
    }
    input[type="submit"] {
        background: #ffd200;
        border-radius: 100px;
        padding: 12px 16px 12px 16px !important;
        font-size: 12px !important;
        color: #055186 !important;
        outline: none !important;
        border: none !important;
        min-width: 150px !important;
        text-transform: uppercase;
        cursor: pointer;
        display: inline-block !important;
        text-align: center;
    }
    .container {
        width: 400px;
        position: absolute;
        background: #fff;
        border-radius: 8px;
        padding: 10px 30px 10px 30px;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
    }
 </style>
 </head>
 <body>
 <div class='container'>
    <h1>Register here!</h1>
    <p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
    <form method="post" action="index.php" enctype="multipart/form-data" >
        <table>
            <tr>
                <td>Name<br><input type="text" name="name" id="name"/></td><td>Job<br><input type="text" name="job" id="job"/></td>
            </tr>
            <tr>
                <td>Email<br><input type="text" name="email" id="email"/></td><td></td>
            </tr>
            <tr>
                <td colspan='2'><br><input type="submit" name="submit" value="Submit" /> &nbsp; <input type="submit" name="load_data" value="Load Data" /></td>
            </tr>
        </table>
    </form>
 </div>
 <?php
    $host = "cukildicodingserver.database.windows.net";
    $user = "cukil";
    $pass = "5y4uqiilh4M";
    $db = "cukildicodingsub1db";
    try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(Exception $e) {
        echo "Failed: " . $e;
    }
    if (isset($_POST['submit'])) {
        try {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $job = $_POST['job'];
            $date = date("Y-m-d");
            $sql_insert = "INSERT INTO Registration (name, email, job, date) 
                        VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $job);
            $stmt->bindValue(4, $date);
            $stmt->execute();
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
        echo "<h3>Your're registered!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM Registration";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
            if(count($registrants) > 0) {
                echo "<h2>People who are registered:</h2>";
                echo "<table>";
                echo "<tr><th>Name</th>";
                echo "<th>Email</th>";
                echo "<th>Job</th>";
                echo "<th>Date</th></tr>";
                foreach($registrants as $registrant) {
                    echo "<tr><td>".$registrant['name']."</td>";
                    echo "<td>".$registrant['email']."</td>";
                    echo "<td>".$registrant['job']."</td>";
                    echo "<td>".$registrant['date']."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>No one is currently registered.</h3>";
            }
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
    }
 ?>
 </body>
 </html>