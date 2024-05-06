<?php

require(__DIR__ . '/layout/header.php')
?>
<h2>Страница для добавления пользователя</h2>
    <form action="/message" method="post">
        <div>
            <label>
                Имя
                <input type="text" required minlength="2" name="name">
            </label>
        </div>
        <div>
            <label>
                Email
                <input type="email" required minlength="4" name="email">
            </label>
        </div>
        <input type="submit" value="Добавить">
    </form>
<?php
require(__DIR__ . '/layout/footer.php')
?>