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
						<h5>BOOKINGS </h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								<a class="btn btn-default"  href="<?php echo base_url();?>backend/Booking/exportBookingCSV" style="float:right"><i class="fa fa-download"></i>Export CSV</a>
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



						 <form method="get">
						 		 <div class="tab-content" >
						                            <div class="tab-pane fade active show">
						                                    <!-- <div class="row"> -->
						                                        <div class="col-sm-12">
						                                        	<label for="Search">Search</label>
						         <div class="form-group row">
						            
						            	

								<select name="bookingstatus" id="bookingstatus"class="form-control col-sm-2">
							            <option value="">All</option>
							            <option value="waiting">Waiting</option>
							            <option value="accepted">Accepted</option>
							            <option value="ongoing">Ongoing</option>
							            <option value="completed">Completed</option>
							           
							        </select>&nbsp;&nbsp;

							 <input type="date" name="datesearch"class="form-control col-sm-2" value="<?php if(isset($datesearch)) echo $datesearch; ?>"/>&nbsp;&nbsp;
							  
							       
							        	
							        	
							        <button type="submit" class="btn btn-outline-success" name="Search" id="Search"><span><i class="fa fa-search"></i><span></button>&nbsp;&nbsp;
							        <a href="<?php echo base_url();?>backend/Booking/manageBooking" class="btn btn-outline-secondary" ><span><i class="fa fa-remove"></i></span></a>
							    
							    
							    </div>
							        
						 </div>
						</div>
						</div>

						                                   
						    </form>
						    <hr>


						<div class="table-responsive">
							<div id="basicScenario" class="product-physical"></div>
							<?php if($bookingcnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											
											<th>Order No</th>
											<th>Booking Date</th>
											<th>Time</th>
											<th>Service Name</th>
											<th>Customer</th>
											<th>Status</th>
											<th>Actions</th>	
										</tr>
									</thead>	
									<tbody>			
										<?php $i=1;
										foreach($bookingList as $booking)
										{
                                             $booking['booking_date']= new DateTime($booking['booking_date']);
                                            $booking['booking_date']=$booking['booking_date']->format('d-M-Y');
											?>		
										<tr>
												
												<td><?php echo $booking['order_no'];?></td> 
												<td><?php echo $booking['booking_date'];?></td>
												<td><?php echo $booking['time_slot'];?></td>
												<td><?php echo $booking['category_name'];?></td>
												<td><?php echo $booking['full_name'];?></td>
												<td><?php echo $booking['booking_status'];?></td>
												<td class="actions">
							<?php
												
							// 					 if(isset($booking)&& count($booking)>0)
							// { 
							// 	if (array_search('waiting', array_column($booking, 'user-check')) !== FALSE) 
							// 	{ 
									
							// 		echo 'style="display:none;"'; 
							//     } 
							// 	else 
							// 	{ 
							// 		echo 'style="display:block;"';
							// 	}
							// } service_provider_id
							?>

<?php   if ($booking['booking_status']='waiting' && $booking['service_provider_id']<1) {
	?>
										<a href="<?php echo base_url();?>backend/Booking/AssingServiceProvider/<?php echo base64_encode($booking['booking_id']);?>" title="Assign Service Provider"><i data-feather="user-check"></i></a>
<?php } else{}?>




													<a href="<?php echo base_url();?>backend/Booking/viewBookingDetails/<?php echo base64_encode($booking['booking_id']);?>"><i data-feather="eye"></i>

													</a>
														

											</td>				
											</tr>											
											<?php $i++; }?>
									</tbody>									
								</table>
								<div class="dataTables_paginate paging_simple_numbers" id="datatable-default_paginate" style="margin-top:10px;">
									<?php echo $links; ?>
								</div>									
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