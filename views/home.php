<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/database/config.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/database/functions.php";

include_once $_SERVER['DOCUMENT_ROOT'] . "/classes/Recipe.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/classes/Ingredient.php";

$users=findUsers();


$recipesIngredient = findRecipesWithIngredients();
$ingredients = showIngredient();
$recipes=showRecipes();

$id=$title=$description=$time=$user=$id_ingredient=$id_recipe="";
$titleEr=$descriptionEr=$timeEr=$id_ingredientEr=$id_recipeEr="";

$name=$quantity="";
$nameEr=$quantityEr="";

$errors=false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {




    if (isset($_POST['submit_recipe'])) {


        $title = securizar($_POST["title"]);
        $description = securizar($_POST["description"]);
        $time = securizar($_POST["time"]);
        $user= securizar($_POST["user_id"]);



        if (empty($title)){
            $titleEr="Es obligatorio";
            $errors=true;
        }
    
    
        if (empty($description)){
            $descriptionEr="Es obligatorio";
            $errors=true;
        }
    
    
        if (empty($time)){
            $timeEr="Es obligatorio";
            $errors=true;
        }


        if (empty($user)){
            $userEr="Es obligatorio";
            $errors=true;
        }



        if(!$errors){

            $recipe= new Recipe($id ,$title,$description,$time, $user);
    
            insertRecipe($recipe);

        }

    }

   
    if (isset($_POST['submit_ingredient'])) {


    $name = securizar($_POST["name"]);
    $quantity = securizar($_POST["quantity"]);
    


    if (empty($name)){
        $nameEr="Es obligatorio";
        $errors=true;
    }


    if (empty($quantity)){
        $quantityEr="Es obligatorio";
        $errors=true;
    }


    if(!$errors){

     $ingredient= new Ingredient($id,$name, $quantity, null);

           
        insertIngredient($ingredient);


    }
}



if (isset($_POST['submit_IngreReci'])) {


    $id_ingredient = securizar($_POST["id_ingredient"]);
    $id_recipe = securizar($_POST["id_recipe"]);



    if (empty($id_ingredient)){
        $id_ingredientEr="Es obligatorio";
        $errors=true;
    }


    if (empty($id_recipe)){
        $id_recipeEr="Es obligatorio";
        $errors=true;
    }


    if(!$errors){

        IngredientRecipe($id_recipe,$id_ingredient);
   
       }


}    


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h3>Home</h3>


    <h2>Recetas e Ingredientes</h2>

    <?php foreach($recipesIngredient as $recipe):?>

                <p style="font-weight: bold;">Titulo: <?= $recipe["title"] ?></p>
                <p>Descripción: <?= $recipe["description"] ?></p>
                <p>Tiempo: <?= $recipe["time"] ?> minutos</p>

                <h4>Ingredientes:</h4>
                <?php foreach($recipe['ingredients'] as $ingredient):?>
                    <p><?= $ingredient['name'] ?> - <?= $ingredient['quantity'] ?> unidades</p>
                <?php endforeach?>

                <br>

    <?php endforeach?>


<br>




    <h4>Insertar receta</h4>

    <form action="" method="POST">

        <label for="">Titulo:</label>
        <input type="text" id="title" name="title">

        <label for="">Descripcion:</label>
        <input type="text" id="description" name="description">

        <label for="">Tiempo:</label>
        <input type="number" id="time" name="time">


        <label for="user_id">Usuario:</label>
        <select id="user_id" name="user_id">
            <option value="">Selecciona un usuario</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
            <?php endforeach; ?>
        </select>



        <input type="submit" name="submit_recipe" value="Guardar Receta">
    </form>




    <h4>Insertar ingrediente</h4>

    <form action="" method="POST">

        <label for="">Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">

        <label for="">Cantidad:</label>
        <input type="text" name="quantity" value="<?= htmlspecialchars($quantity) ?>">

    
        <input type="submit" name="submit_ingredient" value="Guardar Ingrediente">

    </form>



    <h4>Asignar ingrediente a receta</h4>



    <form action="" method="POST">

        <label for="">Ingrediente:</label>

        
    <select name="id_ingredient" id="">
        <?php foreach($ingredients as $ingredient): ?>
        <option value="<?= $ingredient["id"]  ?>"><?= $ingredient["name"]  ?></option>

        <?php endforeach ?>
    </select>



        <label for="">Receta:</label>


    <select name="id_recipe" id="">
        <?php foreach($recipes as $recipe): ?>
        <option value="<?= $recipe['id']  ?>"><?= $recipe['title']?></option>

        <?php endforeach ?>
    </select>



        <input type="submit" name="submit_IngreReci" value="Asignar">
    </form>








    
</body>
</html>