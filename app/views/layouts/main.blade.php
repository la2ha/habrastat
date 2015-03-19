<!DOCTYPE html>
<html>
<head>
    <title>HabraStat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stylesheets('application')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<header role="banner" class="navbar  navbar-default habrastat-nav">
    <div class="container">
        <div class="navbar-header">
            <button data-target=".bs-navbar-collapse" data-toggle="collapse" type="button" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">HabraStat</a>
        </div>
        <nav role="navigation" class="collapse navbar-collapse bs-navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="/all">Все время</a>
                </li>
                <li>
                    <a href="/year">Год</a>
                </li>
                <li class="active">
                    <a href="/month">Месяц</a>
                </li>
                <li>
                    <a href="/week">Неделя</a>
                </li>
                <li>
                    <a href="/day">Сутки</a>
                </li>
                <li>
                    <a href="/anomalies">Аномалии</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="/about">О проекте</a>
                </li>
            </ul>
        </nav>
    </div>
</header>
<div class="container">
    <div class="row">
        <aside class="left_col col-md-2">
            <a href="/about#donate" class="btn btn-success btn-block">Поддержать проект</a>
            @yield('left_col')
        </aside>
        <div class="content col-md-10">
            @yield('content')
        </div>
    </div>
</div>


@javascripts('application')
</body>
</html>