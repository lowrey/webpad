<?php 
// Root URL of where the script is being run at
function get_root_url()
{
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    preg_match('#(http://)(.+/)(.+)#', $url, $m);
    // if the path ends in an extention, go up to the base
    if(strpos(end($m), '.php') !== FALSE)
    {
        $m = array_slice($m,1,-1);
        $url = join("",$m);
    }
    return $url;
}

$URL = get_root_url();

// Subfolder to output user content
$FOLDER = "_tmp"; 

function sanitize_file_name($filename) {
    $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", ".");
    $filename = str_replace($special_chars, '', $filename);
    $filename = preg_replace('/[\s-]+/', '-', $filename);
    $filename = trim($filename, '.-_');
    return $filename;
}

function get_rand_letters($amnt)
{
    $seed = str_split('abcdefghijklmnopqrstuvwxyz');
                     #.'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    shuffle($seed);
    return join("", array_slice($seed,0,$amnt));
}

if (!isset($_GET["f"])) {
    // User has not specified a name, just get one and refresh
    $name = get_rand_letters(4);
    while (file_exists($FOLDER."/".$name) && strlen($name) < 10) {
        $name .=  get_rand_letters(1);
    }
    if (strlen($name) < 10) {
        #header("Location: ".$URL."/".$name);
        header("Location: ".$URL."?f=".$name);
    }
    die();
}

$name = sanitize_file_name($_GET["f"]);
$path = $FOLDER."/".$name;

if (isset($_POST["t"])) {
    // Update content of file
    file_put_contents($path, $_POST["t"]);
    die();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php print $name; ?></title>
    <link href="lib/normalize.css" rel="stylesheet" />
    <link href="styles.css" rel="stylesheet" />
    <link href="favicon.gif" rel="shortcut icon" />
</head>
<body>
    <div id="div">
        <textarea id="content" spellcheck="true">
            <?php 
            if (file_exists($path)) {
                print htmlspecialchars(file_get_contents($path));
            }?>
        </textarea>
    </div>
    <pre id="print"></pre>
    <script src="//code.jquery.com/jquery.min.js"></script>
    <script src="lib/jquery.textarea.js"></script>
    <script src="script.js"></script>
</body>
</html>
