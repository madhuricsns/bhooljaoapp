<?php /*$sessiondata=$this->session->userdata('logged_in');
	#print_r($sessiondata);exit;
$session_admin_id=$sessiondata['admin_id']; 
$session_admin_name=$sessiondata['admin_name'];
$session_user_type=$sessiondata['user_type'];
$session_subroles=$sessiondata['subroles'];

if($session_user_type=="Subadmin" && $session_subroles!="NULL")
{
	$modulesId=$this->Admin_model->getmodulelist($session_subroles);
} 
*/
#echo $this->db->last_query();
 #echo '<pre>';print_r($modulesId);exit;
?>
<div class="page-body">
	
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>DEMO-BOOKINGS </h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								<a class="btn btn-default"  href="<?php echo base_url();?>backend/Booking/exportBookingDemoCSV" style="float:right"><i class="fa fa-download"></i>Export CSV</a>
							</div>
							</div>
						</div>	 
					</div>
					<div class="card-body">
						<?php if($this->session->flashdata('success')!=""){?>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $this->session->flashdata('success');?>
						</div>
						<?php }?>
				
						<?php if($this->session->flashdata('error')!=""){?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $this->session->flashdata('error');?>
						</div>
						<?php }?>
						<?php if($this->session->flashdata('error_msg')!=""){?>
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $this->session->flashdata('error_msg');?>
						</div>
						<?php }?>	



						 <form method="POST" action="<?php echo base_url().'backend/Booking/searchdemo_list/'; ?><?php if($this->uri->segment(4)!=""){ echo $this->uri->segment(4);}?>/
								<?php if($this->uri->segment(5)!=""){ echo $this->uri->segment(5);}?>/
								<?php if($this->uri->segment(6)!=""){ echo $this->uri->segment(6);}?>/
								<?php if($this->uri->segment(7)!=""){ echo $this->uri->segment(7);}?>/">
								<?php 
								$srchDate = $srchStatus = $pageNo = '';
								
								if($this->uri->segment(4) != 'Na') { $srchStatus = $this->uri->segment(4); } 
								
								if($this->uri->segment(5) != 'Na') {  $srchDate = $this->uri->segment(5);
								//$date1 = new DateTime($srchDate);
								//$srchDateFormatted = $date1->format('d-m-Y');
								}
								if($this->uri->segment(6) == 'Na') { $pageNo = $this->uri->segment(6); } 
								if($this->uri->segment(7) != 'Na') { $per_page = $this->uri->segment(7); }
								?>
						 		 <div class="tab-content" >
									<div class="tab-pane fade active show">
									<div class="col-sm-12">
									<label>Search</label>
						         <div class="form-group row">
									<select name="bookingstatus" id="bookingstatus"class="form-control col-sm-2">
							            <option value="">All</option>
							            <option value="waiting" <?php if($srchStatus == 'waiting') echo 'selected';?>>Waiting</option>
							            <option value="accepted" <?php if($srchStatus == 'accepted') echo 'selected';?>>Accepted</option>
							            <option value="ongoing" <?php if($srchStatus == 'ongoing') echo 'selected';?>>Ongoing</option>
							            <option value="completed" <?php if($srchStatus == 'completed') echo 'selected';?>>Completed</option>
										<option value="canceled" <?php if($srchStatus == 'canceled') echo 'selected';?>>Canceled</option>
							        </select>&nbsp;&nbsp;

							 		<input type="date" name="datesearch" onkeydown="return false" class="form-control col-sm-2" value="<?php if(isset($srchDate)) echo $srchDate ?>" />&nbsp;&nbsp;
									 <button type="submit" class="btn btn-outline-success" title="Search" name="Search" id="Search" value="search" /><span><i class="fa fa-search"></i><span></button>&nbsp;&nbsp;
							        <a href="<?php echo base_url();?>backend/Booking/manageBookingDemo" title="Clear Search Data" class="btn btn-outline-secondary" ><span><i class="fa fa-remove"></i></span></a>
							    </div>
							        
						 </div>
						</div>
						</div>

						                                   
						    </form>
						    <hr>
<select onchange="pagelimt(this)">
	<option value="4">10</option>
	<option value="8">25</option>
	<option value="15">50</option>
	<option value="100">100</option>	
