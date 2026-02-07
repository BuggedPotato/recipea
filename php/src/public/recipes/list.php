<?php
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../templates/loader.php';
loadTemplate("header");
loadTemplate("navbar");
?>
<script src="/recipes/recipesScript.js"></script>
<script>
    document.body.onload =()=> loadRecipes(false);
</script>

<div class="w-75">
    <h1>Lista przepisów</h1>

    <div id="recipes-list" class="flex flow-row wrap">
    </div>
</div>

</body >
</html>
