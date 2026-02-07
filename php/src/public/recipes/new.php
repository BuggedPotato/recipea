<?php
require_once __DIR__ . '/../../config/auth.php';
requireAuth();
require_once __DIR__ . '/../templates/loader.php';
loadTemplate("header");
loadTemplate("navbar");
?>
<script src="./recipesScript.js"></script>
<div class="flex flow-col full-center w-75" style="margin: 1rem 5rem;">
    <h1 class="w-100" style="text-align: left;">Stwórz nowy przepis</h1>
    <div class="flex flow-row w-100">
        <div class="flex flow-col w-50" style="margin: 1rem;">
            <div class="flex flow-col full-center  border-dashed rounded" style="padding: 2rem 1rem;">
                <p>Dodaj zdjęcie potrawy</p>
                <input id="recipe-image" type="file" class="btn secondary rounded" />
            </div>

            <div class="flex flow-col" style="margin: 0.5rem 0;">
                <label class="bold" for="title">Nazwa:</label>
                <input id="recipe_title" class="border-thin rounded" name="title" type="text" placeholder="Nazwa przepisu..."/>
            </div>
            <div class="flex flow-col" style="margin: 0.5rem 0;">
                <label class="bold" for="description">Opis:</label>
                <textarea id="description" class="border-thin rounded" name="description" rows="8" placeholder="Krótki opis..."></textarea>
            </div>
            <div class="flex flow-col" style="margin: 0.5rem 0;">
                <label class="bold" for="categories">Kategorie:</label>
                <input id="categories" class="border-thin rounded" name="categories" type="text" placeholder="Dodaj tagi..."/>
            </div>
        </div>

        <div class="flex flow-col w-50" style="margin: 1rem;">
            <div class="flex flow-col" style="margin-bottom: 0.5rem;">
                <h3 style="margin: 0;">Składniki</h3>

                <table>
                    <tr>
                        <th class="bold">Ilość</th>
                        <th class="bold">Jednostka</th>
                        <th class="bold">Nazwa</th>
                        <th></th>
                    </tr>
                    <tr id="ingredient-blueprint" style="display: none;">
                        <td>
                            <input name="amount" type="number" min="0" class="border-thin w-100 rounded"/>
                        </td>
                        <td>
                            <input name="unit" type="text" class="border-thin w-100 rounded"/>
                        </td>
                        <td>
                            <input name="name" type="text" class="border-thin w-100 rounded"/>
                        </td>
                        <td>
                            <button onclick="removeIngredientRow(this)" class="btn danger rounded" style="margin: 0; padding: 0.75rem;">Usuń</button>
                        </td>
                    </tr>
                    <tbody id="ingredients-list">
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <button onclick="addIngredientRow()" class="btn w-100 empty">
                                    <span class="bold">Dodaj składnik</span>
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="flex flow-col" style="margin-bottom: 0.5rem;">
                <h3 style="margin: 0;">Kroki</h3>
                    <li id="step-blueprint" style="display: none;">
                        <textarea name="step" class="border-thin rounded w-75" rows="3" placeholder="Opis kroku..."></textarea>
                        <button onclick="removeStepRow(this)" style="margin: 0 1rem;" class="btn danger rounded">
                            <span class="bold">Usuń</span>
                        </button>
                    </li>

                <ol id="steps-list" class="w-100 colored-markers" style="text-align: center;">
                </ol>

                <button onclick="addStepRow()" class="btn empty rounded">Dodaj krok</button>
            </div>

        </div>
    </div>
    <div class="flex w-100" style="justify-content: flex-end; border-top: 0.1rem solid var(--color-border);">
        <button onclick="cancelRecipe()" class="btn secondary rounded" style="margin: 0.25rem 0.5rem;">Anuluj</button>
        <button onclick="addRecipe()" class="btn primary rounded" style="margin: 0.25rem 0.5rem;">Zapisz</button>
    </div>

</div>
</body>
</html>
