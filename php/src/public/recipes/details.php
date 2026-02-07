<?php
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../templates/loader.php';
loadTemplate("header");
loadTemplate("navbar");
?>
<script src="/recipes/recipesScript.js"></script>
<script>
    document.body.onload = loadRecipe(
        <?php
            $foo = null;
            if(isset($_SESSION['user']))
                $foo = $_SESSION['user']['id'];
            echo $recipe_id . ', ' .  $foo;
        ?>
    );
</script>

<div class="w-75">
    <div id="recipe-details" class="flex flow-col recipe-details">
        <div style="position: relative;">
            <img id="recipe-image" src=""/>
            <h1 id="recipe-title">Przepis</h1>
        </div>
        <h2>Opis:</h2>
        <p id="recipe-description"></p>
        <h2>Składniki:</h2>
        <ul id="recipe-ingredients" class="flex flow-col border-thin rounded">

        </ul>
        <h2>Przygotowanie:</h2>
        <ol id="recipe-steps" class="flex flow-col colored-markers">

        </ol>
    </div>
</div>

</body >
</html>
