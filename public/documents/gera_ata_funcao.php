<?php

if(isset($_POST['nome'])){
    $html = "<div>Olá {$_POST['nome']}, como vai?</div>";
    echo $html;
}

