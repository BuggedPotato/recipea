function addIngredientRow(){
    const root = document.getElementById("ingredients-list");
    const blueprint = document.getElementById("ingredient-blueprint");
    let el = blueprint.cloneNode(true);
    el.removeAttribute("id");
    el.removeAttribute("style");
    root.appendChild(el);
}

function removeIngredientRow(sender){
    const row = sender.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

function addStepRow(){
    const root = document.getElementById("steps-list");
    const blueprint = document.getElementById("step-blueprint");
    let el = blueprint.cloneNode(true);
    el.removeAttribute("id");
    el.removeAttribute("style");
    root.appendChild(el);
}

function removeStepRow(sender){
    const row = sender.parentNode;
    row.parentNode.removeChild(row);
}

function cancelRecipe(){
    navigation.navigate("/");
}

async function addRecipe(){
    const input = document.getElementById("recipe-image");
    let recipe = createRecipeJson();
    let data = new FormData();
    data.append('image', input.files[0]);
    data.append('recipe', JSON.stringify(recipe));

    const res = await fetch('/api/createRecipe', {
        method: 'POST',
        body: data
    });
    if(res.ok){
        navigation.navigate("/recipes/myRecipes");
    }
}

function createRecipeJson(){
    const title = document.getElementById('recipe_title').value.trim();
    const description = document.getElementById('description').value.trim();

    const categoriesRaw = document.getElementById('categories').value;
    const categories = categoriesRaw
    .split(',')
    .map(c => c.trim())
    .filter(c => c.length > 0);

    const ingredients = [];
    const ingredientRows = document.querySelectorAll('#ingredients-list tr');

    ingredientRows.forEach(row => {
        const amount = row.querySelector('input[name="amount"]').value;
        const unit = row.querySelector('input[name="unit"]').value.trim();
        const name = row.querySelector('input[name="name"]').value.trim();

        if (name) {
            ingredients.push({
                amount: amount.length > 0 ? Number(amount) : null, unit, name
            });
        }
    });

    const steps = [];
    const stepItems = document.querySelectorAll('#steps-list li');

    stepItems.forEach((li, index) => {
        const textarea = li.querySelector('textarea[name="step"]');
        const value = textarea.value.trim();

        if (value) {
            steps.push(value);
        }
    });

    return {
        title,
        description,
        categories,
        ingredients,
        steps
    };
}

async function loadRecipes(onlyUsers = false) {
    let res;
    if(onlyUsers){
        res = await fetch("/api/getUserRecipes", {method: "POST"});
    }
    else
        res = await fetch("/api/getAllRecipes", {method: "POST"});
    if(!res.ok){
        console.error("Could not fetch recipes");
        return;
    }
    const recipes = await res.json();
    console.log(recipes);

    const container = document.getElementById('recipes-list');
    container.innerHTML = '';

    recipes.forEach(recipe => {
        const card = getRecipeElement(recipe);
        container.appendChild(card);
    });
}

function getRecipeElement(recipe){
    let el = document.createElement("div");
    el.classList.add("recipe-card");
    el.addEventListener("click", ()=>{
        navigation.navigate("/recipes/details/" + recipe.id);
    });

    let img = document.createElement("img");
    img.src = "/uploads/recipes/" + recipe.image;

    let group = document.createElement("div");
    group.classList.add("card-info");

    let title = document.createElement("p");
    title.innerText = recipe.title.length > 0 ? recipe.title : "Bez nazwy";
    title.classList.add("card-title");
    let desc = document.createElement("p");
    desc.innerText = recipe.description.length > 0 ? recipe.description : "Bez opisu";
    desc.classList.add("card-description");

    group.appendChild(title);
    group.appendChild(desc);

    el.appendChild(img);
    el.appendChild(group);
    return el;
}


async function loadRecipe(id, userId = null){
    const res = await fetch("/api/getRecipe", {
        method: 'POST',
        body: JSON.stringify({
            'recipe_id': id
        })
    });
    if(!res.ok){
        if(res.status == 400){
            const root = document.getElementById("recipe-details");
            root.innerHTML = '';
            let title = document.createElement("h1");
            title.innerText = "Nie znaleziono przepisu :<";
            title.style.textAlign = "center";
            root.appendChild(title);

            console.error("Recipe with id '" + id + "' not found");
        }
        else
            console.error("Could not fetch recipe with id '" + id + "'");
        return;
    }

    const recipe = await res.json();
    console.log(recipe);
    setRecipeDetailsElement(recipe);
    tryAddDeleteButton(userId, recipe);
}

function setRecipeDetailsElement(recipe){
    document.getElementById("recipe-title").innerText = recipe.title.length > 0 ? recipe.title : "Bez nazwy";
    document.getElementById("recipe-description").innerText = recipe.description.length > 0 ? recipe.description : "Bez opisu";

    document.getElementById("recipe-image").src = "/uploads/recipes/" + recipe.image;

    const ingredientsList = document.getElementById("recipe-ingredients");
    ingredientsList.innerHTML = '';
    recipe.ingredients.forEach(ingredient => {
        let el = document.createElement("li");
        let text = document.createElement("p");
        text.innerText = ingredient.amount + " " + ingredient.unit + " " + ingredient.name;
        el.appendChild(text);
        ingredientsList.appendChild(el);
    });

    const stepsList = document.getElementById("recipe-steps");
    stepsList.innerHTML = '';
    recipe.steps.forEach(step => {
        let el = document.createElement("li");
        el.innerText = step;
        stepsList.appendChild(el);
    });
}


async function deleteRecipe(id){
    const res = await fetch("/api/deleteRecipe", {
        method: 'POST',
        body: JSON.stringify({
            'recipe_id': id
        })
    });
    if(!res.ok){
        if(res.status == 400){
            console.error("Recipe with id '" + id + "' not found");
        }
        else
            console.error("Could not delete recipe with id '" + id + "'");
        return;
    }

    navigation.navigate("/");
}

function tryAddDeleteButton(userId, recipe){
    if(userId == recipe.owner_id){
        let el = document.createElement("button");
        el.classList.add("btn");
        el.classList.add("rounded");
        el.classList.add("danger");
        el.innerText = "Usuń";
        el.onclick =()=> deleteRecipe(recipe.id);

        el.style.position = "absolute";
        el.style.bottom = "0.5rem";
        el.style.right = "0.5rem";

        document.getElementById("recipe-image").parentNode.appendChild(el);
    }
}
