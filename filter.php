<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>code_db</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="header">
        <h1>
            <p>code_db filtered</p>
        </h1>
    </div>
    <div id="navi">
        <p><a href="index.php">Start</p></a>
        <p><a href="input.html">Input</a></p>
        <p><a href="login.html">Login</a></p>
        <p><input type="text" name="search" id="searchbutton" placeholder="Search"></p>
        <input type="submit" name="searchbutton" id="" value=" go ">
    </div>

  
    <?php
        $servername = "localhost";
        $dbname = "code_db";
        $tablename = "snippets";
        $username = "root";
        $today = date("y/m/d");
        //$loc = count(explode("\n",$code));
        $filter = $_GET["langfilter"];
     
        try {
            //init db connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully =)";
            //echo "\n";

        } catch(PDOException $e) {
            echo "Connection failed =( " . $e->getMessage();
        }

        echo "<table style='border: solid 1px;'>";
        echo "<tr><th>ID</th><th>Language</th><th>Name</th><th>Code</th><th>Description</th><th>Tags</th><th>LoC</th><th>Date of Creation</th></tr>";
        echo "<td>0</td>";
        echo "<td><form action='filter.php' method='GET' id='input'>
        <select name='langfilter' id='langfilter' style='float: left'>
        <option value='none'>Filter</option>
        <option value='Java'>Java</option>
        <option value='Python'>Python</option>
        <option value='HTML'>HTML</option>
        <option value='CSS'>CSS</option>
        <option value='PHP'>PHP</option>
        <option value='JavaScript'>JavaScript</option>
        </select>
        <input type='submit' value='go'></form></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        echo "<td></td>";
        

        class TableRows extends RecursiveIteratorIterator{
            function __construct($it){
                parent::__construct($it, self::LEAVES_ONLY);
            }

            function current(){
                return "<td style='border:1px solid;'>". parent::current()."</td>";
            }

            function beginChildren(){
                echo "<tr>";
            }

            function endChildren(){
                echo "</tr>"."\n";
            }
        }

        try {
        $select = $conn->prepare("SELECT * From snippets WHERE language = '$filter'");
        $select->execute();

        $result = $select->setFetchMode(PDO::FETCH_ASSOC);
        foreach(new TableRows(new RecursiveArrayIterator($select->fetchAll())) as $k=>$v) {
            echo $v;
        }
        } catch (PDOException $e){
        echo "Error: " . $e->getMessage();
        }

        $conn = null;
        echo "</table>";


?>



</body>
    
</html>