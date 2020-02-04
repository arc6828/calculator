<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<h1>ทำนายเบอร์</h1>
<form action="/calculator/index.php" method="GET">
    <input name="phone_number"  id="phone" placeholder="กรอกเบอร์โดยไม่ต้องใส่ -" value="<?= isset($_GET['phone_number']) ? $_GET['phone_number']  : '' ?>" required >
    <input name="date_of_birth"  id="date_of_birth" placeholder="วันเดือนปีเกิดของท่าน" type="date" value="<?= isset($_GET['date_of_birth']) ? $_GET['date_of_birth']  : '' ?>">
    <select name="slot"  id="slot">
        <option value="1">6.00 - 7.29</option>
        <option value="2">7.30 - 7.29</option>
        <option value="3">9.00 - 7.29</option>
        <option value="4">10.00 - 7.29</option>
        <option value="5">12.00 - 7.29</option>
        <option value="6">13.00 - 7.29</option>
    </select >
    <button>ทำนาย</button> 

</form>

<?php if( !empty($_GET['phone_number']) ){ ?>
    <h2>ผลลัพธ์</h2>
    <div class="row">
        <div class="col-lg-12">
            <?php $data = general($_GET['phone_number']); ?>
        
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 display">
            <h3>Grade</h3>
            <?php $data = grade($_GET['phone_number']); ?>
        </div>
        
        <div class="col-lg-6 display">
        
            <h3>Graph</h3>
            <?php $data = graph($_GET['phone_number']); ?>
            
            <canvas id="myChart" style="max-width: 600px; max-height : 600px;"></canvas>
        </div>
    </div>
    
<?php } ?>
<?php 
function general($phone_number){
    $date = $_GET['date_of_birth'];
    $time = floatval($_GET['hour'].".".$_GET['minute']);
    echo "<br>number : ". $phone_number;
    echo "<br>date : ". $date;
    echo "<br>time : ". $time;

    $d=date_create($date);
    echo "<br>Day Code : ". (date_format($d,"l")). " " .(date_format($d,"w")+1);

    //START
    $day_code = (date_format($d,"w")+1);
    $slot = $_GET['slot'];
    if($slot <9 ){
        $key = $day_code . "-day";
    }else{
        $key = $day_code . "-night";
    }
    /*
    $data = [
        "1-day" => [1,6,4,2,7,5,3,1],   "1-night" =>  [1,5,2,6,3,7,4,1],
        "2-day" => [1,6,4,2,7,5,3,1],   "2-night" =>  [1,5,2,6,3,7,4,1],
        "3-day" => [1,6,4,2,7,5,3,1],   "3-night" =>  [1,5,2,6,3,7,4,1],
        "4-day" => [1,6,4,2,7,5,3,1],   "4-night" =>  [1,5,2,6,3,7,4,1],
        "5-day" => [1,6,4,2,7,5,3,1],   "5-night" =>  [1,5,2,6,3,7,4,1],
        "6-day" => [1,6,4,2,7,5,3,1],   "6-night" =>  [1,5,2,6,3,7,4,1],
        "7-day" => [1,6,4,2,7,5,3,1],   "7-night" =>  [1,5,2,6,3,7,4,1],
    ];
    */
    
    $data = [
        "1-day" => [1,6,4,2,7,5,3,1],   "1-night" =>  [1,5,2,6,3,7,4,1],
        "2-day" => [1,6,4,2,7,5,3,1],   "2-night" =>  [1,5,2,6,3,7,4,1],
        "3-day" => [1,6,4,2,7,5,3,1],   "3-night" =>  [1,5,2,6,3,7,4,1],
        "4-day" => [1,6,4,2,7,5,3,1],   "4-night" =>  [1,5,2,6,3,7,4,1],
        "5-day" => [1,6,4,2,7,5,3,1],   "5-night" =>  [1,5,2,6,3,7,4,1],
        "6-day" => [1,6,4,2,7,5,3,1],   "6-night" =>  [1,5,2,6,3,7,4,1],
        "7-day" => [1,6,4,2,7,5,3,1],   "7-night" =>  [1,5,2,6,3,7,4,1],
    ];
    
    $a = $data[$key];
    print_r($a);

    echo "<br>slot : ". $slot;
    echo "<br>$a : ". $$slot;
}
?>

