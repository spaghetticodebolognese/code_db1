<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code DB</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="header">
        <h1>
            <p>input code snippet</p>
        </h1>
    </div>
    <div id="navi">
        <p><a href="index.php">Start</p></a>
        <p><a href="input.html">Input</a></p>
        <p><a href="login.html">Login</a></p>
        <p><input type="text" name="search" id="searchbutton" placeholder="Search"></p>
        <input type="submit" name="searchbutton" id="" value=" go ">
    </div>

    <p>
        <?php
            $servername = "localhost";
            $dbname = "code_db";
            $tablename = "snippets";
            $username = "root";
            $today = date("y/m/d");
            $lang = $_GET["lang"];
            $name = $_GET["name"];
            $code = '<textarea>'.$_GET["code"].'</textarea>';

        

            
            $descr = $_GET["descr"];
            $tags = $_GET["tags"];

            $loc = count(explode("\n",$code));    
            
            
            try {
                //init db connection
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Connected successfully =)";
                echo "\n";

                //prepare the insert statement
                $insert = $conn->prepare("INSERT INTO $tablename (language, name, code, description, tags, loc, created) VALUES ('$lang', '$name', '$code', '$descr', '$tags', '$loc', '$today')");
                
                try {
                    $insert->execute();
                    echo "Upload successfully =)";
                } catch(PDOException $e) {
                echo "Upload failed =(" . $e->getMessage();
                //echo "Error: " . print_r($insert->errorInfo(),true);
                }
            } catch(PDOException $e) {
                echo "Connection failed =( " . $e->getMessage();
            }
            
        echo "<table style='border: solid 1px;'>";
        echo "<tr><th>ID</th><th>Language</th><th>Name</th><th>Code</th><th>Description</th><th>Tags</th><th>LoC</th><th>Date of Creation</th></tr>";

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
            $select = $conn->prepare("SELECT * From snippets");
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

    
    
    </p>
</body>

</html>