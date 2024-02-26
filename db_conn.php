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
        <p><a href="index.html">Start</p></a>
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
            $code = $_GET["code"];
            $descr = $_GET["descr"];
            $tags = $_GET["tags"];
            $loc = 1337;    //TODO: count loc function
            
            try {
                //init db connection
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Connected successfully =)";
                echo "\n";

                //prepare the insert statement
                $insert = $conn->prepare("INSERT INTO $tablename (language, name, code, description, tags, loc, created) VALUES ('$lang', '$name', '$code', '$descr', '$tags', 161, '$today')");
                
                try {
                    $insert->execute();
                    echo "Upload successfully =)";
                } catch(PDOException $e) {
                echo "Upload failed =(" . $e->getMessage();
                echo "Error: " . print_r($insert->errorInfo(),true);
                }
            } catch(PDOException $e) {
                echo "Connection failed =( " . $e->getMessage();
            }


        ?>
        <br>
        <br>
        <p>Your Upload:</p>
        <p>Language: <?php echo $_GET["lang"];?></p>
        <p>Name: <?php echo $_GET["name"];?></p>
        <p>Tags: <?php echo $_GET["tags"];?></p>
        <p>Description: <?php echo $_GET["descr"];?></p>
        <p>Code: <?php echo $_GET["code"];?></p>
    
    </p>
</body>

</html>