<?php 
function generate_pairs_array_for_grade($phone_number){
    $new_pairs = [
        $phone_number[8].$phone_number[9],  //HI(89)
        $phone_number[7].$phone_number[8],  //GH(78)
        $phone_number[6].$phone_number[7],  //FG(67)
        $phone_number[5].$phone_number[6],  //EF(56)
        $phone_number[4].$phone_number[5],  //DE(45)
        $phone_number[3].$phone_number[4],  //CD(34)
        $phone_number[2].$phone_number[3],  //BC(23)
    ];
    return $new_pairs;
    //$pairs = ["11","22","33","44","55","66","77"];;
}
function calculate_grade($percent){
    if($percent >= 95){
        //GRADE A+
        $grade = "A+";
    }
    else if($percent > 80){
        //GRADE A        
        $grade = "A";
    }
    else if($percent > 70){
        //GRADE B+
        $grade = "B+";
    }
    else if($percent > 60){
        //GRADE B        
        $grade = "B";
    }
    else if($percent > 50){
        //GRADE C+
        $grade = "C+";
    }
    else if($percent > 30){
        //GRADE C
        $grade = "C";
    }
    else{
        //GRADE D
        $grade = "D";
    }
    return $grade;
}
function calculate_score_for_grade($pairs){
    $number = intval($pairs);
    $green_set = [14,15,16,19,22,23,24,26,28,29,32,35,36,39,41,42,44,45,46,49,51,53,54,55,56,59,61,62,63,64,65,66,69,78,79,82,87,89,91,92,93,94,95,96,97,98,99];
    $yellow_set = [33,47,74];
    $red_set = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,17,18,20,21,25,27,30,31,34,37,38,40,43,48,50,52,57,58,60,67,68,70,71,72,73,75,76,77,80,81,83,84,85,86,88,90];
    if (in_array($number, $green_set)) {
        return 100;
    }
    else if (in_array($number, $yellow_set)) {
        return 50;
    }
    else if (in_array($number, $red_set)) {
        return 0;
    }
    return -1;
}
function grade($phone_number){

    $pairs_array = generate_pairs_array_for_grade($phone_number);
    echo "<br>PAIRS : ". join(", ",$pairs_array);

    //CALCULATE SCORE
    $scores = [];
    $sum_score = 0;
    foreach($pairs_array as $pairs){
        $s = calculate_score_for_grade($pairs);
        $scores[] = $s;
        $sum_score = $sum_score + $s;
    }    

    $percent = $sum_score / count($scores);
    $grade = calculate_grade($percent);
      
    echo "<br>SCORES : ". join(", ",$scores);
    echo  "<br> Percent : ".$percent;
    echo  "<br> Grade : ".$grade;

}

?>

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
    return rand(0,999);
}

function graph($phone_number){

    //จับคู่ 7 คู่
    $pairs_array = generate_pairs_array($phone_number);
    echo "<br>PAIRS : ". join(", ",$pairs_array);

    //CALCULATE SCORE
    $scores = [];
    //$sum_score = 0;
    foreach($pairs_array as $pairs){
        $s = calculate_score($pairs);
        $scores[] = $s;
        //$sum_score = $sum_score + $s;
    }
    //แสดงผลลัพธ์เช่น 999,466,900,543,245,778,900    
    echo "<br>SCORES : ". join(", ",$scores);
    //echo "<br>SUM : ". $sum_score;

    //CALCULATE PERCENT : MAX 1000
    //$percent = $sum_score / count($pairs_array) ;
    
    //CALCULATE GRADE
    //$grade = calculate_grade($percent);
    
    //echo "<br>percent : ". $percent;
    //echo "<br>Grade : ". $grade;
    return "[".join(", ",$scores)."]";
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">




<script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'radar',
    data: {
        labels: ['Money', 'Love', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            //data: [12, 19, 3, 5, 2, 3],
            data: <?= $data ?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>