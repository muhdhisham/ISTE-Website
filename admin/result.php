<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
// echo "<script>alert('Hello');</script>";
if(isset($_POST['submit']))
{
$name=$_POST['name'];
$sql ="SELECT * FROM users WHERE name=:name";
$query= $dbh -> prepare($sql);
$query-> bindParam(':name', $name, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
	include('includes/header.php');?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>Search Results</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
  <style>

	.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
	background: #dd3d36;
	color:#fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
	background: #5cb85c;
	color:#fff;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}

		</style>

</head>

<body>

<div class="ts-main-content">
	<?php include('includes/leftbar.php');
	// echo "<script>alert('Correct Details');</script>";?>
	
	<div class="content-wrapper">
		<div class="container-fluid">

			<div class="row">
				<div class="col-sm-1 col-lg-12 col-md-12">

					<h2 class="page-title">Results for <?php echo htmlentities($name);?></h2>

					<!-- Zero Configuration Table -->
					<div class="panel panel-default">
						<div class="panel-heading">List</div>
						<div class="panel-body">
						<?php if($error){?><div class="errorWrap" id="msgshow"><?php echo htmlentities($error); ?> </div><?php } 
			else if($msg){?><div class="succWrap" id="msgshow"><?php echo htmlentities($msg); ?> </div><?php }?>
							<table id="zctb" class="display table table-striped table-bordered table-hover table-responsive-md table-responsive-sm" cellspacing="0" width="100%">
								<thead>
									<tr>
									<th>#</th>
											<th>Name</th>
											<th>Email</th>
											<th>Branch</th>
											<th>Batch</th>
											<th>Phone</th>
											<th>Pref 1</th>
											<th>Pref 2</th>
											<th>Pref 3</th>
											<th>Pref 4</th>
											<th>Why</th>
											<th>Text</th>
									</tr>
								</thead>
    <?php foreach($results as $result){?>
								
								<tbody>
									<tr>
										<td><?php echo htmlentities($cnt);?></td>
										<td><?php echo htmlentities($result->name);?></td>
										<td><?php echo htmlentities($result->email);?></td>
										<td><?php echo htmlentities($result->branch);?></td>
										<td><?php echo htmlentities($result->batch);?></td>
										<td><?php echo htmlentities($result->mobile);?></td>
										<td><?php echo htmlentities($result->prefa);?></td>
										<td><?php echo htmlentities($result->prefb);?></td>
										<td><?php echo htmlentities($result->prefc);?></td>
										<td><?php echo htmlentities($result->prefd);?></td>
										<td><?php echo htmlentities($result->why);?></td>
										<td><?php echo htmlentities($result->text);?></td>
										<td>
										
										<?php if($result->status == 1)
												{?>
												<a href="userlist.php?confirm=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to UnConfirm the Account')">Confirmed <i class="fa fa-check-circle"></i></a> 
												<?php } else {?>
												<a href="userlist.php?unconfirm=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Confirm the Account')">Un-Confirmed <i class="fa fa-times-circle"></i></a>
												<?php } ?>
												<br>
												<a href="edit-user.php?edit=<?php echo $result->id;?>" onclick="return confirm('Do you want to Edit');">&nbsp; <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
												<a href="userlist.php?del=<?php echo $result->id;?>&name=<?php echo htmlentities($result->email);?>" onclick="return confirm('Do you want to Delete');"><i class="fa fa-trash" style="color:red"></i></a>&nbsp;&nbsp;
										</td>
									</tr>
									<?php $cnt=$cnt+1;}
}else{
  echo "<script>alert('Invalid Details');</script>";
  header('location:search.php');
}}?>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
</body>
</html>
<?php }?>
