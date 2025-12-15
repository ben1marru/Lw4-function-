<?php
// Вариант меню для выбора задачи
echo "Выберите задачу:\n";
echo "1. Сортировка строки по алфавиту\n";
echo "2. Поиск идеальных чисел в массиве\n";
echo "3. Поиск наиболее часто встречающегося слова\n";
echo "Введите номер задачи (1-3): ";

$handle = fopen("php://stdin", "r");
$choice = trim(fgets($handle));

switch ($choice) {
    case '1':
        // Ввод строки
        echo "Введите строку для сортировки: ";
        $inputStr = trim(fgets($handle));
        echo "Отсортированная строка: " . alphabeticalOrder($inputStr) . "\n";
        break;
    case '2':
        // Ввод массива чисел
        echo "Введите массив чисел через запятую: ";
        $inputNums = trim(fgets($handle));
        $arr = array_map('intval', explode(',', $inputNums));
        $perfects = findPerfectNumbers($arr);
        echo "Идеальные числа в массиве: " . (empty($perfects) ? "не найдено" : implode(', ', $perfects)) . "\n";
        break;
    case '3':
        // Ввод текста
        echo "Введите текст (не более 1000 символов): ";
        $text = trim(fgets($handle));
        echo "Самое часто встречающееся слово: " . mostRecent($text) . "\n";
        break;
    default:
        echo "Некорректный выбор.\n";
        break;
}

fclose($handle);

// Funktionen из предыдущего ответа:
// 1) Функция сортировки строк по алфавиту
function alphabeticalOrder($str) {
    $chars = str_split($str);
    sort($chars);
    return implode('', $chars);
}

// 2) Функция поиска идеального числа
function findPerfectNumbers($array) {
    $perfectNumbers = [];
    foreach ($array as $num) {
        if ($num <= 0 || !is_int($num)) continue;
        $divSum = 0;
        for ($i=1; $i <= $num/2; $i++) {
            if ($num % $i == 0) {
                $divSum += $i;
            }
        }
        if ($divSum == $num) {
            $perfectNumbers[] = $num;
        }
    }
    return $perfectNumbers;
}

// 3) Функция поиска наиболее часто встречающегося слова
function mostRecent($text) {
    if (strlen($text) > 1000) {
        $text = substr($text, 0, 1000);
    }
    $words = preg_split('/\W+/', strtolower($text), -1, PREG_SPLIT_NO_EMPTY);
    $frequency = [];
    foreach ($words as $word) {
        if (isset($frequency[$word])) {
            $frequency[$word]++;
        } else {
            $frequency[$word] = 1;
        }
    }
    $maxCount = 0;
    $mostFrequentWord = null;
    foreach ($frequency as $word => $count) {
        if ($count > $maxCount) {
            $maxCount = $count;
            $mostFrequentWord = $word;
        }
    }
    return $mostFrequentWord;
}
?>