<?php

$currentValue = 0;      #เซ็ตค่าปัจจุบันใน input

$input = [];        #สร้างอาเรย์เปล่าๆชื่อ input

function getInputAsString($values)
{
    $o = "";
    foreach ($values as $value) {
        $o .= $value;
    }
    return $o;
}

function calculateInput($userInput){
    //format user input
    $arr = [];
    $char = "";
    foreach ($userInput as $num) {
        if (is_numeric($num) || $num == ".") {
            $char .= $num;
        } else if (!is_numeric($num)) {
            if (!empty($char)) {
                $arr[] = $char;
                $char = "";
            }
            $arr[] = $num;
        }
    }
    if (!empty($char)) {
        $arr[] = $char;
    }
    // var_dump($arr); 
    // echo count($arr);

    # คำนวณจาก input

    $current = 0;
    $action = null; 
    for($i = 0; $i <= count($arr)-1; $i++){
        if(is_numeric($arr[$i])){
            if($action){
                if($action == "+"){
                    $current = $current + $arr[$i];
                }
            }else{
                if($current == 0){
                    $current = $arr[$i];
                }
            }
            $action = null;
        }else{
            $action = $arr[$i];
        }
    }
    return $current;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST['input'])){
        $input = json_decode($_POST['input']);
    }

    if(isset($_POST)){
        foreach ($_POST as $key => $value){
            if($key == 'equal'){        #หาคำตอบ
                // echo "equal";
                $currentValue = calculateInput($input);   #เรียกใช้ฟังก์ชั่น  
            }
            if($key != 'input'){
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
    <style>
        .container {
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 5px;
            display: inline-block;
        }
        .title{
            padding: 3px;
            margin: 0;
            min-height: 20px;
        }
    </style>
</head>

<body>
    <h3>My Calculator</h3>
    <div class="container">
        <form method="post">
            
            <input type="hidden" name="input" value='<?php echo json_encode($input); ?>' />     <!-- เรียกตัวแปร $input = []; มาอ่านเป็น json -->
            <p class="title"><?php echo getInputAsString($input); ?></p>
            <input type="text" value="<?php echo $currentValue; ?>" />
            <table>
                <tr>
                    <td><input type="submit" name="ce" value="CE" /></td>
                    <td><input type="submit" name="c" value="C" /></td>
                    <td><button type="submit" name="back" value="back">&#8592;</button></td>
                    <td><button type="submit" name="divide" value="/">&#247;</button></td>
                </tr>
                <tr>
                    <td><input type="submit" name="7" value="7" /></td>
                    <td><input type="submit" name="8" value="8" /></td>
                    <td><input type="submit" name="9" value="9" /></td>
                    <td><input type="submit" name="multiply" value="x" /></td>
                </tr>
                <tr>
                    <td><input type="submit" name="4" value="4" /></td>
                    <td><input type="submit" name="5" value="5" /></td>
                    <td><input type="submit" name="6" value="6" /></td>
                    <td><input type="submit" name="minus" value="-" /></td>
                </tr>
                <tr>
                    <td><input type="submit" name="1" value="1" /></td>
                    <td><input type="submit" name="2" value="2" /></td>
                    <td><input type="submit" name="3" value="3" /></td>
                    <td><input type="submit" name="add" value="+" /></td>
                </tr>
                <tr>
                    <td><button type="submit" name="plusminus" value="plusminus">&#177;</button></td>
                    <td><input type="submit" name="zero" value="0" /></td>
                    <td><input type="submit" name="." value="." /></td>
                    <td><input type="submit" name="equal" value="=" /></td>
                </tr>
            </table>
        </form>
    </div>

</body>

</html>