</select>

						<div class="table-responsive">
							<div id="basicScenario" class="product-physical"></div>
							<?php if($bookingdemocnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="myTable">
									<thead>
										<tr>
											
											<th>Order No</th>
											<th>Booking Date</th>
											<th>Time</th>
											<th>Service Name</th>
											<th>Customer</th>
											<th>Service Provider</th>
											<th>Status</th>
											<th>Change Status</th>
											<th>Actions</th>	
										</tr>
									</thead>	
									<tbody>			
										<?php $i=1;
										foreach($bookingDemoList as $booking)
										{
											if($booking['booking_date'] != '0000-00-00') {
                                             $booking['booking_date']= new DateTime($booking['booking_date']);
                                            $booking['booking_date']=$booking['booking_date']->format('d-M-Y'); }
											else {
												$booking['booking_date'] = '---';
											}

											$categoryData=$this->Booking_model->getCategoryDetails($booking['category_id']);
											$main_categoryname="";
											if($categoryData->category_parent_id!=0)
											{
										$category=$this->Booking_model->getCategoryDetails($categoryData->category_parent_id);
												$main_categoryname=$category->category_name;
											}
											?>		
										<tr>
												<td><?php echo $booking['order_no'];?></td> 
												<td><?php echo $booking['booking_date'];?></td>
												<td><?php echo $booking['time_slot'];?></td>
												<td><?php if($main_categoryname!="") { echo $main_categoryname."-"; } ?><?php echo $booking['category_name'];?></td>
												<td><?php echo $booking['full_name'];?></td>
												<td><?php if($booking['service_provider_id']>0 ){
												$user=$this->Booking_model->getServiceproviderDetails($booking['service_provider_id'],1); 
												
												if(isset($user[0]['full_name'])) echo $user[0]['full_name'];
												
												} else { 
												echo "---";
												} ?></td>
												<td><?php echo $booking['booking_status'];?></td>



												<td>

    <select name='status' id='status' onchange='updateStatus()'>
        <option value='completed'>Completed</option>
        <option value='canceled'>Canceled</option>
    </select>



	<button  onsubmit="checkDB(<?php echo $booking_id = $booking['booking_id'];?>,<?php echo $status= 'completed';?>);" >X</button>	
						 		 
								 <!-- <button onclick="location.href='<?php echo base_url();?>backend/Booking/change_status/<?php if (isset($srchStatus)) echo $srchStatus ?>/<?php if(isset($srchDate)) echo $srchDate ?>/<?php if(isset($pageNo))  echo $pageNo ?>/<?php echo base64_encode($booking['booking_id']);?>/<?php echo base64_encode('completed');?>'">X</button> -->
						                                   
						    <!-- </form> -->





                                               

											
													</td>


												<td class="actions">
							

									<?php   if ($booking['booking_status']=='waiting' && $booking['service_provider_id']<1) {
										?>
										<a href="<?php echo base_url();?>backend/Booking/AssingServiceProvider/<?php echo base64_encode($booking['booking_id']);?>" title="Assign Service Provider"><i data-feather="user-check"></i></a>
									<?php } else{}?>
													<a href="<?php echo base_url();?>backend/Booking/viewBookingDemoDetails/<?php echo base64_encode($booking['booking_id']);?>"><i data-feather="eye"></i>
													</a>

										<?php   if ($booking['time_slot']<0 && $booking['booking_status']!='canceled') {
											?>
										<a href="<?php echo base_url();?>backend/Booking/AssingDateTime/<?php echo base64_encode($booking['booking_id']);?>" title="Assign Time"><i data-feather="check-circle"></i></a>
										<?php } else{}?>														
										
 									
                 



											</td>				
											</tr>											
											<?php $i++; }?>
									</tbody>									
								</table>
								
								<div class="dataTables_paginate paging_simple_numbers" id="datatable-default_paginate" style="margin-top:10px;">
									<?php  echo $links; ?>
								</div>
								<select class='form-control col-md-2' name='s1' id="page_id" style="margin-top:10px;float:right">
											<option value='<?php echo base_url();?>backend/Booking/manageBookingDemo/<?php if(isset($srchStatus) && $srchStatus!="Na") { echo $srchStatus; } else { echo "Na";} ?>/<?php echo $srchDate?>/<?php echo $pageNo;?>/10'>10</option>
											<option value='<?php echo base_url();?>backend/Booking/manageBookingDemo/<?php if(isset($srchStatus) && $srchStatus!="Na") { echo $srchStatus; } else { echo "Na";} ?>/<?php echo $srchDate?>/<?php echo $pageNo;?>/20'>20</option>
											<option value='<?php echo base_url();?>backend/Booking/manageBookingDemo/<?php echo $srchStatus?>/<?php echo $srchDate?>/<?php echo $pageNo;?>/50'>50</option>
											<option value='<?php echo base_url();?>backend/Booking/manageBookingDemo/<?php echo $srchStatus?>/<?php echo $srchDate?>/<?php echo $pageNo;?>/100'>100</option>
										</select>
										
								
									
									


    
								<!-- <div class="form-control"> -->
									<?php
							 // echo form_open('backend/Booking/manageBookingDemo');
							
							// 		             $options = array(
							 // 		                            '' => 'Select',
							 // 		                            	'10'=>'10',
							 //                                      '20' => '20',
							 // 		                             '50' => '50',
							 //                                    '100' => '100');


									           
							 //            echo form_dropdown('sel',$options,'');
							 // echo form_submit('',);
									?>
<!-- </div> -->


						
    
    
										
								<?php } else 
								{?>
								<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No records  found.
								</div>									
								<?php }?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->
	 
	
</div>
<script type="text/javascript">
	
	function pagelimt(event)
	{
		var value = event.value;
		// alert(value);
		 $.ajax({
        url: "<?php echo base_url();?>backend/Booking/manageBookingDemo",
        type: "GET",
        data: {"value" : value}
    }).done(function(data) {
        $('value').val(data);
         // alert(value);
    });
	}

</script>




<!-- <script type="text/javascript">
function checkDB(booking_id, status)
{
	var booking_id = booking_id.value;
	var status = status.value;
	 alert(booking_id);

  $.ajax({
  type: "POST",
  url: "<?php echo base_url();?>backend/Booking/change_status",
  data: 'booking_id='+booking_id+'status='+status,
  datatype: "json",
  success: function(result){

        alert(result);      
      }
  })

}
</script> -->


       
  
<script>
    function updateStatus() {
        var status = $('#status').val();
        // alert(status);
        $.ajax({ 
            url: "<?php echo base_url();?>backend/Booking/change_status?id=<?php echo $booking['booking_id'] ?>&status="+status,
            success: function(res) { 
                  console.log(res);
                  alert(res);
            }
        });
    }
</script>
