<?php
    include_once "header.php";
    include_once "includes/db.php";

    // Инициализация на променливите за филтриране
    $search = "";
    $minPrice = "";
    $maxPrice = "";
    $minYear = "";
    $maxYear = "";

    // Проверка за изпращане на формата за филтриране
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $search = $_POST["search"];
        $minPrice = $_POST["minPrice"];
        $maxPrice = $_POST["maxPrice"];
        $minYear = $_POST["minYear"];
        $maxYear = $_POST["maxYear"];

        // Подготвяме заявката за филтриране
        $sql = "SELECT * FROM products WHERE name LIKE '%$search%'";

        // Добавяме условия за филтриране по цена и година, ако са въведени
        if (!empty($minPrice)) {
            $sql .= " AND price >= $minPrice";
        }
        if (!empty($maxPrice)) {
            $sql .= " AND price <= $maxPrice";
        }
        if (!empty($minYear)) {
            $sql .= " AND year >= $minYear";
        }
        if (!empty($maxYear)) {
            $sql .= " AND year <= $maxYear";
        }

        $result = mysqli_query($conn, $sql);
    } else {
        // Ако не е изпратена формата за филтриране, извеждаме всички продукти
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);
    }
?>

<div class="filter-container">
    <form method="POST">
        <label for="search">Търсене по име:</label>
        <input type="text" id="search" name="search" value="<?php echo $search; ?>">
        
        <label for="minPrice">Минимална цена:</label>
        <select id="minPrice" name="minPrice">
            <option value="">Избери</option>
            <option value="100" <?php if($minPrice == '100') echo 'selected'; ?>>100 лв.</option>
            <option value="200" <?php if($minPrice == '200') echo 'selected'; ?>>200 лв.</option>
            <option value="300" <?php if($minPrice == '300') echo 'selected'; ?>>300 лв.</option>
            <option value="400" <?php if($minPrice == '300') echo 'selected'; ?>>400 лв.</option>
            <option value="500" <?php if($minPrice == '300') echo 'selected'; ?>>500 лв.</option>
            <option value="600" <?php if($minPrice == '300') echo 'selected'; ?>>600 лв.</option>
            <option value="700" <?php if($minPrice == '300') echo 'selected'; ?>>700 лв.</option>
            <option value="800" <?php if($minPrice == '300') echo 'selected'; ?>>800 лв.</option>
            <option value="900" <?php if($minPrice == '300') echo 'selected'; ?>>900 лв.</option>
            <option value="1000" <?php if($minPrice == '300') echo 'selected'; ?>>1000 лв.</option>
            <option value="1100" <?php if($minPrice == '300') echo 'selected'; ?>>1100 лв.</option>
            <option value="1200" <?php if($minPrice == '300') echo 'selected'; ?>>1200 лв.</option>
        </select>
        
        <label for="maxPrice">Максимална цена:</label>
        <select id="maxPrice" name="maxPrice">
            <option value="">Избери</option>
            <option value="500" <?php if($maxPrice == '500') echo 'selected'; ?>>500 лв.</option>
            <option value="1000" <?php if($maxPrice == '1000') echo 'selected'; ?>>1000 лв.</option>
            <option value="1500" <?php if($maxPrice == '1500') echo 'selected'; ?>>1500 лв.</option>
        </select>
        
        <label for="minYear">Минимална година:</label>
        <select id="minYear" name="minYear">
            <option value="">Избери</option>
            <option value="2000" <?php if($minYear == '2010') echo 'selected'; ?>>2000</option>
            <option value="2005" <?php if($minYear == '2010') echo 'selected'; ?>>2005</option>
            <option value="2010" <?php if($minYear == '2010') echo 'selected'; ?>>2010</option>
            <option value="2015" <?php if($minYear == '2015') echo 'selected'; ?>>2015</option>
            <option value="2020" <?php if($minYear == '2020') echo 'selected'; ?>>2020</option>
        </select>
        
        <label for="maxYear">Максимална година:</label>
        <select id="maxYear" name="maxYear">
            <option value="">Избери</option>
            <option value="2000" <?php if($maxYear == '2025') echo 'selected'; ?>>2000</option>
            <option value="2005" <?php if($maxYear == '2025') echo 'selected'; ?>>2005</option>
            <option value="2010" <?php if($maxYear == '2025') echo 'selected'; ?>>2010</option>
            <option value="2015" <?php if($maxYear == '2025') echo 'selected'; ?>>2015</option>
            <option value="2020" <?php if($maxYear == '2025') echo 'selected'; ?>>2020</option>
            <option value="2025" <?php if($maxYear == '2025') echo 'selected'; ?>>2025</option>
            <option value="2030" <?php if($maxYear == '2030') echo 'selected'; ?>>2030</option>
            <option value="2035" <?php if($maxYear == '2035') echo 'selected'; ?>>2035</option>
        </select>
        
        <button type="submit">Филтрирай</button>
    </form>
