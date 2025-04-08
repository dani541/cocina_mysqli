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
 

   $prepared->bind_param("ii", $id_recipe, $id_ingredient);;
   return $prepared->execute();


}







 function showRecipes(){

    $c= connect();


    $sql= "SELECT * FROM recipes";

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





 function findIngredient (){

   $c= connect();


   $sql= "SELECT * from ingredients ";

   $r=$c->query($sql);
   $c->close();
   return $r;

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
        return $row; // Devuelve el usuario como array asociativo
    }

    return null; 


   }










