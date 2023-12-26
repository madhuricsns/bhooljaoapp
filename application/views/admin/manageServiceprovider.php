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

						<form method="POST" action="<?php echo base_url().'backend/Users/manageServiceProvider/'; ?><?php if($this->uri->segment(4)!=""){ echo $this->uri->segment(4);}?>/
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
							<select class='form-control col-md-1' name='s1' id="page_id" style="margin-bottom:10px;float:left">
								<option value='<?php echo base_url();?>backend/Users/manageServiceProvider/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/10' <?php if($per_page=='10'){ echo 'selected';}?>>10</option>
								<option value='<?php echo base_url();?>backend/Users/manageServiceProvider/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/20' <?php if($per_page=='20'){ echo 'selected';}?>>20</option>
								<option value='<?php echo base_url();?>backend/Users/manageServiceProvider/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/50' <?php if($per_page=='50'){ echo 'selected';}?>>50</option>
								<option value='<?php echo base_url();?>backend/Users/manageServiceProvider/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/100' <?php if($per_page=='100'){ echo 'selected';}?>>100</option>
								
							</select>




						<div class="table-responsive">
							<div id="basicScenario" class="product-physical"></div>
							<?php if($serviceproviderscnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th style="width:5%;">Sr.No</th>
											<th>Profile</th>	
											<th>Full Name</th>
											<th>Email</th>
											<th>Mobile</th>
											<th>Service</th>
											<th>Zone</th>
											<!-- <th>Address</th> -->
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
												<td title="<?php echo $user['user_id'];?>"><?php echo $i;?></td>
												<td>
												<?php if(!empty ($user['profile_pic']) == NULL):?>
												<img class="img-circle img-fluid" src="<?php echo base_url().'./uploads/user_profile/default.png';?>" width="50px" >
												<?php else:?>
												<img class="img-circle img-fluid" src="<?php echo base_url().'./uploads/user_profile/'.$user['profile_pic'];?>" width="50px">
												<?php endif;?>

												</td>
												<td><?php echo $user['full_name'];?></td>
												<td><?php echo $user['email'];?></td>
												<td><?php echo $user['mobile'];?></td>
												<td><?php echo $user['category_name'];?></td>
												<td><?php echo $user['zone_name'];?></td>
												<!-- <td><?php echo $user['address'];?></td> -->
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

													<a href="<?php echo base_url();?>backend/Users/viewServiceProviderDetails/<?php echo base64_encode($user['user_id']);?>"><i data-feather="eye"></i></a>
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