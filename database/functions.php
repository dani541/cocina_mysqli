<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/database/config.php";



function insertRecipe(Recipe $recipe){

    $c=connect();

    $sql="INSERT INTO recipes (title, description, time) VALUES (?,?,?)";  //Solo hay que poner los que queremos inseertar en el form

    $prepared= $c->prepare($sql);

   
    $title=$recipe->getTitle();
    $description=$recipe->getDescription();
    $time=$recipe->getTime();

    $prepared->bind_param("ssi", $title, $description, $time);
    return $prepared->execute();


}



function insertIngredient(Ingredient $ingredient){


   $c=connect();

   $sql="INSERT INTO ingredients (name, quantity) VALUES (?,?)";  //Solo hay que poner los que queremos inseertar en el form

   $prepared= $c->prepare($sql);

  
   $name=$ingredient->getName();
   $quantity=$ingredient->getQuantity();
  

   $prepared->bind_param("si", $name, $quantity);
   return $prepared->execute();


}




function IngredientRecipe($id_recipe, $id_ingredient){


   $c=connect();

   $sql="INSERT INTO ingredient_recipe (id_recipe, id_ingredient) VALUES (?,?)";

   $prepared= $c->prepare($sql);
 

   $prepared->bind_param("ii", $id_recipe, $id_ingredient);
   return $prepared->execute();


}







 function showRecipes(){

    $c= connect();


    $sql= "SELECT * FROM recipes";

    $r=$c->query($sql);
    $c->close();
    return $r;

 }

 function showIngredient(){

   $c= connect();


   $sql= "SELECT * FROM ingredients";

   $r=$c->query($sql);
   $c->close();
   return $r;

}




 function findUsers (){

    $c= connect();


    $sql= "SELECT * from users ";

    $r=$c->query($sql);
    $c->close();
    return $r;

 }





 function findRecipesWithIngredients() {
   $c = connect();
   $sql = "
       SELECT recipes.id AS recipe_id, recipes.title AS recipe_title, recipes.description AS recipe_description, recipes.time AS recipe_time,
              ingredients.id AS ingredient_id, ingredients.name AS ingredient_name, ingredients.quantity AS ingredient_quantity
       FROM recipes
       INNER JOIN ingredient_recipe ON recipes.id = ingredient_recipe.id_recipe
       INNER JOIN ingredients ON ingredient_recipe.id_ingredient = ingredients.id
   ";
   
   $prepared = $c->prepare($sql);
   $prepared->execute();
   $result = $prepared->get_result();

   $recipes = [];
   while ($row = $result->fetch_assoc()) {
       // Verifica si la receta ya está en el array $recipes
       if (!isset($recipes[$row['recipe_id']])) {
           $recipes[$row['recipe_id']] = [
               'title' => $row['recipe_title'],
               'description' => $row['recipe_description'],
               'time' => $row['recipe_time'],
               'ingredients' => []
           ];
       }

       // Añadir el ingrediente a la receta correspondiente
       $recipes[$row['recipe_id']]['ingredients'][] = [
           'name' => $row['ingredient_name'],
           'quantity' => $row['ingredient_quantity']
       ];
   }

   return $recipes;
}






function findRecipes() {
   $c = connect();
   $sql = "SELECT * FROM recipes";
   $result = $c->query($sql);
   $recipes = [];

   while ($row = $result->fetch_assoc()) {
      
       $recipes[] = new Recipe($row['id'], $row['title'], $row['description'], $row['time'], $row['id_user']);
   }

   return $recipes;
}




   function findUSer($email){

      $c = connect();
    $sql = "SELECT * FROM users WHERE email = ?";
    
    $prepared = $c->prepare($sql);
    $prepared->bind_param("s", $email);
    $prepared->execute();
    
    $result = $prepared->get_result();
    
    if ($row = $result->fetch_assoc()) {
        return $row; 
    }

    return null; 


   }










