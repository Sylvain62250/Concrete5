<?php
    $view->inc('elements/header.php');
    $Contenu = new Area('Contenu');
    $Contenu->display($c); 
    $view->inc('elements/footer.php');
?>