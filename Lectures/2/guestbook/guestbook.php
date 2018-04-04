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