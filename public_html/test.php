<!DOCTYPE html> 
<html> 
    <head> 
        <title>Tytuł strony</title> 
    </head> 
    <body>   
        <h1>Nagłówek</h1>
        <p>przykładowy tekst</p>   
        <a href="http://www.google.pl">odsyłacz do google.pl </a> 
    </body> 
</html>  

<?php

class TEST {

    private $zmienna1 = 10;
    public $zmienna2 = 5;
    private $zmienna3 = 0;

    public function __construct() {
        $zmienna3 = $zmienna1 + $zmienna2;
    }

    public function getZmienna() {
        Return $zminna3;
    }

}

$object = new TEST();
//tworzymy obiekt klasy TEST w tym momencie wykonuje
// się też metoda __construct(); w której dodają się 
// zmienna1 i zmienna2 przypisując ich sumę zmiennej3

echo $object->zmienna1; // wyświetli się komunikat 
//z błędem o braku dostępu do tej zmiennej  
echo $object->zmienna2; // wyświetli się napis 5  
echo $object->getZmienna(); // używając metody 
//w ten sposób można się odwołać do prywatnej zmiennej, 
//dzięki czemu mamy do niej dostęp, ale tylko jeśli 
//programista udostępni do tego metodę.
