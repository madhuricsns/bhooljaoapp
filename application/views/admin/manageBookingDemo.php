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

						<form name="frm_addslider" class="needs-validation" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Booking/manageBookingDemo">
							<input type="hidden" name="report" value="true">
                            <div class="form-group row">
								<div class="col-sm-2">
                                    <label for="services_title" > Status</label>
									<select name="bookingstatus" id="bookingstatus"class="form-control">
							            <option value="">All</option>
							            <option value="waiting" <?php if(isset($session_demobookingstatus)) if($session_demobookingstatus == 'waiting') echo 'selected';?> >Waiting</option>
							            <option value="ongoing" <?php if(isset($session_demobookingstatus)) if($session_demobookingstatus == 'ongoing') echo 'selected';?>>Ongoing</option>
							            <option value="completed" <?php if(isset($session_demobookingstatus)) if($session_demobookingstatus == 'completed') echo 'selected';?>>Completed</option>
										<option value="canceled" <?php if(isset($session_demobookingstatus)) if($session_demobookingstatus == 'canceled') echo 'selected';?>>Canceled</option>
							           
							        </select>								
								</div>
								<div class="col-sm-2">
                                    <label for="services_title" > Service</label>
									<select name="category_id" id="category_id"class="form-control">
							            <option value="">All</option>
										<?php foreach($categoryList as $category) { ?>
							            <option value="<?php echo $category['category_id'];?>" <?php if(isset($session_democategory_id)) if($session_democategory_id == $category['category_id']) echo 'selected';?> ><?php echo $category['category_name'];?></option>
							           <?php } ?>
							        </select>								
								</div>
                                <div class="col-sm-2">
                                    <label for="services_title" > From Date</label>
									<input type="date" class="form-control" onkeydown="return false" id="from_date" name="from_date" value="<?php if(isset($session_demofrom_date) && $session_demofrom_date!="") echo $session_demofrom_date;?>">
								</div>

                                <div class="col-sm-2">
                                    <label for="services_title" > To Date</label>
									<input type="date" class="form-control" onkeydown="return false" id="to_date" name="to_date" value="<?php if(isset($session_demoto_date) && $session_demoto_date!="") echo $session_demoto_date;?>">
								</div>
								
								<div class="col-sm-2">
									 <br>
                                    <button class="btn btn-outline-success" name="btn_search" id="btn_search" title="Search Data"><span><i class="fa fa-search"></i><span></button>
									<button class="btn btn-outline-secondary" name="btn_clear" id="btn_clear" title="Clear Search Data"><span><i class="fa fa-remove"></i></span></button>
 								</div>
                                 <div class="col-sm-3">
                                 
 								</div>
							</div>
						</form>

						 <!-- <form method="POST" action="<?php echo base_url().'backend/Booking/searchdemo_list/'; ?><?php if($this->uri->segment(4)!=""){ echo $this->uri->segment(4);}?>/
								<?php if($this->uri->segment(5)!=""){ echo $this->uri->segment(5);}?>/
								<?php if($this->uri->segment(6)!=""){ echo $this->uri->segment(6);}?>/
								<?php if($this->uri->segment(7)!=""){ echo $this->uri->segment(7);}?>/">
								<?php 
								$srchDate ='Na';
								$srchStatus ='Na';
								$pageNo ='Na';
								$per_page='Na';
								
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

						                                   
						    </form> -->
						    <hr>

						    <div class="table-responsive">
							<select class='form-control col-md-1' name='s1' id="page_id" style="margin-bottom:10px;float:left" onchange="setPagination()">
								<option <?php if($this->session->userdata("pagination_rows") == '10') { ?> selected <?php } ?>  value='10'>10</option>
								<option <?php if($this->session->userdata("pagination_rows") == '20') { ?> selected <?php } ?> value='20'>20</option>
								<option <?php if($this->session->userdata("pagination_rows") == '50') { ?> selected <?php } ?> value='50'>50</option>
								<option <?php if($this->session->userdata("pagination_rows") == '100') { ?> selected <?php } ?> value='100'>100</option>
							</select>

						<div class="table-responsive">
							<div id="basicScenario" class="product-physical"></div>
							<?php if($bookingdemocnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="myTable">
									<thead>
										<tr>
											
											<th>Order No</th>
											<th>Date/Time</th>
											<th>Service Name</th>
											<th>Customer</th>
											<th>Service Giver</th>
											<th>Status</th>
											<th>Payment Status</th>
											<th>Change Status</th>
											<th>Actions</th>	
										</tr>
									</thead>	
									<tbody>			
										<?php $i=1;
										$crdate=date("d-M-Y");
										foreach($bookingDemoList as $booking)
										{
											$paymentsuccessCount = $this->Booking_model->getBookingTransactionSuccess($booking['booking_id']);
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
												<td><?php echo $booking['booking_date'];?><br><?php echo $booking['time_slot'];?></td>
												<td><?php if($main_categoryname!="") { echo $main_categoryname."-"; } ?><?php echo $booking['category_name'];?></td>
												<td><?php echo $booking['full_name'];?></td>
												<td><?php if($booking['service_provider_id']>0 ){
												$user=$this->Booking_model->getServiceproviderDetails($booking['service_provider_id'],1); 
												
												if(isset($user[0]['full_name'])) echo $user[0]['full_name'];
												
												} else { 
												echo "---";
												} ?></td>
												<td id="<?php echo $booking['booking_id'];?>"><?php echo $booking['booking_status'];?></td>
												<td><?php if($paymentsuccessCount>0){ echo 'Success';} else if($paymentsuccessCount==0){ echo 'Pending';}?></td>
												<td>
												  	<?php 
												  	  if($booking['time_slot']!="" && $booking['booking_date']<$crdate  && ($booking['booking_status']=='waiting' || $booking['booking_status']=='ongoing')) {
													
													?>
													    <select name='ChangeStatus' id='ChangeStatus' onchange="DemostatusChange(this)" class="form-control">
                               							 <option value="">Action</option>
						                                  <option value='completed' data-id="<?php echo $booking['booking_id'];?>">Completed</option>
						                                  <option value='canceled' data-id="<?php echo $booking['booking_id'];?>">Canceled</option>
						                              </select>
						                              <?php } else{}?>
												</td>


												<td class="actions">
													<?php   if ($booking['booking_status']=='waiting' && $booking['service_provider_id']<1) {
														?>
														<a href="<?php echo base_url();?>backend/Booking/AssingServiceProvider/<?php echo base64_encode($booking['booking_id']);?>" title="Assign Service Provider"><i data-feather="user-check"></i></a>
													<?php } else{}?>
													<a href="<?php echo base_url();?>backend/Booking/viewBookingDemoDetails/<?php echo base64_encode($booking['booking_id']);?>"><i data-feather="eye"></i>
													</a>

													<?php   if ($booking['time_slot']<0 && $booking['booking_status']!='canceled' && $paymentsuccessCount>0) {
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
	</div>
	<!-- Container-fluid Ends-->
	 
	
</div>  
<script>
    function DemostatusChange(select) {
    	var selectedOption = select.options[select.selectedIndex];
  var status = selectedOption.getAttribute('value');
  var booking_id = selectedOption.getAttribute('data-id');
        // var status = $('#status').val();
        // var status= $('select[name=ChangeStatus]').val();
          var id ="#"+booking_id;
        //    alert(status,booking_id);
        $.ajax({ 
            url: "<?php echo base_url();?>backend/Booking/change_status?booking_id="+booking_id+"&status="+status,
            success: function(res) { 
                //   console.log(res);
                  $(id).html(status);
                //   alert(res);
            }
        });
    }
</script>
