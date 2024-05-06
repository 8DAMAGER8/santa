<?php

require(__DIR__ . '/layout/header.php')
?>

<h2>Страница для санты</h2>

    <form action="/get_recipient" method="post">
        <div>
            <label>
                Email Санты
                <input type="email" required minlength="4" name="email">
            </label>
        </div>
        <input type="submit" value="Узнать кому дарить">
    </form>
<?php
require(__DIR__ . '/layout/footer.php')
?>