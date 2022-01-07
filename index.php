<?php

$currentValue = 0;      #เซ็ตค่าปัจจุบันใน input
$input = [];        #สร้างอาเรย์เปล่าๆชื่อ input

function getInputAsString($values)
{
    $o = "";
    foreach ($values as $value) {
        $o .= $value;
    }

    // var_dump($number);
    return $o;
}

function calculateInput($userInput)
{
    // format user input
    $arr = [];
    $numArr = [];
    $char = "";
    foreach ($userInput as $num) {
        if (is_numeric($num) || $num == ".") {
            $char .= $num;
        } else if (!is_numeric($num)) {
            if (!empty($char)) {
                $numArr[] = $numArr + $arr;
                $arr[] = $char;
                $char = "";
            }
            $arr[] = $num;
        }
    }
    if (!empty($char)) {
        $arr[] = $char;
    }

    $countNum = strlen($num);
    // echo $countNum;
    $numArr[] = $countNum;
    // echo $numArr;

    // var_dump($arr);
    // echo "<br>";

    // echo count($numArr);

    $number = count($numArr);

    // calculate user input

    # คำนวณจาก input

    $current = 0;
    $action = null;
    for ($i = 0; $i <= count($arr) - 1; $i++) {
        if (is_numeric($arr[$i])) {
            if ($action) {
                if ($action == "+") {
                    $current = $current + $arr[$i];
                }
                if ($action == "-") {
                    $current = $current - $arr[$i];
                }
                if ($action == "x") {
                    $current = $current * $arr[$i];
                }
                if ($action == "/") {
                    $current = $current / $arr[$i];
                }
                $action = null;
            } else {
                if ($current == 0) {
                    $current = $arr[$i];
                }
            }
        } else {
            $action = $arr[$i];
        }
    }
    echo "<span class='ans'>ค่าเฉลี่ย = " . $current / $number . "</span>";
    return $current;
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['input'])) {
        $input = json_decode($_POST['input']);
    }



    if (isset($_POST)) {
        foreach ($_POST as $key => $value) {
            if ($key == 'equal') {      #หาคำตอบ
                // echo "equal";
                $currentValue = calculateInput($input);      #เรียกใช้ฟังก์ชั่น  
                $input = [];
                $input[] = $currentValue /*+ count($numArr)*/;
                // var_dump($input);
            } elseif ($key == "ce") {
                array_pop($input);
            } elseif ($key == "c") {
                $input = [];
                $currentValue = 0;
            } elseif ($key == "back") {
                $lastPointer = count($input) - 1;
                if (is_numeric($input[$lastPointer])) {
                    array_pop($input);
                }
            } elseif ($key != 'input') {
                $input[] = $value;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Calculator</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
</head>

<body>
    <h3>การหาค่าเฉลี่ย</h3>
    <!-- <a href="cal.php">my cal</a> -->
    <div class="container">
        <div class="item">
            <form method="post">
                <input type="hidden" name="input" value='<?php echo json_encode($input); ?>' /> <!-- เรียกตัวแปร $input = []; มาอ่านเป็น json -->
                <!-- <p class="title"><?php echo getInputAsString($input); ?></p> -->
                <div class="title">
                    
                </div>
                <!-- <input type="text" value="<?php echo $currentValue; ?>" /> -->
                <input class="input" type="text" value="<?php echo getInputAsString($input); ?>" />
                <table>
                    <tr>
                        <td><input class="button" type="submit" name="ce" value="CE" /></td>
                        <td><input class="button" type="submit" name="c" value="C" /></td>
                        <td><button type="submit" name="back" value="back">&#8592;</button></td>
                        <td><button type="submit" name="divide" value="/">&#247;</button></td>
                    </tr>
                    <tr>
                        <td><input class="button" type="submit" name="7" value="7" /></td>
                        <td><input class="button" type="submit" name="8" value="8" /></td>
                        <td><input class="button" type="submit" name="9" value="9" /></td>
                        <td><input class="button" type="submit" name="multiply" value="x" /></td>
                    </tr>
                    <tr>
                        <td><input class="button" type="submit" name="4" value="4" /></td>
                        <td><input class="button" type="submit" name="5" value="5" /></td>
                        <td><input class="button" type="submit" name="6" value="6" /></td>
                        <td><input class="button" type="submit" name="minus" value="-" /></td>
                    </tr>
                    <tr>
                        <td><input class="button" type="submit" name="1" value="1" /></td>
                        <td><input class="button" type="submit" name="2" value="2" /></td>
                        <td><input class="button" type="submit" name="3" value="3" /></td>
                        <td><input class="button" type="submit" name="add" value="+" /></td>
                    </tr>
                    <tr>
                        <td><button type="submit" name="average" value="x-">&#177;</button></td>
                        <td><input class="button" type="submit" name="zero" value="0" /></td>
                        <td><input class="button" type="submit" name="." value="." /></td>
                        <td><input class="button" type="submit" name="equal" value="=" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

</body>

</html>