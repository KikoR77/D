<?php
include_once "header.php";

// Проверка дали формата е изпратена
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"])) {
    // Включване на файлът с връзката към базата данни

    // Подготвяне на заявката за вмъкване на данните в таблицата contacts
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    // Извличане на данните от POST заявката
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Изпълнение на заявката и проверка за грешки
    if ($stmt->execute()) {
        echo "<script>alert('Вашето съобщение е изпратено успешно!');</script>";
    } else {
        echo "<script>alert('Възникна грешка при изпращането на съобщението.');</script>";
    }

    // Затваряне на връзката с базата данни
    $stmt->close();
    $conn->close();
}
?>

    </div>
 

    <section class="contact">
        <div class="container2">
            <h2>Контакти</h2>
            <div class="contact-wrapper">
                <div class="contact-form">
                    <h3>Вашият отзив</h3>
                    <form method="post">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Вашето име:" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Вашата електронна поща:" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" placeholder="Вашето съобщение:" required></textarea>
                        </div>
                        <button type="submit">Изпрати</button>
                    </form>
                </div>
                <div class="contact-info">
                    <h3> Информация за връзка с нас:</h3>
                    <p> <i class="fas fa-phone"></i> +359 892 724 681</p>
                    <p> <i class="fas fa-envelope"></i> kristiyanradev19b</p>
                    <p> <i class="fas fa-map-marker"></i> Plovdiv,Bulgaria 4000</p>
                </div>
            </div>
        </div>
    </section>
    


       

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

</body>
</html>
