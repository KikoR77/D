<?php
    include_once "header.php";

    if(!isset($_SESSION["accountType"]) || $_SESSION["accountType"] !== 1) {
        header("Location: index.php");
    }
?>

<div class="p-5">
    <div class="container">
        <div class="d-lg-flex justify-content-between">
            <div class="postForm w-100 pe-lg-5">
                <form action="includes/add.php" method="POST" enctype="multipart/form-data" class="text-center">
                    <div class="justify-content-between pb-2">
                        <?php 
                            if(isset($_GET["productName"]) && !empty($_GET["productName"])) {
                                echo '<input type="text" name="productName" class="form-control postInput" placeholder="Име на продукт" value="'.$_GET["productName"].'">';
                            } else if(isset($_GET["productName"])) {
                                echo '<input type="text" name="productName" class="form-control postInput error" placeholder="Име на продукт">';
                            } else {
                                echo '<input type="text" name="productName" class="form-control postInput" placeholder="Име на продукт">';
                            }
                        ?>                        
                    </div>
                    <div class="justify-content-between pb-2">
                        <?php 
                            if(isset($_GET["typep"]) && !empty($_GET["typep"])) {
                                echo '<input type="text" name="typep" class="form-control postInput" placeholder="Тип на продкута" value="'.$_GET["typep"].'">';
                            } else if(isset($_GET["productName"])) {
                                echo '<input type="text" name="typep" class="form-control postInput error" placeholder="Тип на продукта">';
                            } else {
                                echo '<input type="text" name="typep" class="form-control postInput" placeholder="Тип на продукта">';
                            }
                        ?>                        
                    </div>                   
                    <div class="uploadImg rounded lead text-center mt-3 center">
                        <div class="title lead">Качи файл</div>                        
                        <div class="dropzone mx-auto my-5">
                            <div class="content p-5">
                                <img src="images/upload.svg" class="upload" id="img">
                                <span class="filename"></span>
                                <input type="file" name="image[]" class="input" multiple>                                
                            </div>                            
                        </div>                        
                    </div>
                    
                    <div class="justify-content-between my-4">
                        <?php
                            if(isset($_GET["description"]) && !empty($_GET["description"])) {
                                echo '<textarea name="description" class="form-control postInput py-5" placeholder="Описание">'.$_GET["description"].'</textarea>';
                            } else if(isset($_GET["description"])) {
                                echo '<textarea name="description" class="form-control postInput py-5 error" placeholder="Описание"></textarea>';
                            } else {
                                echo '<textarea name="description" class="form-control postInput py-5" placeholder="Описание"></textarea>';
                            }
                        ?>
                        
                    </div>
                    <div class="justify-content-between my-4">
                        <?php
                            if(isset($_GET["horsepower"]) && !empty($_GET["horsepower"])) {
                                echo '<input type = "number" name="horsepower" class="form-control postInput py-5" placeholder="Конски сили">'.$_GET["Horse-power"].'</textarea>';
                            } else if(isset($_GET["Horsepower"])) {
                                echo '<input type = "number" name="horsepower" class="form-control postInput py-5 error" placeholder="Конски сили"></textarea>';
                            } else {
                                echo '<input type = "number" name="horsepower" class="form-control postInput py-5" placeholder="Конски сили"></textarea>';
                            }
                        ?>
                        
                    </div>                                          

                    <?php
                        if(isset($_GET["price"]) && !empty($_GET["price"])) {
                            echo '<div class="justify-content-between my-4">
                            <input type="number" name="price" class="form-control postInput" placeholder="Цена" min="0" max="1500" value="'.$_GET["price"].'">
                        </div>';
                        } else if(isset($_GET["price"])) {
                            echo '<div class="justify-content-between my-4">
                            <input type="number" name="price" class="form-control postInput error" placeholder="Цена" min="0" max="1500">
                        </div>';
                        } else {
                            echo '<div class="justify-content-between my-4">
                            <input type="number" name="price" class="form-control postInput" placeholder="Цена" min="0" max="1500">
                        </div>';
                        }
                    ?>

                    <?php
                        if(isset($_GET["year"]) && !empty($_GET["year"])) {
                            echo '<div class="justify-content-between my-4">
                            <input type="number" name="year" class="form-control postInput" placeholder="Година" value="'.$_GET["year"].'">
                        </div>';
                        } else if(isset($_GET["year"])) {
                            echo '<div class="justify-content-between my-4">
                            <input type="number" name="year" class="form-control postInput error" placeholder="Година">
                        </div>';
                        } else {
                            echo '<div class="justify-content-between my-4">
                            <input type="number" name="year" class="form-control postInput" placeholder="Година">
                        </div>';
                        }
                    ?>

                    <button class="btn btn-lg submitBtn" type="submit" name="submit">Публикувай</button>
                </form>
            </div>            
        </div>
    </div>
</div>