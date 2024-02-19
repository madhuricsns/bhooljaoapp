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

						<form name="frm_addslider" class="needs-validation" method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>backend/Booking/manageBooking">
							<input type="hidden" name="report" value="true">
                            <div class="form-group row">
								<div class="col-sm-2">
                                    <label for="services_title" > Status</label>
									<select name="bookingstatus" id="bookingstatus"class="form-control">
							            <option value="">All</option>
							            <option value="waiting" <?php if(isset($session_bookingstatus)) if($session_bookingstatus == 'waiting') echo 'selected';?> >Waiting</option>
							            <option value="ongoing" <?php if(isset($session_bookingstatus)) if($session_bookingstatus == 'ongoing') echo 'selected';?>>Ongoing</option>
							            <option value="completed" <?php if(isset($session_bookingstatus)) if($session_bookingstatus == 'completed') echo 'selected';?>>Completed</option>
										<option value="canceled" <?php if(isset($session_bookingstatus)) if($session_bookingstatus == 'canceled') echo 'selected';?>>Canceled</option>
							           
							        </select>								
								</div>
								<div class="col-sm-2">
                                    <label for="services_title" > Service</label>
									<select name="category_id" id="category_id"class="form-control">
							            <option value="">All</option>
										<?php foreach($categoryList as $category) { ?>
							            <option value="<?php echo $category['category_id'];?>" <?php if(isset($session_category_id)) if($session_category_id == $category['category_id']) echo 'selected';?> ><?php echo $category['category_name'];?></option>
							           <?php } ?>
							        </select>								
								</div>
                                <div class="col-sm-2">
                                    <label for="services_title" > From Date</label>
									<input type="date" class="form-control" onkeydown="return false" id="from_date" name="from_date" value="<?php if(isset($session_from_date) && $session_from_date!="") echo $session_from_date;?>">
								</div>

                                <div class="col-sm-2">
                                    <label for="services_title" > To Date</label>
									<input type="date" class="form-control" onkeydown="return false" id="to_date" name="to_date" value="<?php if(isset($session_to_date) && $session_to_date!="") echo $session_to_date;?>">
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

						 <!-- <form method="POST" action="<?php echo base_url().'backend/Booking/search_list/'; ?><?php if($this->uri->segment(4)!=""){ echo $this->uri->segment(4);}?>/
								<?php if($this->uri->segment(5)!=""){ echo $this->uri->segment(5);}?>/
								<?php if($this->uri->segment(6)!=""){ echo $this->uri->segment(6);}?>/
								<?php if($this->uri->segment(7)!=""){ echo $this->uri->segment(7);}?>/">
								<?php 
								$srchDate ='Na';
								$srchStatus ='Na';
								$pageNo ='Na';
								$per_page='Na';
								
								if($this->uri->segment(4) != 'Na') { $srchStatus = $this->uri->segment(4); } else { $srchStatus ='Na'; }
								if($this->uri->segment(5) != 'Na') { $srchDate = $this->uri->segment(5); }
								if($this->uri->segment(6) != 'Na') { $pageNo = $this->uri->segment(6); }
								if($this->uri->segment(7) != 'Na') { $per_page = $this->uri->segment(7); }
								// echo "srchDate-".$srchDate."<br>";
								// echo "srchStatus-".$srchStatus."<br>";
								// echo "pageno-".$pageNo."<br>";
								// echo "per_page-".$per_page."<br>";
								?>
						 		 <div class="tab-content" >
						                            <div class="tab-pane fade active show">
						                                        <div class="col-sm-12">
						                                        	<label>Search</label>
						         <div class="form-group row">
						            <input type="hidden" name="per_page" value="<?php echo $per_page;?>">
										<select name="bookingstatus" id="bookingstatus"class="form-control col-sm-2">
							            <option value="">All</option>
							            <option value="waiting" <?php if($srchStatus == 'waiting') echo 'selected';?> >Waiting</option>
							            <option value="ongoing" <?php if($srchStatus == 'ongoing') echo 'selected';?>>Ongoing</option>
							            <option value="completed" <?php if($srchStatus == 'completed') echo 'selected';?>>Completed</option>
										<option value="canceled" <?php if($srchStatus == 'canceled') echo 'selected';?>>Canceled</option>
							           
							        </select>&nbsp;&nbsp;

										<input type="date" name="datesearch" onkeydown="return false"  class="date form-control col-sm-2 "  value="<?php echo $srchDate ?>"/>
										&nbsp;&nbsp;
							  
							        <button type="submit" class="btn btn-outline-success" title="Search" name="Search" id="Search" value="search" /><span><i class="fa fa-search"></i><span></button>&nbsp;&nbsp;
							        <a href="<?php echo base_url();?>backend/Booking/manageBooking" title="Clear Search Data" class="btn btn-outline-secondary" ><span><i class="fa fa-remove"></i></span></a>
							    
							    
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
										
							<div id="basicScenario" class="product-physical"></div>
							<?php if($bookingcnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th>Order No</th>
											<th>Date/Time</th>
											<!-- <th>Time</th>
											<th>Duration</th> -->
											<th>Service Name/Duration</th>
											<th>Customer</th>
											<th>Service Giver</th>
											<th>Status</th>
											<th>Payment Status</th>
											<th>Actions</th>	
										</tr>
									</thead>	
									<tbody>			
										<?php 
										$i=1;
										foreach($bookingList as $booking)
										{
											$paymentsuccessCount = $this->Booking_model->getBookingTransactionSuccess($booking['booking_id']);
		
                                            $booking['booking_date']= new DateTime($booking['booking_date']);
                                            $booking['booking_date']=$booking['booking_date']->format('d-M-Y');

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
												<!-- <td><?php echo $booking['duration'];?></td> -->
												<td><?php if($main_categoryname!="") { echo $main_categoryname."-"; } ?><?php echo $booking['category_name'];?><br><?php echo $booking['duration'];?></td>
												<td><?php echo $booking['full_name'];?></td>
												<td>
													<?php if($booking['service_provider_id']>0 ){
													$user=$this->Booking_model->getServiceproviderDetails($booking['service_provider_id'],1); 
													if(isset($user[0]['full_name'])) echo $user[0]['full_name'];
													} else if($booking['service_group_id']>0 ){
														$group=$this->Booking_model->getGroup($booking['service_group_id'],1); 
														if(isset($group[0]['group_name'])) echo $group[0]['group_name'];
														} else { 
													echo "---";
													} ?>
												</td>
												<td><?php echo $booking['booking_status'];?></td>
												<td><?php if($paymentsuccessCount>0){ echo 'Success';} else if($paymentsuccessCount==0){ echo 'Pending';}?></td>
												<td class="actions">
							
												<?php  if($booking['booking_status']=='waiting' &&  $booking['service_provider_id']=='0' && $booking['service_group_id']==0 && $paymentsuccessCount>0) {
												?>
													<a href="<?php echo base_url();?>backend/Booking/AssingServiceProvider/<?php echo base64_encode($booking['booking_id']);?>" title="Assign Service Giver"><i data-feather="user-check"></i></a>
													<?php } else{}?>
														<a href="<?php echo base_url();?>backend/Booking/viewBookingDetails/<?php echo base64_encode($booking['booking_id']);?>"><i data-feather="eye"></i>
														</a>
													</td>				
										</tr>											
											<?php $i++; }?>
											</tbody>									
										</table>
										<div class="dataTables_paginate paging_simple_numbers col-md-10" id="datatable-default_paginate" style="margin-top:10px;float:left">
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
<script type="text/javascript">
	<script> 
        $(function() { 
            $("#my_date_picker").datepicker({ 
                defaultDate:"09/22/2019" 
            }); 
        }); 
    </script> 
