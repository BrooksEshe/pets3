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

$f3->set('colors', array('pink', 'green', 'blue'));

//Turn of fat free error reporting
$f3->set('DEBUG', 3);

//require validation
require_once('model/validation-functions.php');

//Define a default route
$f3->route('GET /', function() {
    echo "<h1>My Pets</h1><br>";
    echo "<a href='order'>Order a Pet</a>";
});

$f3->route('GET|POST /order', function($f3) {
    $_SESSION = array();
    if(isset($_POST['animal'])){
        $animal = $_POST['animal'];
        if(validString($animal)){
            $_SESSION['animal'] = $animal;
            $f3 -> reroute('/order2');
        }else{
            $f3->set("errors['animal']", "Please enter an animal.");
        }
    }
    $template = new Template();
    echo $template->render('views/form1.html');
});

$f3->route('POST|GET /order2', function($f3) {
    $color = $_POST['color'];
    if(isset($_POST['color'])){
        if(validColor($color)){
            $_SESSION['color'] = $color;
            $f3 -> reroute('/results');
        }else{
            $f3->set("errors['color']", "Please enter an color.");
        }
    }
    $template = new Template();
    echo $template->render('views/form2.html');
});

$f3->route('POST|GET /results', function() {
    print_r($_SESSION);
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
