# Introduktion till PHP

- [Introduktion till PHP](intro-php.pdf)
- [Composer-presentation](composer.pdf)

## Dagens exempel - Gästbok

### index.php

```php
<?php
require("guestbook.php");

use App\Guestbook;

$guestbook = new Guestbook("db.json");

if (isset($_POST["name"]) and isset($_POST["message"])) {
    // Data is sent from the form
    $guestbook->storePost($_POST["name"], $_POST["message"]);
}

?>

<!doctype html>
<html>
<head>
    <title>Gästbok</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Min fina gästbok</h1>
        <form action="index.php" method="post">
            <fieldset>
                <legend>Nytt inlägg</legend>
                <div class="form-group">
                    <label for="name">Namn: </label>
                    <input type="text" id="name" name="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="message">Meddelande: </label>
                    <textarea name="message" id="message" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" value="Spara inlägg" class="btn btn-success">
                </div>
            </fieldset>
        </form>

        <h2>Tidigare inlägg</h2>
        <?php
            foreach ($guestbook->getPosts() as $post) {
                echo Guestbook::generatePostHTML($post->name, $post->message, $post->timestamp);
            }
        ?>

    </div>
</body>
</html>

```

### guestbook.php

```php
<?php

namespace App;

class Guestbook
{
    private $filename;

    public function __construct($filename) {
        $this->filename = $filename;

        if (file_get_contents($this->filename) === false) {
            file_put_contents($this->filename, json_encode([]));
        }
    }

    public function storePost($name, $message) {
        $posts = $this->getPosts();
        $posts[] = [
            "name" => $name,
            "message" => $message,
            "timestamp" => date("Y-m-d H:i:s")
        ];

        file_put_contents($this->filename, json_encode($posts));
    }

    function getPosts() {
        $fileContent = file_get_contents($this->filename);
        $posts = json_decode($fileContent);
        
        return $posts;
    }

    static public function generatePostHTML($name, $message, $timestamp)
    {
        return "<div class=\"panel panel-default\">
                  <div class=\"panel-heading\">
                    <h3 class=\"panel-title\">$name <span style=\"float:right;\">$timestamp</span></h3>
                  </div>
                  <div class=\"panel-body\">
                    $message
                  </div>
                </div>";
    } 
}
```
