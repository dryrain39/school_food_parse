<?php

/*
 * made by Waterticket
 * matthew218@naver.com
 * 
 * edit by heptagonkr
 * 
 */

$schoolCode = ""; //학교 코드
$officeCode = ""; //교육청 코드
$schoolTypeCode = ""; //학교 분류 코드
$mealType = ""; //급식 종류 코드
$schYmd = date("Y.m.d", mktime(0, 0, 0, date("m"), date("d"), date("Y"))); //오늘 날짜
$food_url = 'http://stu.' . $officeCode . '/sts_sci_md01_001.do?schulCode=' . $schoolCode . '&schulCrseScCode=' . $schoolTypeCode . '&schMmealScCode=' . $mealType . '&schYmd=' . $schYmd;
$text = file_get_contents($food_url);

// 1=일, 2=월, 3=화, 4=수, 5=목, 6=금, 7=토

// 표 자르기
$text = explode('<th scope="col">식재료</th>', $text)[0];
$text = explode('<th scope="row">중식</th>', $text)[1];

// 일별로 자르기
$text = explode('<td class="textC', $text);

$meal = [];

foreach ($text as $VIP => $val) {
    // 문자열 정리
    $val = str_replace('<br />', "\n", $val);
    $val = str_replace('">', "", $val);
    $val = str_replace('last', "", $val);

    // 앞, 뒤 공백 제거
    $val = trim($val);

    // 문자열 정리
    $val = explode('</td>', $val)[0];

    if ($val != NULL) {
        $meal[$VIP] = $val;
    } else {
        $meal[$VIP] = "급식이 없습니다.";
    }
}

print_r($meal);
