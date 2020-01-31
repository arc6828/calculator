<h1>ทำนายเบอร์</h1>
<form action="/calculator/index.php" method="GET">
    <input name="phone_number"  id="phone" placeholder="กรอกเบอร์โดยไม่ต้องใส่ -" value="<?= $_GET['phone_number'] ?>">
    <button>ทำนาย</button> 

</form>

<?php if( !empty($_GET['phone_number']) ){ ?>
    <h2>ผลลัพธ์</h2>
    
    <div class="display">
        <?php calculate($_GET['phone_number']); ?>
    </div>
<?php } ?>

<?php
function generate_pairs_array($phone_number){
    $new_pairs = [
        $phone_number[8].$phone_number[9],  //HI(89)
        $phone_number[7].$phone_number[9],  //GI(79)
        $phone_number[6].$phone_number[9],  //FI(69)
        $phone_number[5].$phone_number[9],  //EI(59)
        $phone_number[3].$phone_number[9],  //CI(39)
        $phone_number[1].$phone_number[9],  //AI(19)
    ];
    return $new_pairs;
    //$pairs = ["11","22","33","44","55","66","77"];;
}

function calculate_score($pairs){
    return rand(-999,999);
}
function calculate_grade($sum_score_percent){
    if($sum_score_percent > 950){
        //GRADE A+
        $grade = "A+";
    }
    else if($sum_score_percent > 750){
        //GRADE A        
        $grade = "A";
    }
    else if($sum_score_percent > 500){
        //GRADE B
        $grade = "B";
    }
    else if($sum_score_percent > 200){
        //GRADE C        
        $grade = "C";
    }
    else if($sum_score_percent > 0){
        //GRADE D
        $grade = "D";
    }
    else if($sum_score_percent <= 0){
        //GRADE F
        $grade = "F";
    }
    return $grade;
}
function calculate($phone_number){

    //จับคู่ 7 คู่
    $pairs_array = generate_pairs_array($phone_number);
    echo "<br>PAIRS : ". join(", ",$pairs_array);

    //CALCULATE SCORE
    $scores = [];
    $sum_score = 0;
    foreach($pairs_array as $pairs){
        $s = calculate_score($pairs);
        $scores[] = $s;
        $sum_score = $sum_score + $s;
    }
    //แสดงผลลัพธ์เช่น 999,466,900,543,245,778,900    
    echo "<br>SCORES : ". join(", ",$scores);
    echo "<br>SUM : ". $sum_score;

    //CALCULATE PERCENT : MAX 1000
    $sum_score_percent = $sum_score / count($pairs_array) * 1000;
    
    //CALCULATE GRADE
    $grade = calculate_grade($sum_score_percent);
    echo "<br>Grade : ". $grade;

}
?>