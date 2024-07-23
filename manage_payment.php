<?php include 'db_connect.php' ?>
<?php 

// if(isset($_GET['id'])){
// 	$qry = $conn->query("SELECT * FROM payments where id=".$_GET['id']);
// 	foreach($qry->fetch_array() as $k => $val){
// 		$$k = $val;
// 	}
// }
$id = isset($_GET['id']) ? $_GET['id'] : 2;

$qry = $conn->query("SELECT * FROM payments where id=" . $id);
if ($qry) {
    foreach ($qry->fetch_array() as $k => $val) {
		// echo "Key: $k, Value: $val<br>"; 
        $$k = $val;
    }
} else {
    echo "Query failed: " . $conn->error; 
}

?>
<!-- <div class="container-fluid">
	<div class="col-lg-12">
		<form id="manage-payment">
			<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="" class="control-label">Loan Reference No.</label>
						<select name="loan_id" id="" class="custom-select browser-default select2">
							<option value=""></option>
						    <?php 
							$loan = $conn->query("SELECT * from loan_list where status =2 ");
							while($row=$loan->fetch_assoc()):
							?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($loan_id) && $loan_id == $row['id'] ? "selected" : '' ?>><?php echo $row['ref_no'] ?></option>
							<?php endwhile; ?>
						</select>
						
					</div>
				</div>
			</div>
			<div class="row" id="fields">
				
			</div>
		</form>
	</div>
</div> -->

<div class="container-fluid">
    <div class="col-lg-12">
        <form id="manage-payment">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="" class="control-label">Loan Reference No.</label>
                        <select name="loan_id" id="" class="custom-select browser-default select2">
                            <option value=""></option>
                            <?php 
                            $loan = $conn->query("SELECT * from loan_list where status =2 ");
                            while($row=$loan->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['id'] ?>" <?php echo isset($loan_id) && $loan_id == $row['id'] ? "selected" : '' ?>><?php echo $row['ref_no'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row" id="fields">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="payee" class="control-label">Payee</label>
                        <input type="text" name="payee" class="form-control" value="<?php echo isset($payee) ? $payee : '' ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="amount" class="control-label">Amount</label>
                        <input type="text" name="amount" class="form-control" value="<?php echo isset($amount) ? $amount : '' ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="penalty_amount" class="control-label">Penalty Amount</label>
                        <input type="text" name="penalty_amount" class="form-control" value="<?php echo isset($penalty_amount) ? $penalty_amount : '' ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="overdue" class="control-label">Overdue</label>
                        <input type="text" name="overdue" class="form-control" value="<?php echo isset($overdue) ? $overdue : '' ?>">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
	$('[name="loan_id"]').change(function(){
		load_fields()
	})
	$('.select2').select2({
		placeholder:"Please select here",
		width:"100%"
	})

	function load_fields(){
		start_load()
		$.ajax({
			url:'load_fields.php',
			method:"POST",
			data:{id:'<?php echo isset($id) ? $id : "" ?>',loan_id:$('[name="loan_id"]').val()},
			success:function(resp){
				if(resp){
					$('#fields').html(resp)
					end_load()
				}
			}
		})
	}
	//  $('#manage-payment').submit(function(e){
	//  	e.preventDefault()
	//  	// start_load()
	// 	 console.log('Resp');
	//  	$.ajax({
	//  		url:'ajax.php?action=save_payment',
	//  		method:'POST',
	//  		data:$(this).serialize(),
	//  		success:function(resp){
	// 			console.log('Resp');
	// 			console.log(resp);
	//  			if(resp == 1){
	//  				alert_toast("Payment data successfully saved.","success");
	//  				setTimeout(function(e){
	//  					location.reload()
	//  				},1500)
	//  			}
	//  		}
	//  	})
	//  })


	$('#manage-payment').submit(function(e){
    e.preventDefault();
    var formData = $(this).serialize();
    console.log('Form Data:', formData);
    start_load()
    $.ajax({
        url: 'ajax.php?action=save_payment',
        method: 'POST',
        data: formData,
        success: function(resp) {
            console.log('Response:', resp);
            if (resp == 1) {
                alert_toast("Payment data successfully saved.", "success");
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }
        },
        error: function(xhr, status, error) {
            console.log('Error:', error);
            console.log('Status:', status);
            console.dir(xhr);
        }
    });
});

	 $(document).ready(function(){
	 	if('<?php echo isset($_GET['id']) ?>' == 1)
		load_fields()
	 })
</script>