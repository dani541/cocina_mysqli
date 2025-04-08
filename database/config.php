<?php


function connect(){

    $server = "127.0.0.1";
    $user = "root"; 
    $pass = "Sandia4you"; 
    $dbname = "cocina"; 

    $conn = new mysqli($server, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    return $conn;



}



function createTables(){

    $c=connect();



    $sql= "CREATE TABLE IF NOT EXISTS users (
        id int PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(250),
        email VARCHAR(250),
        password VARCHAR(250)
     
    
    )";

    $c->query($sql);





    $sql="CREATE TABLE IF NOT  EXISTS recipes (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(250),
        description VARCHAR(250),
        time FLOAT(10,2),
        id_user INT,
        FOREIGN KEY (id_user) REFERENCES users(id)
    
    )"; 

    $c->query($sql);



    $sql= "CREATE TABLE IF NOT EXISTS ingredients(
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(250),
        quantity INT
    )";

    $c->query($sql);



    $sql= "CREATE TABLE IF NOT EXISTS ingredient_recipe(
        id INT PRIMARY KEY AUTO_INCREMENT,
        id_recipe INT,
        id_ingredient INT,
        FOREIGN KEY (id_recipe) REFERENCES recipes(id),
        FOREIGN KEY (id_ingredient) REFERENCES ingredients(id)
    
    )";

    $c->query($sql);



    




}





function insertData(){
    
    $c=connect();


    $sqlRecipe= "INSERT INTO recipes (title, description, time) VALUES 
           ('Titulo nuevo 1', 'descripcion nueva 1', 3),
           ('Titulo nuevo 2', 'descripcion nueva 2', 2),
           ('Titulo nuevo 3', 'descripcion nueva 3', 2),
           ('Titulo nuevo 4', 'descripcion nueva 4', 1)

    
    ";
         
         if ($c->query($sqlRecipe)) {
            echo "Datos insertados correctamente.<br>";
        } else {
            echo "Error al : " . $c->error . "<br>";
        }



    $sqlIngredients= "INSERT INTO ingredients (name, quantity) VALUES 
        (' Ingrediente nuevo 1',  3),
        ('Ingrediente nuevo 2', 50),
        ('Ingrediente nuevo 3', 8),
        ('Ingrediente nuevo 4', 6)

 
        ";
      
      if ($c->query($sqlIngredients)) {
         echo "Datos insertados correctamente.<br>";
     } else {
         echo "Error al : " . $c->error . "<br>";
     }



    $sqlUser= "INSERT INTO users (name, email, password) VALUES 
     ('usuario nuevo 1', 'email1@gmail.com', '123456'),
      ('usuario nuevo 2', 'email2@gmail.com', '123456'),
     ('usuario nuevo 3', 'email3@gmail.com', '123456'),
      ('usuario nuevo 4', 'email4@gmail.com', '123456'),
    ('usuario nuevo 5', 'email5@gmail.com', '123456')
     ";


    if ($c->query($sqlUser)) {
        echo "Datos insertados correctamente.<br>";
    } else {
        echo "Error al : " . $c->error . "<br>";
    }




}



//createTables();

//insertData();


function securizar($datos): string
{
    $datos = trim($datos);
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

























