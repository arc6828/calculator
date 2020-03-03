<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    
    <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"-->


    
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <title>Hello, world!</title>
        

  </head>
  <body>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <!--script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script-->
    
    
	<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <style>
    .number{
        width:50px;
    }
    </style>
    <div class="container">
        <h1>Phone Number</h1>
        <div class="row">
            <div class="col-lg-3">by ตำแหน่ง</div>
            <div class="col-lg-9">
                <input class="number"  name="number-0">
                <input class="number"  name="number-1">
                <input class="number"  name="number-2"> - 
                <input class="number"  name="number-3">
                <input class="number"  name="number-4">
                <input class="number"  name="number-5"> - 
                <input class="number"  name="number-6">
                <input class="number"  name="number-7">
                <input class="number"  name="number-8">
                <input class="number"  name="number-9">
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-3">by Price Range</div>
            <div class="col-lg-9">
                <select name="range" id="range">
                    <?php foreach([1000,1500,2000,2500,3000,3500,4000,4500,5000] as $price){ ?> 
                    <option value="<?=$price ?>">น้อยกว่า <?=$price ?></option>
                    <?php }?>
                </select>
            </div>
        </div>        
        
        <div class="row">
            <div class="col-lg-3">by ผลรวม</div>
            <div class="col-lg-9">
                <select name="sum" >
                    <?php for($i=9; $i<=81; $i++){ ?> 
                    <option value="<?=$i ?>"><?=$i ?></option>
                    <?php }?>
                </select>
            </div>
        </div>

        
        <div class="row">
            <div class="col-lg-3">by Operator</div>
            <div class="col-lg-9">
                <select name="operator" id="operator">
                    <?php foreach(["ais","dtac","truemove"] as $operator){ ?> 
                    <option value="<?=$operator ?>"><?=$operator ?></option>
                    <?php }?>
                </select>
            </div>
        </div>        

        <button id="submit">Submit</button>
        

        <script>
            document.querySelector("#submit").addEventListener("click", function(){
                let data = {
                    "operator": document.querySelector("#operator").value,
                }
                fetch('phone-number.php', {
                    method: 'POST', // or 'PUT'
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data),
                })
                
                    .then((response) => {
                        return response.json();
                    })
                    .then((myJson) => {
                        console.log(myJson);
                        let dataSet = [];
                        for(item of myJson){
                            dataSet.push([item.number , item.price , item.operator]);
                        }
                        
                        var table = $('#table').DataTable();

                        table.clear();
                        table.rows.add( dataSet ).draw();
                        
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });;
                //END FETCH
            });
        </script>

        <div class="table-responsive" >
            <table class="table table-sm"  id="table" style="width:100%">
            </table>
        </div>
            
        <script >
            $(document).ready(function() {
                //FETCH
                fetch('phone-number.php')
                    .then((response) => {
                        return response.json();
                    })
                    .then((myJson) => {
                        console.log(myJson);
                        let dataSet = [];
                        for(item of myJson){
                            dataSet.push([item.number , item.price , item.operator]);
                        }
                        
                        $('#table').DataTable({
                            "data": dataSet,
                            "deferRender" : true,
                            "columns": [
                                { title: "หมายเลข" },
                                { title: "ราคา" },
                                { title: "ค่ายมือถือ" },
                            ],
                            //deferRender: true,
                        });
                        
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
                //END FETCH
                
            } );

        </script>

    </div>
    
    
  </body>
</html>