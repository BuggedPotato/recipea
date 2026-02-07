<div id="navbar" class="flex flow-row w-100" style="justify-content: space-between;">
    <a href="/" class="flex flow-row" style="align-items: center; text-decoration: none;">
        <img src="/res/logo.png" width="48" height="48"  />
        <p class="app-name" style="font-size: 2rem;">Recipea</p>
    </a>

    <div id="nav-links" class="flex full-center">
        <a href="/recipes/list">Przeglądaj przepisy</a>
        <?php
            if(isset($_SESSION['user'])){
            echo '<a href="/recipes/myRecipes">Moje przepisy</a>
                ';
            }
        ?>

        <a class="btn primary rounded" href="/recipes/new">Dodaj przepis</a>
    </div>
<?php
    if(isset($_SESSION['user'])){
        echo '<div class="flex full-center">
        <p style="font-size: 1.1rem;">Witaj, ' . $_SESSION['user']['display_name'] . '!</p>
        <a style="margin: 0 1rem;" href="/user/profile">Profil</a>
        <form action="/api/logout" method="GET">
            <button style="font-size: 0.9rem;" class="btn secondary rounded">Wyloguj</button>
        </form>
        </div>';
    }
    else{
        echo '
            <a href="/login" class="btn primary rounded">Zaloguj</a>
        ';
    }
?>
</div>
