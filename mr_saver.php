<?php
while (true) {
    try {
        file_put_contents(time() . '.html', file_get_contents('http://missrussia.ru/castings/miss906090/'));
        sleep(60);
    } catch (Exception $e) {

    }
}