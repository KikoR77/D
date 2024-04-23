<?php
    include_once "header.php";

?>
 
    </div>
<!---account-page-->
  <div class="acount-page">
      <div class="container">
        <div class="row">
            <div class="snimkazalogina">
                <img src="images/Tips-to-Choose-Genuine-Spare-Parts-from-Online-or-Physical-Store-624x351.jpg" width="100%">
            </div>

            <div class="col-2">
               <div class="form-container">
                 <div class="form-btn">
                    <span onclick="login()">Вход</span>
                    <span onclick="register()">Регистрация</span>
                    <hr id="Indicator">
                 </div>
                 <form id="LoginForm"  action="includes/login.inc.php" method="POST">
                    <input type="text" name="username" placeholder="Потребителско име:">
                    <input type="password" name="password" placeholder="Парола:">
                    <button class="btn" type="submit" name="submit" value="submit">Влез</button>
                    <a href="">Забравена парола</a>
                 </form>

                 <form id="RegForm" action="includes/signup.inc.php" method="POST">
                    <input type="text" name="username" placeholder="Потребителско име:">
                    <input type="email" name="email" placeholder="Имейл:">
                    <input type="phonenumber" name="phone" placeholder="Телефонен номер:">
                    <input type="password" name="password" placeholder="Парола:">
                    <input type="password" name="confirmPassword" placeholder="Потвърди парола:">
                    <button class="btn" type="submit" name="submit" value="submit">Регистрирай се</button>                    
                 </form>
               </div>
            </div>
        </div>
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

  <script>
    var LoginForm =document.getElementById("LoginForm");
    var RegForm =document.getElementById("RegForm");
    var Indicator =document.getElementById("Indicator");

    function register( ){
        RegForm.style.transform ="translateX(0px)";
        LoginForm.style.transform ="translateX(0px)";
        Indicator.style.transform ="translateX(100px)";
    }
    function login( ){
        RegForm.style.transform ="translateX(300px)";
        LoginForm.style.transform ="translateX(300px)";
        Indicator.style.transform ="translateX(0px)";
    }

  </script>
</body>
</html>