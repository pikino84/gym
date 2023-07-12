<?php
function getWeekNumber($date)
{
    // Obtener el primer día del año
    $firstDayOfYear = date('Y-01-01', strtotime($date));

    // Obtener el día de la semana del primer día del año (0 para domingo, 1 para lunes, etc.)
    $firstDayOfWeek = date('w', strtotime($firstDayOfYear));

    // Calcular el número de días hasta el primer lunes del año
    $daysToFirstMonday = (8 - $firstDayOfWeek) % 7;

    // Calcular la fecha del primer lunes del año
    $firstMondayOfYear = date('Y-m-d', strtotime($firstDayOfYear . ' +' . $daysToFirstMonday . ' days'));

    // Calcular la diferencia en días entre la fecha dada y el primer lunes del año
    $daysDiff = floor((strtotime($date) - strtotime($firstMondayOfYear)) / (60 * 60 * 24));

    // Calcular el número de semanas sumando 1 y dividiendo entre 7
    $weekNumber = floor($daysDiff / 7) + 1;

    return $weekNumber;
}