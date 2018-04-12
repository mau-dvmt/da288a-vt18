# Mikrowebbtjänster & Lumen

- [Föreläsningsslides](php-lumen.pdf)

Här är dagens (fungerande) kod:

## web.php
```php
<?php

use App\Http\Controllers\MoviesController;

$router->get('/', function () {
    return "Hello World!";
});

$router->get('/movies', 'MoviesController@index');
$router->get('/movies/{id}', 'MoviesController@show');
$router->post('/movies', 'MoviesController@create');
```

## MoviesController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MoviesController extends Controller
{
    public $movies;

    public function __construct()
    {
        $this->movies = json_decode(file_get_contents("../resources/movies.json"));
    }

    public function index()
    {
        return response()->json($this->movies);
    }

    public function show($id)
    {
        foreach($this->movies as $movie) {
            if($movie->id == $id) {
                return response()->json($movie);
            }
        }    
    }

    public function create(Request $request)
    {
        $movie = [];
        $movie['title'] = $request->input("title");
        $movie['id'] = $request->input("id");
        $movie['grade'] = $request->input("grade");

        $movies = $this->movies;
        $movies[] = $movie;

        file_put_contents("../resources/movies.json", json_encode($movies));

        return response()->json($movies);
    }
}
```

## movies.json
```json
[
    {"id":1,"title":"Star Wars","grade":5},
    {"id":2,"title":"Titanic","grade":4},
    {"id":3,"title":"Inception","grade":4},
    {"title":"American Beauty","id":"4","grade":"4"}
]
```