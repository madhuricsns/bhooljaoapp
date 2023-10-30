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
						<h5>SERVICE PROVIDERS</h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								<a class="btn btn-default"  href="<?php echo base_url();?>backend/Users/addServiceprovider" style="float:right;"><i class="fa fa-plus-circle"></i>Add Service Provider</a>
								<a class="btn btn-default"  href="<?php echo base_url();?>backend/Users/exportSPCSV" style="float:right;margin-right: 5px;"><i class="fa fa-download"></i>Export CSV</a>
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
							<div id="basicScenario" class="product-physical"></div>
							<?php if($serviceproviderscnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th>Sr.No</th>
											<th>Profile</th>	
											<th>Full Name</th>
											<th>Email Address</th>
											<th>Mobile Number</th>
											<th>Zone</th>
											<th>Address</th>
											<th>Status</th>
											<th>Change Status</th>
											<th>Actions</th>	
										</tr>
									</thead>	
									<tbody>			
										<?php $i=1;
										foreach($serviceproviders as $user)
										{
										?>		
										<tr>
												<td><?php echo $i;?></td>
												<td><img src="<?php echo base_url().'./uploads/service_provider/'.$user['profile_pic'];?>" width="50"></td>
												<td><?php echo $user['full_name'];?></td>
												<td><?php echo $user['email'];?></td>
												<td><?php echo $user['mobile'];?></td>
												<td><?php echo $user['zone_name'];?></td>
												<td><?php echo $user['address'];?></td>
												<td><?php echo $user['status'];?></td>
												<td>
													<?php if($user['status']!='Active') { ?>
														<a href="<?php echo base_url();?>backend/Users/spchange_status/<?php echo base64_encode($user['user_id']);?>/<?php echo base64_encode('Active');?>" class="btn-sm btn-success">Active</a>
														<?php } else { ?>
														<a href="<?php echo base_url();?>backend/Users/spchange_status/<?php echo base64_encode($user['user_id']);?>/<?php echo base64_encode('Inactive');?>" class="btn-sm btn-danger">Inactive</a>
													<?php } ?>
												</td>
												<td class="actions">                     
													<a href="<?php echo base_url();?>backend/Users/updateServiceprovider/<?php echo base64_encode($user['user_id']);?>"><i data-feather="edit"></i></a>
													
													<a href="<?php echo base_url();?>backend/Users/deleteServiceprovider/<?php echo base64_encode($user['user_id']);?>" onclick="javascript:return chk_isDeleteComnfirm();">
													<i data-feather="trash-2"></i>
													</a>

													<a href="<?php echo base_url();?>backend/Users/viewUsertask/<?php echo base64_encode($user['user_id']);?>"><i data-feather="eye"></i></a>
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