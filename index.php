<?php
/**
 * Created by PhpStorm.
 * User: Brandon
 * Date: 1/9/2019
 * Time: 1:30 PM
 * Initiate fat free
 */

session_start();
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require fat-free
require_once('vendor/autoload.php');

//Create an instance of the Base class
$f3 = Base::instance();

//Turn of fat free error reporting
$f3->set('DEBUG', 3);

//Define a default route
$f3->route('GET /', function() {
    echo "<h1>My Pets</h1><br>";
    echo "<a href='order'>Order a Pet</a>";
});

$f3->route('GET /order', function() {
    $view = new View();
    echo $view->render('views/form1.html');
});

$f3->route('POST /order2', function() {
    $_SESSION['animal'] = $_POST['animal'];
    $view = new View();
    echo $view->render('views/form2.html');
});

$f3->route('POST /results', function() {
    $_SESSION['color'] = $_POST['color'];
    $color = $_SESSION['color'];
    $animal = $_SESSION['animal'];
    //echo "<h3>Thank you for ordering a $color $animal</h3>";
    $template = new Template();
    echo $template->render('views/results.html');
});

//Route for animal type
$f3->route('GET /@animal', function($f3, $params) {
    $validAnimals = ['chicken','dog','cat', 'cow', 'pig'];
    $animal = $params['animal'];
    if(!in_array($params['animal'], $validAnimals)){
        $f3 -> error(404);
    }else{
        switch($animal){
            case 'chicken':
                $sounds = "cluck!";break;
            case 'dog':
                $sounds = "woof!";break;
            case 'cow':
                $sounds = "moo!";break;
            case 'pig':
                $sounds = "oink!";break;
            case 'cat':
                $sounds = "meow!";
        }
        echo "<h3>The $animal says $sounds</h3>";
    }
});

//Run fat-free
$f3->run();
