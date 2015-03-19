@extends('layouts.main')

@section('content')
<h1>За все время:</h1>
<h2>Комментарии:</h2>
<table class="table table-striped table-bordered">
    <tr>
        <td>Всего:</td>
        <td><?= $coutComments ?></td>
    </tr>
    <tr>
        <td>Среднее количество комментариев на пост:</td>
        <td><?= $averageComments ?></td>
    </tr>
    <tr>
        <td>Средняя оценка:</td>
        <td><?= $avgScoreTotalComments ?></td>
    </tr>
    <tr>
        <td>Положительных оценок:</td>
        <td><?= $sumScorePlusComments ?></td>
    </tr>
    <tr>
        <td>Отрицательных оценок:</td>
        <td><?= $sumScoreMinusComments ?></td>
    </tr>
    <tr>
        <td>Больше всего положительных оценок за комментарий:</td>
        <td><?= $maxScorePlusComments ?></td>
    </tr>
    <tr>
        <td>Больше всего отрицательных оценок за комментарий:</td>
        <td><?= $maxScoreMinusComments ?></td>
    </tr>

</table>
@stop