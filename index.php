<?php
    function send_mail($mail_to, $thema, $html, $path){
        if ($path) {
            $fp = fopen($path,"rb");
            if (!$fp)
            {
                exit();
            }
            $file = fread($fp, filesize($path));
            fclose($fp);
        }
        $name = "file.jpg"; // в этой переменной надо сформировать имя файла (без всякого пути)
        $EOL = "\r\n"; // ограничитель строк, некоторые почтовые сервера требуют \n - подобрать опытным путём
        $boundary     = "--".md5(uniqid(time()));  // любая строка, которой не будет ниже в потоке данных.
        $headers    = "MIME-Version: 1.0;$EOL";
        $headers   .= "Content-Type: multipart/mixed; boundary=\"$boundary\"$EOL";
        $headers   .= "From: cusot.com";

        $multipart  = "--$boundary$EOL";
        $multipart .= "Content-Type: text/html; charset=utf-8$EOL";
        $multipart .= "Content-Transfer-Encoding: base64$EOL";
        $multipart .= $EOL; // раздел между заголовками и телом html-части
        $multipart .= chunk_split(base64_encode($html));

        $multipart .=  "$EOL--$boundary$EOL";
        $multipart .= "Content-Type: application/octet-stream; name=\"$name\"$EOL";
        $multipart .= "Content-Transfer-Encoding: base64$EOL";
        $multipart .= "Content-Disposition: attachment; filename=\"$name\"$EOL";
        $multipart .= $EOL; // раздел между заголовками и телом прикрепленного файла
        $multipart .= chunk_split(base64_encode($file));

        $multipart .= "$EOL--$boundary--$EOL";

        if(!mail($mail_to, $thema, $multipart, $headers))
        {return False;           //если не письмо не отправлено
        }
        else { //// если письмо отправлено
            return True;
        }
    }
    if(isset($_POST['fullhouse__send'])) {
        $message = "";
        $messageTg = "";
        $roomsCount = null;
        if(isset($_POST['rooms'])){
            $roomsCount = $_POST['rooms'];
            $message .= "<h2>Total number of rooms:</h2>";
            $messageTg .= "Total number of rooms:\n";
            $message .= "<p>${roomsCount}</p>";
            $messageTg .= "${roomsCount}\n\n";
        }

        $roomsSize = null;
        if(isset($_POST['size'])){
            $roomsSize = $_POST['size'];
            $message .= "<h2>Size:</h2>";
            $messageTg .= "Size:\n";
            $message .= "<p>${roomsSize}М2</p>";
            $messageTg .= "${roomsSize}М2\n\n";
        }

        $message .= "<h2>Materials:</h2>";
        $messageTg .= "Materials:\n";
        $message .= "<p>";
        if(isset($_POST['laminate'])) {
            $message .= "laminate; ";
            $messageTg .= "laminate; ";
        }
        if(isset($_POST['parquet'])) {
            $message .= "parquet; ";
            $messageTg .= "parquet; ";
        }
        if(isset($_POST['naturalwood'])) {
            $message .= "natural wood; ";
            $messageTg .= "natural wood; ";
        }
        if(isset($_POST['tiled'])) {
            $message .= "tiled; ";
            $messageTg .= "tiled; ";
        }
        if(isset($_POST['naturalstone'])) {
            $message .= "natural stone; ";
            $messageTg .= "natural stone; ";
        }
        if(isset($_POST['venetianplaster'])) {
            $message .= "venetian plaster; ";
            $messageTg .= "venetian plaster; ";
        }
        if(isset($_POST['artisticplaster'])) {
            $message .= "artistic plaster; ";
            $messageTg .= "artistic plaster; ";
        }
        if(isset($_POST['marble'])) {
            $message .= "marble; ";
            $messageTg .= "marble; ";
        }
        $message .= "</p>";
        $messageTg .= "\n\n";

        $days = null;
        if(isset($_POST['days'])) {
            $days = $_POST['days'];
            $message .= "<h2>When do you plan to start renovation?</h2>";
            $messageTg .= "When do you plan to start renovation?\n";
            $message .= "<p>${days}</p>";
            $messageTg .= "${days}\n\n";
        }

        $budget = null;
        if(isset($_POST['noBudget'])) {
            $budget = "the budget has not yet been decided";
            $message .= "<h2>Planned budget:</h2>";
            $messageTg .= "Planned budget:\n";
            $message .= "<p>${budget}</p>";
            $messageTg .= "${budget}\n\n";
        }
        else {
            $budget = $_POST['budget'];
            $message .= "<h2>Planned budget:</h2>";
            $messageTg .= "Planned budget:\n";
            $message .= "<p>${budget}</p>";
            $messageTg .= "${budget}\n\n";
        }

        $firstname = $_POST['firstname'];
        $message .= "<h2>Name:</h2>";
        $messageTg .= "Name:\n";
        $message .= "<p>${firstname}</p>";
        $messageTg .= "${firstname}\n\n";

        $phone = $_POST['phone'];
        $message .= "<h2>Phone number:</h2>";
        $messageTg .= "Phone number:\n";
        $message .= "<p>${phone}</p>";
        $messageTg .= "${phone}\n\n";

        $address = $_POST['address'];
        $message .= "<h2>Address:</h2>";
        $messageTg .= "Address:\n";
        $message .= "<p>${address}</p>";
        $messageTg .= "${address}\n\n";

        $email = null;
        if(isset($_POST['email'])) {
            $email = $_POST['email'];
            $message .= "<h2>Email:</h2>";
            $messageTg .= "Email:\n";
            $message .= "<p>${email}</p>";
            $messageTg .= "${email}\n\n";
        }
        $comment = null;
        if(isset($_POST['comments'])) {
            $comment = $_POST['comments'];
            $message .= "<h2>Comments: </h2>";
            $messageTg .= "Comments:\n";
            $message .= "<p>${comment}</p>";
            $messageTg .= "${comment}\n\n";
        }


        $subject = "Quote.";

        $headers  = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: cusot.com\r\n";
        $headers .= "Reply-To: reply-to@example.com\r\n";

        // сюда нужно вписать токен вашего бота
        define('TELEGRAM_TOKEN', '1598668541:AAEgUhl3UUr0nJS6h5F_H3MkirVa8iiqsgE');
        // сюда нужно вписать ваш внутренний айдишник
        define('TELEGRAM_CHATID', '-1001188194749');

        function message_to_telegram($text)
        {
            $ch = curl_init();
            curl_setopt_array(
                $ch,
                array(
                    CURLOPT_URL => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage',
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_TIMEOUT => 10,
                    CURLOPT_POSTFIELDS => array(
                        'chat_id' => TELEGRAM_CHATID,
                        'text' => $text,
                    ),
                )
            );
            curl_exec($ch);
        }
        message_to_telegram($messageTg);

        mail("upndrey@yandex.ru", $subject, $message, $headers);
        header('Location: https://cusot.com/thanks/');
    }

    if(isset($_POST['partial__send'])) {
        $messageTg = "";
        $message = "";
        $message .= "<h2>Selected rooms:</h2>";
        $messageTg .= "Selected rooms:\n";

        $message .= "<p>";
        if(isset($_POST['bathroom'])) {
            $message .= "bathroom";
            $message .= "bathroom";
            $temp = $_POST['bathroomSize'];
            $message .= "(${temp}); ";
            $messageTg .= "(${temp}); ";
        }
        if(isset($_POST['bedroom'])) {
            $message .= "bedroom";
            $message .= "bedroom";
            $temp = $_POST['bedroomSize'];
            $message .= "(${temp}); ";
            $messageTg .= "(${temp}); ";
        }
        if(isset($_POST['hallway'])) {
            $message .= "hallway";
            $message .= "hallway";
            $temp = $_POST['hallwaySize'];
            $message .= "(${temp}); ";
            $messageTg .= "(${temp}); ";
        }
        if(isset($_POST['kitchen'])) {
            $message .= "kitchen";
            $message .= "kitchen";
            $temp = $_POST['kitchenSize'];
            $message .= "(${temp}); ";
            $messageTg .= "(${temp}); ";
        }
        if(isset($_POST['livingroom'])) {
            $message .= "living room";
            $message .= "living room";
            $temp = $_POST['livingroomSize'];
            $message .= "(${temp}); ";
            $messageTg .= "(${temp}); ";
        }
        if(isset($_POST['stairs'])) {
            $message .= "stairs";
            $message .= "living room";
            $temp = $_POST['stairsSize'];
            $message .= "(${temp}); ";
            $messageTg .= "(${temp}); ";
        }
        if(isset($_POST['extension'])) {
            $message .= "extension";
            $message .= "living room";
            $temp = $_POST['extensionSize'];
            $message .= "(${temp}); ";
            $messageTg .= "(${temp}); ";
        }
        if(isset($_POST['loft'])) {
            $message .= "loft";
            $message .= "living room";
            $temp = $_POST['loftSize'];
            $message .= "(${temp}); ";
            $messageTg .= "(${temp}); ";
        }
        if(isset($_POST['garage'])) {
            $message .= "Garage";
            $message .= "living room";
            $temp = $_POST['garageSize'];
            $message .= "(${temp}); ";
            $messageTg .= "(${temp}); ";
        }
        $message .= "</p>";
        $messageTg .= "\n\n";

        $materials = [];
        $message .= "<h2>Materials:</h2>";
        $messageTg .= "Materials:\n";

        $message .= "<p>";
        if(isset($_POST['laminate'])) {
            $message .= "laminate; ";
            $messageTg .= "laminate; ";
        }
        if(isset($_POST['parquet'])) {
            $message .= "parquet; ";
            $messageTg .= "parquet; ";
        }
        if(isset($_POST['naturalwood'])) {
            $message .= "natural wood; ";
            $messageTg .= "natural wood; ";
        }
        if(isset($_POST['tiled'])) {
            $message .= "tiled; ";
            $messageTg .= "tiled; ";
        }
        if(isset($_POST['naturalstone'])) {
            $message .= "natural stone; ";
            $messageTg .= "natural stone; ";
        }
        if(isset($_POST['venetianplaster'])) {
            $message .= "venetian plaster; ";
            $messageTg .= "venetian plaster; ";
        }
        if(isset($_POST['artisticplaster'])) {
            $message .= "artistic plaster; ";
            $messageTg .= "artistic plaster; ";
        }
        if(isset($_POST['marble'])) {
            $message .= "marble; ";
            $messageTg .= "marble; ";
        }
        $message .= "</p>";
        $messageTg .= "\n\n";

        $days = null;
        if(isset($_POST['days'])) {
            $days = $_POST['days'];
            $message .= "<h2>When do you plan to start renovation?</h2>";
            $messageTg .= "When do you plan to start renovation?\n";
            $message .= "<p>${days}</p>";
            $messageTg .= "${days}\n\n";
        }

        $budget = null;
        if(isset($_POST['noBudget'])) {
            $budget = "the budget has not yet been decided";
            $message .= "<h2>Planned budget:</h2>";
            $messageTg .= "Planned budget:\n";
            $message .= "<p>${budget}</p>";
            $messageTg .= "${budget}\n\n";
        }
        else {
            $budget = $_POST['budget'];
            $message .= "<h2>Planned budget:</h2>";
            $messageTg .= "Planned budget:\n";
            $message .= "<p>${budget}</p>";
            $messageTg .= "${budget}\n\n";
        }

        $firstname = $_POST['firstname'];
        $message .= "<h2>Name:</h2>";
        $messageTg .= "Name:\n";
        $message .= "<p>${firstname}</p>";
        $messageTg .= "${firstname}\n\n";

        $phone = $_POST['phone'];
        $message .= "<h2>Phone number:</h2>";
        $messageTg .= "Phone number:\n";
        $message .= "<p>${phone}</p>";
        $messageTg .= "${phone}\n\n";

        $address = $_POST['address'];
        $message .= "<h2>Address:</h2>";
        $messageTg .= "Address:\n";
        $message .= "<p>${address}</p>";
        $messageTg .= "${address}\n\n";

        $email = null;
        if(isset($_POST['email'])) {
            $email = $_POST['email'];
            $message .= "<h2>Email:</h2>";
            $messageTg .= "Email:\n";
            $message .= "<p>${email}</p>";
            $messageTg .= "${email}\n\n";
        }
        $comment = null;
        if(isset($_POST['comments'])) {
            $comment = $_POST['comments'];
            $message .= "<h2>Comments: </h2>";
            $messageTg .= "Comments:\n";
            $message .= "<p>${comment}</p>";
            $messageTg .= "${comment}\n\n";
        }


        $subject = "Quote.";

        $headers  = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: cusot.com\r\n";
        $headers .= "Reply-To: reply-to@example.com\r\n";


        // сюда нужно вписать токен вашего бота
        define('TELEGRAM_TOKEN', '1598668541:AAEgUhl3UUr0nJS6h5F_H3MkirVa8iiqsgE');
        // сюда нужно вписать ваш внутренний айдишник
        define('TELEGRAM_CHATID', '1018524645');

        function message_to_telegram($text)
        {
            $ch = curl_init();
            curl_setopt_array(
                $ch,
                array(
                    CURLOPT_URL => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage',
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_TIMEOUT => 10,
                    CURLOPT_POSTFIELDS => array(
                        'chat_id' => TELEGRAM_CHATID,
                        'text' => $text,
                    ),
                )
            );
            curl_exec($ch);
        }
        message_to_telegram($messageTg);


        mail("upndrey@yandex.ru", $subject, $message, $headers);
        header('Location: https://cusot.com/thanks/');
    }

    if(isset($_POST['maintenance__send'])) {
        $message = "";
        $messageTg = "";

        $message .= "<h2>Types of work:</h2>";
        $messageTg .= "Types of work:\n";
        $message .= "<p>";
        if(isset($_POST['carpenter'])) {
            $message .= "carpenter; ";
            $messageTg .= "carpenter; ";
        }
        if(isset($_POST['electrical'])) {
            $message .= "electrical; ";
            $messageTg .= "electrical; ";
        }
        if(isset($_POST['gas'])) {
            $message .= "gas; ";
            $messageTg .= "gas; ";
        }
        if(isset($_POST['gardener'])) {
            $message .= "gardener; ";
            $messageTg .= "gardener; ";
        }
        if(isset($_POST['generalbuilder'])) {
            $message .= "general builder; ";
            $messageTg .= "general builder; ";
        }
        if(isset($_POST['groutworker'])) {
            $message .= "grout worker; ";
            $messageTg .= "grout worker; ";
        }
        if(isset($_POST['painter'])) {
            $message .= "painter; ";
            $messageTg .= "painter; ";
        }
        if(isset($_POST['plumber'])) {
            $message .= "plumber; ";
            $messageTg .= "plumber; ";
        }
        $message .= "</p>";
        $messageTg .= "\n\n";

        $date = null;
        if(isset($_POST['date'])) {
            $date = $_POST['date'];
            $message .= "<h2>When do you plan to start renovation?</h2>";
            $messageTg .= "When do you plan to start renovation?\n";
            $message .= "<p>${date}</p>";
            $messageTg .= "${date}\n\n";
        }

        $time = null;
        if(isset($_POST['time'])) {
            $time = $_POST['time'];
            $message .= "<h2>Planned time:</h2>";
            $messageTg .= "Planned time:\n";
            $message .= "<p>${time}</p>";
            $messageTg .= "${time}\n\n";
        }

        $firstname = $_POST['firstname'];
        $message .= "<h2>Name:</h2>";
        $messageTg .= "Name:\n";
        $message .= "<p>${firstname}</p>";
        $messageTg .= "${firstname}\n\n";

        $phone = $_POST['phone'];
        $message .= "<h2>Phone number:</h2>";
        $messageTg .= "Phone number:\n";
        $message .= "<p>${phone}</p>";
        $messageTg .= "${phone}\n\n";

        $address = $_POST['address'];
        $message .= "<h2>Address:</h2>";
        $messageTg .= "Address:\n";
        $message .= "<p>${address}</p>";
        $messageTg .= "${address}\n\n";


        $email = null;
        if(isset($_POST['email'])) {
            $email = $_POST['email'];
            $message .= "<h2>Email:</h2>";
            $messageTg .= "Email:\n";
            $message .= "<p>${email}</p>";
            $messageTg .= "${email}\n\n";
        }
        $comment = null;
        if(isset($_POST['comments'])) {
            $comment = $_POST['comments'];
            $message .= "<h2>Comments: </h2>";
            $messageTg .= "Comments:\n";
            $message .= "<p>${comment}</p>";
            $messageTg .= "${comment}\n\n";
        }

        $picture = "";
        if (!empty($_FILES['photo']['tmp_name']))
        {
            // Закачиваем файл
            $path = $_FILES['photo']['name'];
            if (copy($_FILES['photo']['tmp_name'], $path)) $picture = $path;
        }


        $subject = "Quote.";
        $headers  = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: cusot.com\r\n";
        $headers .= "Reply-To: reply-to@example.com\r\n";


        // сюда нужно вписать токен вашего бота
        define('TELEGRAM_TOKEN', '1598668541:AAEgUhl3UUr0nJS6h5F_H3MkirVa8iiqsgE');
        // сюда нужно вписать ваш внутренний айдишник
        define('TELEGRAM_CHATID', '1018524645');

        function message_to_telegram($text)
        {
            $ch = curl_init();
            curl_setopt_array(
                $ch,
                array(
                    CURLOPT_URL => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage',
                    CURLOPT_POST => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_TIMEOUT => 10,
                    CURLOPT_POSTFIELDS => array(
                        'chat_id' => TELEGRAM_CHATID,
                        'text' => $text,
                    ),
                )
            );
            curl_exec($ch);
        }
        message_to_telegram($messageTg);

        if(empty($picture)) mail("upndrey@yandex.ru", $subject, $message, $headers);
        else send_mail("upndrey@yandex.ru", $subject, $message, $picture);
        header('Location: https://cusot.com/thanks/');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=320,initial-scale=1,maximum-scale=1,user-scalable=no"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <meta name="HandheldFriendly" content="true"/>
    <link rel="stylesheet" href="./styles/index.css">
    <title>Form</title>
</head>
<body>
<div class="form">
    <div class="form__header">
        <a href="#fullhouse" class="fullhouseLink">Full House</a>
        <a href="#partial" class="partialLink js_form__active">Partial</a>
        <a href="#maintenance" class="maintenanceLink">Maintenance</a>
    </div>
    <form method="post" action="https://cusot.com/thanks/" class="form__body fullhouse">
        <div class="formBody__roomsCount">
            <h2>Total number of rooms:</h2>
            <label for="fullhouse__rooms" class="js_rangeLabel">2</label>
            <input type="range" id="fullhouse__rooms" name="rooms" value="2" min="2" max="15">
        </div>
        <div class="formBody__size">
            <h2>Size:</h2>
            <label for="fullhouse__size" class="js_rangeLabel"><span>5</span> M²</label>
            <input type="range" id="fullhouse__size" name="size" value="5" min="5" max="500">
        </div>
        <div class="formBody__materials formBody__checkbox">
            <h2>Preferred materials:</h2>
            <div>
                <input type="checkbox" id="fullhouse__laminate" name="laminate">
                <label for="fullhouse__laminate">Laminate</label>
            </div>
            <div>
                <input type="checkbox" id="fullhouse__parquet" name="parquet">
                <label for="fullhouse__parquet">Parquet</label>
            </div>
            <div>
                <input type="checkbox" id="fullhouse__naturalwood" name="naturalwood">
                <label for="fullhouse__naturalwood">Natural wood</label>
            </div>
            <div>
                <input type="checkbox" id="fullhouse__tiled" name="tiled">
                <label for="fullhouse__tiled">Tiled</label>
            </div>
            <div>
                <input type="checkbox" id="fullhouse__naturalstone" name="naturalstone">
                <label for="fullhouse__naturalstone">Natural stone</label>
            </div>
            <div>
                <input type="checkbox" id="fullhouse__venetianplaster" name="venetianplaster">
                <label for="fullhouse__venetianplaster">Venetian Plaster</label>
            </div>
            <div>
                <input type="checkbox" id="fullhouse__artisticplaster" name="artisticplaster">
                <label for="fullhouse__artisticplaster">Artistic Plaster</label>
            </div>
            <div>
                <input type="checkbox" id="fullhouse__marble" name="marble">
                <label for="fullhouse__marble">Marble</label>
            </div>
        </div>
        <div class="formBody__date formBody__checkbox">
            <h2>When do you plan to start renovation?</h2>
            <div>
                <input type="radio" id="fullhouse__less7" name="days" value="up to 7 days">
                <label for="fullhouse__less7">up to 7 days</label>
            </div>
            <div>
                <input type="radio" id="fullhouse__less14" name="days" value="up to 14 days">
                <label for="fullhouse__less14">up to 14 days</label>
            </div>
            <div>
                <input type="radio" id="fullhouse__less30" name="days" value="up to 30 days">
                <label for="fullhouse__less30">up to 30 days</label>
            </div>
            <div>
                <input type="radio" id="fullhouse__more30" name="days" value="more than 30 days<">
                <label for="fullhouse__more30">more than 30 days</label>
            </div>
        </div>
        <div class="formBody__budget">
            <h2>Planned budget:</h2>
            <label for="fullhouse__budget" class="js_rangeLabel">£<span>20000</span></label>
            <input type="range" id="fullhouse__budget" name="budget" value="20000" min="20000" step="1000" max="350000">
        </div>
        <div class="formBody__checkbox">
            <div>
                <input type="checkbox" id="fullhouse__noBudget" name="noBudget" class="noBudget">
                <label for="fullhouse__noBudget">the budget has not yet been decided</label>
            </div>
        </div>
        <div class="formBody__text">
            <input type="text" placeholder="Your name*" name="firstname" class="firstname" required>
            <input type="tel" placeholder="Phone number*" name="phone" id="fullhouse__phone" required>
            <input type="text" placeholder="Full address & post code*" name="address" id="fullhouse__address" required>
            <input type="email" placeholder="Your e-mail" name="email" id="fullhouse__email">
            <textarea name="comments" cols="30" rows="10" maxlength="3000" placeholder="Your comment"></textarea>
        </div>
        <p>No spam, we promise. Your data will be processed according to our <a href="https://cusot.com/privacy-policy/">Privacy Policy</a>. You can unsubscribe at any time and we'll never share your details without your permission.</p>
        <input type="submit" name="fullhouse__send" value="Get a quote">
    </form>
    <form method="post" action="https://cusot.com/thanks/" class="form__body partial js_displaynone">
        <div class="formBody__rooms formBody__checkbox">
            <h2>Select rooms:</h2>
            <div>
                <input type="checkbox" id="partial__bathroom" name="bathroom">
                <label for="partial__bathroom">Bathroom</label>
            </div>
            <div>
                <input type="checkbox" id="partial__bedroom" name="bedroom">
                <label for="partial__bedroom">Bedroom</label>
            </div>
            <div>
                <input type="checkbox" id="partial__hallway" name="hallway">
                <label for="partial__hallway">Hallway</label>
            </div>
            <div>
                <input type="checkbox" id="partial__kitchen" name="kitchen">
                <label for="partial__kitchen">Kitchen</label>
            </div>
            <div>
                <input type="checkbox" id="partial__kidsroom" name="kidsroom">
                <label for="partial__kidsroom">Kids room</label>
            </div>
            <div>
                <input type="checkbox" id="partial__livingroom" name="livingroom">
                <label for="partial__livingroom">Living room</label>
            </div>
            <div>
                <input type="checkbox" id="partial__stairs" name="stairs">
                <label for="partial__stairs">Stairs</label>
            </div>
            <div>
                <input type="checkbox" id="partial__extension" name="extension">
                <label for="partial__extension">Extension</label>
            </div>
            <div>
                <input type="checkbox" id="partial__loft" name="loft">
                <label for="partial__loft">Loft</label>
            </div>
            <div>
                <input type="checkbox" id="partial__garage" name="garage">
                <label for="partial__garage">Garage</label>
            </div>
        </div>
        <div class="formBody__sizes">
            <h2>Room sizes: </h2>
            <span>Leave blank if you do not know the exact dimensions.</span>

            <div class="bathroomSize js_displaynone">
                <label for="partial__bathroomSize" class="js_rangeLabel">Bathroom: <span>5</span> M²</label>
                <input type="range" id="partial__bathroomSize" name="bathroomSize" value="5" min="5" max="100">
            </div>
            <div class="bedroomSize js_displaynone">
                <label for="partial__bedroomSize" class="js_rangeLabel">Bedroom: <span>5</span> M²</label>
                <input type="range" id="partial__bedroomSize" name="bedroomSize" value="5" min="5" max="100">
            </div>
            <div class="hallwaySize js_displaynone">
                <label for="partial__hallwaySize" class="js_rangeLabel">Hallway: <span>5</span> M²</label>
                <input type="range" id="partial__hallwaySize" name="hallwaySize" value="5" min="5" max="100">
            </div>
            <div class="kitchenSize js_displaynone">
                <label for="partial__kitchenSize" class="js_rangeLabel">Kitchen: <span>5</span> M²</label>
                <input type="range" id="partial__kitchenSize" name="kitchenSize" value="5" min="5" max="100">
            </div>
            <div class="kidsroomSize js_displaynone">
                <label for="partial__kidsroomSize" class="js_rangeLabel">Kids room: <span>5</span> M²</label>
                <input type="range" id="partial__kidsroomSize" name="kidsroomSize" value="5" min="5" max="100">
            </div>
            <div class="livingroomSize js_displaynone">
                <label for="partial__livingroomSize" class="js_rangeLabel">Living room: <span>5</span> M²</label>
                <input type="range" id="partial__livingroomSize" name="livingroomSize" value="5" min="5" max="100">
            </div>
            <div class="stairsSize js_displaynone">
                <label for="partial__stairsSize" class="js_rangeLabel">Stairs: <span>5</span> M²</label>
                <input type="range" id="partial__stairsSize" name="stairsSize" value="5" min="5" max="100">
            </div>
            <div class="extensionSize js_displaynone">
                <label for="partial__extensionSize" class="js_rangeLabel">Extension: <span>5</span> M²</label>
                <input type="range" id="partial__extensionSize" name="extensionSize" value="5" min="5" max="100">
            </div>
            <div class="loftSize js_displaynone">
                <label for="partial__loftSize" class="js_rangeLabel">Loft: <span>5</span> M²</label>
                <input type="range" id="partial__loftSize" name="loftSize" value="5" min="5" max="100">
            </div>
            <div class="garageSize js_displaynone">
                <label for="partial__garageSize" class="js_rangeLabel">Garage: <span>5</span> M²</label>
                <input type="range" id="partial__garageSize" name="garageSize" value="5" min="5" max="100">
            </div>
        </div>
        <div class="formBody__materials formBody__checkbox">
            <h2>Preferred materials:</h2>
            <div>
                <input type="checkbox" id="partial__laminate" name="laminate">
                <label for="partial__laminate">Laminate</label>
            </div>
            <div>
                <input type="checkbox" id="partial__parquet" name="parquet">
                <label for="partial__parquet">Parquet</label>
            </div>
            <div>
                <input type="checkbox" id="partial__naturalwood" name="naturalwood">
                <label for="partial__naturalwood">Natural wood</label>
            </div>
            <div>
                <input type="checkbox" id="partial__tiled" name="tiled">
                <label for="partial__tiled">Tiled</label>
            </div>
            <div>
                <input type="checkbox" id="partial__naturalstone" name="naturalstone">
                <label for="partial__naturalstone">Natural stone</label>
            </div>
            <div>
                <input type="checkbox" id="partial__venetianplaster" name="venetianplaster">
                <label for="partial__venetianplaster">Venetian Plaster</label>
            </div>
            <div>
                <input type="checkbox" id="partial__artisticplaster" name="artisticplaster">
                <label for="partial__artisticplaster">Artistic Plaster</label>
            </div>
            <div>
                <input type="checkbox" id="partial__marble" name="marble">
                <label for="partial__marble">Marble</label>
            </div>
        </div>
        <div class="formBody__date formBody__checkbox">
            <h2>When do you plan to start renovation?</h2>
            <div>
                <input type="radio" id="partial__less7" name="days" value="up to 7 days">
                <label for="partial__less7">up to 7 days</label>
            </div>
            <div>
                <input type="radio" id="partial__less14" name="days" value="up to 14 days">
                <label for="partial__less14">up to 14 days</label>
            </div>
            <div>
                <input type="radio" id="partial__less30" name="days" value="up to 30 days">
                <label for="partial__less30">up to 30 days</label>
            </div>
            <div>
                <input type="radio" id="partial__more30" name="days" value="more than 30 days">
                <label for="partial__more30">more than 30 days</label>
            </div>
        </div>
        <div class="formBody__budget">
            <h2>Planned budget:</h2>
            <label for="partial__budget" class="js_rangeLabel">£<span>1500</span></label>
            <input type="range" id="partial__budget" name="budget" value="1500" min="1500" step="500" max="350000">
        </div>
        <div class="formBody__checkbox">
            <div>
                <input type="checkbox" id="partial__noBudget" name="noBudget" class="noBudget">
                <label for="partial__noBudget">the budget has not yet been decided</label>
            </div>
        </div>
        <div class="formBody__text">
            <input type="text" placeholder="Your name*" name="firstname" class="firstname" required>
            <input type="tel" placeholder="Phone number*" name="phone" id="partial__phone" required>
            <input type="text" placeholder="Full address & post code*" name="address" id="partial__address" required>
            <input type="email" placeholder="Your e-mail" name="email" id="partial__email">
            <textarea name="comments" cols="30" rows="10" maxlength="3000" placeholder="Your comment"></textarea>
        </div>
        <p>No spam, we promise. Your data will be processed according to our <a href="https://cusot.com/privacy-policy/">Privacy Policy</a>. You can unsubscribe at any time and we'll never share your details without your permission.</p>
        <input type="submit" name="partial__send" value="Get a quote">
    </form>
    <form method="post" action="https://cusot.com/thanks/" enctype="multipart/form-data" class="form__body formBody maintenance js_displaynone">
        <div class="formBody__work formBody__checkbox">
            <h2>Types of work:</h2>
            <div>
                <input type="checkbox" id="maintenance__carpenter" name="carpenter">
                <label for="maintenance__carpenter">Carpenter</label>
            </div>
            <div>
                <input type="checkbox" id="maintenance__electrical" name="electrical">
                <label for="maintenance__electrical">Electrical</label>
            </div>
            <div>
                <input type="checkbox" id="maintenance__gas" name="gas">
                <label for="maintenance__gas">Gas</label>
            </div>
            <div>
                <input type="checkbox" id="maintenance__gardener" name="gardener">
                <label for="maintenance__gardener">Gardener</label>
            </div>
            <div>
                <input type="checkbox" id="maintenance__generalbuilder" name="generalbuilder">
                <label for="maintenance__generalbuilder">General builder</label>
            </div>
            <div>
                <input type="checkbox" id="maintenance__groutworker" name="groutworker">
                <label for="maintenance__groutworker">Grout worker</label>
            </div>
            <div>
                <input type="checkbox" id="maintenance__painter" name="painter">
                <label for="maintenance__painter">Painter</label>
            </div>
            <div>
                <input type="checkbox" id="maintenance__plumber" name="plumber">
                <label for="maintenance__plumber">Plumber</label>
            </div>
        </div>
        <div class="formBody__photo">
            <h2>Attach a photo:</h2>
            <input type="file" name="photo" id="maintenance__photo" placeholder="Photo">
        </div>
        <div class="formBody__datePicker">
            <h2>When do you plan to start renovation?</h2>
            <input type="date" name="date" id="maintenance__date">
        </div>
        <div class="formBody__time formBody__checkbox">
            <h2>Planned time:</h2>
            <div>
                <input type="radio" id="maintenance__am" name="time" value="up to 12 am">
                <label for="maintenance__am">up to 12 am</label>
            </div>
            <div>
                <input type="radio" id="maintenance__pm" name="time" value="after 12 pm">
                <label for="maintenance__pm">after 12 pm</label>
            </div>
        </div>
        <div class="formBody__text">
            <input type="text" placeholder="Your name*" name="firstname" class="firstname" required>
            <input type="tel" placeholder="Phone number*" name="phone" id="maintenance__phone" required>
            <input type="text" placeholder="Full address & post code*" name="address" id="maintenance__address" required>
            <input type="email" placeholder="Your e-mail" name="email" id="maintenance__email">
            <textarea name="comments" cols="30" rows="10" maxlength="3000" placeholder="Your comment"></textarea>
        </div>
        <p>No spam, we promise. Your data will be processed according to our <a href="https://cusot.com/privacy-policy/">Privacy Policy</a>. You can unsubscribe at any time and we'll never share your details without your permission.</p>
        <input type="submit" name="maintenance__send" value="Get a quote">
    </form>
</div>
<script>
    function formPages() {
        let currFormPage = location.hash;
        let fullhouseDom = document.querySelector(".fullhouse");
        let partialDom = document.querySelector(".partial");
        let maintenanceDom = document.querySelector(".maintenance");
        let fullhouseLinkDom = document.querySelector(".fullhouseLink");
        let partialLinkDom = document.querySelector(".partialLink");
        let maintenanceLinkDom = document.querySelector(".maintenanceLink");
        if( fullhouseDom &&
            partialDom &&
            maintenanceDom &&
            fullhouseLinkDom &&
            partialLinkDom &&
            maintenanceLinkDom) {
            if(currFormPage) {
                switch (currFormPage) {
                    case "#fullhouse":
                        fullhouseDom.classList.remove("js_displaynone");
                        partialDom.classList.add("js_displaynone");
                        maintenanceDom.classList.add("js_displaynone");

                        fullhouseLinkDom.classList.add("js_form__active");
                        partialLinkDom.classList.remove("js_form__active");
                        maintenanceLinkDom.classList.remove("js_form__active");
                        break;
                    case "#partial":
                        fullhouseDom.classList.add("js_displaynone");
                        partialDom.classList.remove("js_displaynone");
                        maintenanceDom.classList.add("js_displaynone");

                        fullhouseLinkDom.classList.remove("js_form__active");
                        partialLinkDom.classList.add("js_form__active");
                        maintenanceLinkDom.classList.remove("js_form__active");
                        break;
                    case "#maintenance":
                        fullhouseDom.classList.add("js_displaynone");
                        partialDom.classList.add("js_displaynone");
                        maintenanceDom.classList.remove("js_displaynone");

                        fullhouseLinkDom.classList.remove("js_form__active");
                        partialLinkDom.classList.remove("js_form__active");
                        maintenanceLinkDom.classList.add("js_form__active");
                        break;
                }
            }
            else {
                if(fullhouseLinkDom.classList.contains("js_form__active")) {
                    fullhouseDom.classList.remove("js_displaynone");
                    partialDom.classList.add("js_displaynone");
                    maintenanceDom.classList.add("js_displaynone");
                }
                else if(partialLinkDom.classList.contains("js_form__active")) {
                    fullhouseDom.classList.add("js_displaynone");
                    partialDom.classList.remove("js_displaynone");
                    maintenanceDom.classList.add("js_displaynone");
                }
                else if(maintenanceLinkDom.classList.contains("js_form__active")) {
                    fullhouseDom.classList.add("js_displaynone");
                    partialDom.classList.add("js_displaynone");
                    maintenanceDom.classList.remove("js_displaynone");
                }
            }
        }
    }
    document.addEventListener("DOMContentLoaded", function () {
        formPages();
        window.addEventListener('popstate', formPages);

        let jsRangeLabelDom = document.querySelectorAll(".js_rangeLabel");
        if(jsRangeLabelDom.length) {
            jsRangeLabelDom.forEach(function (label) {
                let input = label.nextElementSibling;
                if(input.tagName === "INPUT") {
                    input.addEventListener("input", function (e) {
                        let span = label.getElementsByTagName("span");
                        if(span.length)
                            span[0].innerText = input.value;
                        else
                            label.innerText = input.value;
                    });
                }
            });
        }

        let partialRooms = document.querySelectorAll(".formBody__rooms>div>input");
        if(partialRooms.length) {
            partialRooms.forEach(function (room) {
                room.addEventListener("input", function (e) {
                    switch (room.name) {
                        case "bathroom":
                            document.querySelector(".bathroomSize").classList.toggle("js_displaynone");
                            break;
                        case "bedroom":
                            document.querySelector(".bedroomSize").classList.toggle("js_displaynone");
                            break;
                        case "hallway":
                            document.querySelector(".hallwaySize").classList.toggle("js_displaynone");
                            break;
                        case "kitchen":
                            document.querySelector(".kitchenSize").classList.toggle("js_displaynone");
                            break;
                        case "kidsroom":
                            document.querySelector(".kidsroomSize").classList.toggle("js_displaynone");
                            break;
                        case "livingroom":
                            document.querySelector(".livingroomSize").classList.toggle("js_displaynone");
                            break;
                        case "stairs":
                            document.querySelector(".stairsSize").classList.toggle("js_displaynone");
                            break;
                        case "extension":
                            document.querySelector(".extensionSize").classList.toggle("js_displaynone");
                            break;
                        case "loft":
                            document.querySelector(".loftSize").classList.toggle("js_displaynone");
                            break;
                        case "garage":
                            document.querySelector(".garageSize").classList.toggle("js_displaynone");
                            break;
                    }
                });
            });
        }
        let noBudjetPartialDom = document.getElementById("partial__noBudget");
        if(noBudjetPartialDom) {
            noBudjetPartialDom.addEventListener("input", function (e) {
                let budjetPartialDom = document.getElementById("partial__budget");
                budjetPartialDom.parentElement.classList.toggle("displaynone");
            });
        }

        let noBudjetFullhouseDom = document.getElementById("fullhouse__noBudget");
        if(noBudjetFullhouseDom) {
            noBudjetFullhouseDom.addEventListener("input", function (e) {
                let budjetFullhouseDom = document.getElementById("fullhouse__budget");
                budjetFullhouseDom.parentElement.classList.toggle("displaynone");
            });
        }
    });
</script>
</body>
</html>