</div>

<div class="small-container">
    <div class="row row-2">
        <h2>Всички продукти</h2>
    </div>
    <div class="row">
        <?php
            // Проверка за наличие на резултати от заявката за филтриране
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {                
                  $firstImageId = explode(" ", $row['images'])[0];
                  $getImagesSql = "SELECT * FROM images WHERE id = '".$firstImageId."'";
                  $imageResult = mysqli_query($conn, $getImagesSql);
                  
                  $imageURL = "";
                  if(mysqli_num_rows($imageResult) > 0){                    
                    $imageURL = mysqli_fetch_assoc($imageResult)["img_dir"];                    
                  }

                  echo '<div class="col-4">
                    <a href="products-detail.php?productId='.$row["productId"].'"><img src="includes/'.$imageURL.'" ></a>
                    <h4>'.$row["name"].'</h4>                    
                    <p>'.$row["price"].' лв.</p>
                    <p>'.$row["typep"].'.</p>
                    </div>';
                }
            } else {
                // Съобщение, ако няма резултати от филтрирането
                echo "Няма намерени продукти.";
            } 
        ?>
    </div>
</div>

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-col-1">
                <h3>Кратко описание:</h3>
                <p>"Kiko's parts" е най-добрият магазин за авточасти в България!.Ниски цени високо качество и изключително много доволни клиенти! </p>
                
            </div>
           
            <div class="footer-col-3">
                <h3>Работно време: </h3>
                
              <p> <span>Понеделник -Петък:</span> 8:00 - 19:00ч. </p>
              <p> <span>Събота:</span> 10:00 - 17:00ч. </p>
              <p> <span>Неделя:</span> Затворено</p>
              <p> <span>Официални  празници:</span> Затворено</p>
              <p> <span>Национален празник:</span> Затворено</p>
              
            </div>
            <div class="footer-col-4">
                <h3>Последвайте ни:</h3>
                <ul>
                    <li><a class="fa fa-facebook" > Кристиян Радев</a></li>
                    <li><a class="fa fa-instagram" > radev31</a></li>
                    <li><a class="link"> <i class="fa fa-mobile-phone"></i> +359-893-724-681 </a></li>
                    <li><a  class="link"> <i class="fa fa-envelope"></i> kristiyanradev19b@gmail.com </a></li>
                </ul>
            </div>
        </div>
        <hr>
        <p class="copyright"> &copy Създадено от Кристиян Радев | Всички права запазени!</p>
    </div>
  </div>

<script>
      var MenuItems = document.getElementById("MenuItems");
      MenuItems.style.maxHeight = "0px";
      function menutoggle(){
        if( MenuItems.style.maxHeight == "0px")
        {
            MenuItems.style.maxHeight = "200px";
        }
        else
        {
            MenuItems.style.maxHeight = "0px";
        }
      }
  </script>
  


</body>
</html>
</body>
</html>