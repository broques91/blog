<div class="mx-auto">
    <p class="text-center">
    <?php
    for($i = 1; $i <= $nbPages; $i++) {
        
        // Si il s'agit de la page actuelle...
        if($i == $pageActuelle) {
            echo ' [ '.$i.' ] '; 
        }else{
            echo ' <a href="index.php?page='.$i.'">'.$i.'</a> ';
        }
    }
    ?>
    </p>
</div>