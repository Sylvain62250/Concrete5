
    
<?php $view->inc('elements/header.php'); ?>    
        <div class="row"> 
            <div class="col-md-12 " id="slider">
                <?php
                    $a = new Area('Diapo');
                    $a->display($c);
                ?>
            </div>
        </div>

        <div class="row" id="article">
            <div class="col-md-4">
                <?php
                    $a = new Area('Col1');
                    $a->display($c);
                ?>                
            </div>
            <div class="col-md-4">
                <?php
                    $a = new Area('Col2');
                    $a->display($c);
                ?>
            </div>
            <div class="col-md-4 ">
                <?php
                    $a = new Area('Col3');
                    $a->display($c);
                ?>                
            </div>
         </div>

         <div class="row" id="bgb">
             <?php
                $a = new Area('CTA');
                $a->display($c);
            ?>            
         </div>


        <div class="row" id="We"> 
              <?php
                $a = new Area('Contenu');
                $a->display($c);
            ?>            
        </div>

<?php $view->inc('elements/footer.php'); ?>


