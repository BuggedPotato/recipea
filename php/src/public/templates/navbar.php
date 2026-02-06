<div class="flex flow-row">
<?php
    if(isset($_SESSION['user'])){
        echo '<p>Witaj, ' . $_SESSION['user']['display_name'] . '!</p>
        <a href="/user/profile">Profil</a>';
    }
?>
</div>
