@extends('layouts.main')

@section('content')
<h1>О проекте:</h1>
<h2 id="donate">Поддержать проект</h2>

<p>
    Если Вам понравился проект и есть желание поддержать его материально можете воспользоваться любой из кнопочек
    ниже.<br>
    Я буду очень благодарен.
</p>

<div class="row">
    <div class="col-md-3">
        <h3>PayPal</h3>

        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="GQH2WFPKL5P5J">
            <input type="image" src="https://www.paypalobjects.com/en_US/RU/i/btn/btn_donateCC_LG.gif" border="0"
                   name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>
    </div>
    <div class="col-md-7">
        <h3>Яндекс.Деньги</h3>
        <iframe frameborder="0" allowtransparency="true" scrolling="no"
                src="https://money.yandex.ru/embed/donate.xml?uid=410012031980312&amp;default-sum=100&amp;targets=%D0%A0%D0%B0%D0%B7%D0%B2%D0%B8%D1%82%D0%B8%D0%B5+%D0%B8+%D0%BF%D0%BE%D0%B4%D0%B4%D0%B5%D1%80%D0%B6%D0%B0%D0%BD%D0%B8%D0%B5+%D0%BF%D1%80%D0%BE%D0%B5%D0%BA%D1%82%D0%B0&amp;target-visibility=on&amp;project-name=&amp;project-site=&amp;button-text=05&amp;hint="
                width="450" height="104"></iframe>
    </div>
</div>
@stop