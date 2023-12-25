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



						 <form method="POST" action="<?php echo base_url().'backend/Booking/search_list/'; ?><?php if($this->uri->segment(4)!=""){ echo $this->uri->segment(4);}?>/
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
						                                    <!-- <div class="row"> -->
						                                        <div class="col-sm-12">
						                                        	<label>Search</label>
						         <div class="form-group row">
						            <input type="hidden" name="per_page" value="<?php echo $per_page;?>">
										<select name="bookingstatus" id="bookingstatus"class="form-control col-sm-2">
							            <option value="">All</option>
							            <option value="waiting" <?php if($srchStatus == 'waiting') echo 'selected';?> >Waiting</option>
							            <option value="accepted" <?php if($srchStatus == 'accepted') echo 'selected';?>>Accepted</option>
							            <option value="ongoing" <?php if($srchStatus == 'ongoing') echo 'selected';?>>Ongoing</option>
							            <option value="completed" <?php if($srchStatus == 'completed') echo 'selected';?>>Completed</option>
										<option value="canceled" <?php if($srchStatus == 'canceled') echo 'selected';?>>Canceled</option>
							           
							        </select>&nbsp;&nbsp;

							        <!-- <input type="text" name="datesearch" class="date form-control col-sm-2 " minlength="4" maxlength="10" size="10" value="<?php echo $srchDate ?>"> -->
										<input type="date" name="datesearch" onkeydown="return false"  class="date form-control col-sm-2 "  value="<?php echo $srchDate ?>"/>
										&nbsp;&nbsp;
							  
							        <button type="submit" class="btn btn-outline-success" title="Search" name="Search" id="Search" value="search" /><span><i class="fa fa-search"></i><span></button>&nbsp;&nbsp;
							        <a href="<?php echo base_url();?>backend/Booking/manageBooking" title="Clear Search Data" class="btn btn-outline-secondary" ><span><i class="fa fa-remove"></i></span></a>
							    
							    
							    </div>
							        
						 </div>
						</div>
						</div>

						                                   
						    </form>
						    <hr>


						<div class="table-responsive">
							<select class='form-control col-md-1' name='s1' id="page_id" style="margin-bottom:10px;float:left">
								<option value='<?php echo base_url();?>backend/Booking/manageBooking/<?php if(isset($srchStatus) && $srchStatus!="Na") { echo $srchStatus; } else { echo "Na";} ?>/<?php if(isset($srchDate) && $srchDate!='Na') { echo $srchDate; } else { echo 'Na'; }?>/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/10' <?php if($per_page=='10'){ echo 'selected';}?>>10</option>
								<option value='<?php echo base_url();?>backend/Booking/manageBooking/<?php if(isset($srchStatus) && $srchStatus!="Na") { echo $srchStatus; } else { echo "Na";} ?>/<?php if(isset($srchDate) && $srchDate!='Na') { echo $srchDate; } else { echo 'Na'; }?>/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/20' <?php if($per_page=='20'){ echo 'selected';}?>>20</option>
								<option value='<?php echo base_url();?>backend/Booking/manageBooking/<?php if(isset($srchStatus) && $srchStatus!="Na") { echo $srchStatus; } else { echo "Na";} ?>/<?php if(isset($srchDate) && $srchDate!='Na') { echo $srchDate; } else { echo 'Na'; }?>/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/50' <?php if($per_page=='50'){ echo 'selected';}?>>50</option>
								<option value='<?php echo base_url();?>backend/Booking/manageBooking/<?php if(isset($srchStatus) && $srchStatus!="Na") { echo $srchStatus; } else { echo "Na";} ?>/<?php if(isset($srchDate) && $srchDate!='Na') { echo $srchDate; } else { echo 'Na'; }?>/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/100' <?php if($per_page=='100'){ echo 'selected';}?>>100</option>
								
							</select>
										
							<div id="basicScenario" class="product-physical"></div>
							<?php if($bookingcnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th>Order No</th>
											<th>Booking Date</th>
											<th>Time</th>
											<th>Duration</th>
											<th>Service Name</th>
											<th>Customer</th>
											<th>Service Giver</th>
											<th>Status</th>
											<th>Actions</th>	
										</tr>
									</thead>	
									<tbody>			
										<?php 
										$i=1;
										foreach($bookingList as $booking)
										{
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
												<td><?php echo $booking['booking_date'];?></td>
												<td><?php echo $booking['time_slot'];?></td>
												<td><?php echo $booking['duration'];?></td>
												<td><?php if($main_categoryname!="") { echo $main_categoryname."-"; } ?><?php echo $booking['category_name'];?></td>
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
												<td class="actions">
							
												<?php  if($booking['booking_status']=='waiting' &&  $booking['service_provider_id']=='0' && $booking['service_group_id']==0) {
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
