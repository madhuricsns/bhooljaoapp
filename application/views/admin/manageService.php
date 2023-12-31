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
						<h5>SERVICES</h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								<a class="btn btn-default"  href="<?php echo base_url();?>backend/Service/addService" style="float:right;"><i class="fa fa-plus-circle"></i>Add service</a>
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
						<div class="table-responsive">
							<?php
								$per_page='Na';
								
								if($this->uri->segment(4) != 'Na') { $per_page = $this->uri->segment(4); }

							?>
						<select class='form-control col-md-1' name='s1' id="page_id" style="margin-bottom:10px;float:left">
								<option value='<?php echo base_url();?>backend/Service/manageService/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/10' <?php if($per_page=='10'){ echo 'selected';}?>>10</option>
								<option value='<?php echo base_url();?>backend/Service/manageService/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/20' <?php if($per_page=='20'){ echo 'selected';}?>>20</option>
								<option value='<?php echo base_url();?>backend/Service/manageService/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/50' <?php if($per_page=='50'){ echo 'selected';}?>>50</option>
								<option value='<?php echo base_url();?>backend/Service/manageService/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/100' <?php if($per_page=='100'){ echo 'selected';}?>>100</option>
								
							</select>	
							<div id="basicScenario" class="product-physical"></div>
							<?php if($usercnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th style="width:5%">Sr.No</th>
											<th style="width:10%"> Image</th>	
											<th style="width:10%">Category</th>
											<th style="width:15%">Service Name</th>
											<th style="width:20%">Description</th>
											<!--<th style="width:10%">Price</th>-->
											<th style="width:10%">Status</th>
											<th style="width:10%">Change Status</th>
											<th style="width:15%">Actions</th>	
										</tr>
									</thead>	
									<tbody>			
										<?php $i=1;
										// print_r($serviceList);
										foreach($serviceList as $service)
										{
										?>		
										<tr>
												<td><?php echo $i;?></td>
												<td><img src="<?php echo $service['service_image'];?>" width="50px"></td>
												<td><?php echo $service['category_name'];?></td>
												<td><?php echo $service['service_name'];?></td>
												<td><?php echo $service['service_description'];?></td>
												<!--<td><?php// echo "₹".$service['min_price']."- ₹".$service['max_price'];?></td>-->
												<td><?php echo $service['service_status'];?></td>
												
												<td>
													<?php if($service['service_status']!='Active') { ?>
														<a href="<?php echo base_url();?>backend/Service/change_status/<?php echo base64_encode($service['service_id']);?>/<?php echo base64_encode('Active');?>" class="btn-sm btn-success">Active</a>
														<?php } else { ?>
														<a href="<?php echo base_url();?>backend/Service/change_status/<?php echo base64_encode($service['service_id']);?>/<?php echo base64_encode('Inactive');?>" class="btn-sm btn-danger">Inactive</a>
													<?php } ?>
												</td>
												<td class="actions">                     
													<a href="<?php echo base_url();?>backend/Service/manageAddonServices/<?php echo base64_encode($service['service_id']);?>" title="Addon Services"><i data-feather="file-plus"></i></a>
													<!-- <a href="<?php echo base_url();?>backend/Service/updateService/<?php echo base64_encode($service['service_id']);?>"><i data-feather="edit"></i></a> -->
													
													<a href="<?php echo base_url();?>backend/Service/viewService/<?php echo base64_encode($service['service_id']);?>"><i data-feather="eye"></i></a>
													<a href="<?php echo base_url();?>backend/Service/addmultiple_images/<?php echo base64_encode($service['service_id']);?>" title="Add Images"><i data-feather="image"></i></a>
													<a href="<?php echo base_url();?>backend/Service/deleteService/<?php echo base64_encode($service['service_id']);?>" onclick="javascript:return chk_isDeleteComnfirm();">
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
	<!-- Container-fluid Ends-->
	
</div>