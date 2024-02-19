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
						<h5>ZONE MANAGEMENT</h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								<a class="btn btn-default"  href="<?php echo base_url();?>backend/Zone/addZone" style="float:right;"><i class="fa fa-plus-circle"></i>Add Zone</a>
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
						<form method="POST" action="<?php echo base_url().'backend/Zone/manageZones/'; ?><?php if($this->uri->segment(4)!=""){ echo $this->uri->segment(4);}?>/
								<?php //if($this->uri->segment(5)!=""){ echo $this->uri->segment(5);}?>/
								<?php //if($this->uri->segment(6)!=""){ echo $this->uri->segment(6);}?>/
								<?php //if($this->uri->segment(7)!=""){ echo $this->uri->segment(7);}?>/">
								<?php 
								// $srchDate ='Na';
								// $srchStatus ='Na';
								// $pageNo ='Na';
								$per_page='Na';
								
								// if($this->uri->segment(4) != 'Na') { $srchStatus = $this->uri->segment(4); } else { $srchStatus ='Na'; }
								// if($this->uri->segment(5) != 'Na') { $srchDate = $this->uri->segment(5); }
								// if($this->uri->segment(6) != 'Na') { $pageNo = $this->uri->segment(6); }
								if($this->uri->segment(4) != 'Na') { $per_page = $this->uri->segment(4); }
								// echo "srchDate-".$srchDate."<br>";
								// echo "srchStatus-".$srchStatus."<br>";
								// echo "pageno-".$pageNo."<br>";
								// echo "per_page-".$per_page."<br>";
								?>
						 		 

						                                   
						    </form>

							<div class="table-responsive">
							<select class='form-control col-md-1' name='s1' id="page_id" style="margin-bottom:10px;float:left" onchange="setPagination()">
								<option <?php if($this->session->userdata("pagination_rows") == '10') { ?> selected <?php } ?>  value='10'>10</option>
								<option <?php if($this->session->userdata("pagination_rows") == '20') { ?> selected <?php } ?> value='20'>20</option>
								<option <?php if($this->session->userdata("pagination_rows") == '50') { ?> selected <?php } ?> value='50'>50</option>
								<option <?php if($this->session->userdata("pagination_rows") == '100') { ?> selected <?php } ?> value='100'>100</option>
							</select>										
						<div class="table-responsive">
							<div id="basicScenario" class="product-physical"></div>
							<?php if($zonecnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th style="width:10%;">Sr.No</th>	
											<th style="width:50%;">Zone Name</th>
											<th style="width:20%;">Pin Code</th>
											<th style="width:10%;">Status</th>
											<th style="width:10%">Change Status</th>
											<th style="width:10%;">Actions</th>	
										</tr>
									</thead>	
									<tbody>			
										<?php $i=1;
										foreach($zones as $zone)
										{
										?>		
										<tr>
												<td><?php echo $i;?></td>
												<td><?php echo $zone['zone_name'];?></td>
												<td><?php echo $zone['zone_pincode'];?></td>
												<td style="color:<?php if($zone['zone_status']=='Active'){ echo '#058f05';}else if($zone['zone_status']=='Inactive'){ echo 'red';}else if($zone['zone_status']=='Delete'){ echo 'red';}?>">
													<?php echo $zone['zone_status'];?></td>
												<td>
													<?php if($zone['zone_status']!='Active') { ?>
														<a href="<?php echo base_url();?>backend/Zone/change_status/<?php echo base64_encode($zone['zone_id']);?>/<?php echo base64_encode('Active');?>" class="btn-sm btn-danger">Active</a>
														<?php } else { ?>
														<a href="<?php echo base_url();?>backend/Zone/change_status/<?php echo base64_encode($zone['zone_id']);?>/<?php echo base64_encode('Inactive');?>" class="btn-sm btn-danger">Inactive</a>
													<?php } ?>
												</td>
												<td class="actions">                     
			  										 <a href="<?php echo base_url();?>backend/Zone/update_Zone/<?php echo base64_encode($zone['zone_id']);?>"><i data-feather="edit"></i></a>
													<a href="<?php echo base_url();?>backend/Zone/deleteZone/<?php echo base64_encode($zone['zone_id']);?>" onclick="javascript:return chk_isDeleteComnfirm();">
													<i data-feather="trash-2"></i>
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
	</div>
	<!-- Container-fluid Ends-->
	
</div>