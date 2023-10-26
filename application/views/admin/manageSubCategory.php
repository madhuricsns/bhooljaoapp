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
						<h5>SUB CATEGORY</h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								<a class="btn btn-default"  href="<?php echo base_url();?>backend/SubCategory/addsubcategory" style="float:right;"><i class="fa fa-plus-circle"></i>Add SubCategory</a>
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
							<?php if($usercnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th>Sr.No</th>
											<th>SubCategory Image</th>	
											<th>Category</th>
											<th>SubCategory Name</th>
											<th>Description</th>
											<th>Duration</th>
											<th>Price</th>
											<th>Status</th>
											<th>Actions</th>	
										</tr>
									</thead>	
									<tbody>			
										<?php $i=1;
										foreach($SubCategory as $subcategory)
										{
										?>		
										<tr>
												<td><?php echo $i;?></td>
												<td><img src="<?php echo base_url().'./uploads/subcategory/'.$subcategory['subcategory_image'];?>" width="50"></td>
												<td><?php echo $subcategory['category_id'];?></td>
												<td><?php echo $subcategory['subcategory_name'];?></td>
												<td><?php echo $subcategory['description'];?></td>
												<td><?php echo $subcategory['duration'];?></td>
												<td><?php echo $subcategory['price'];?></td>
												<td><?php echo $subcategory['status'];?></td>
												<td class="actions">                     
													<a href="<?php echo base_url();?>backend/SubCategory/update_subcategory/<?php echo base64_encode($subcategory['id']);?>"><i data-feather="edit"></i></a>
													
													<a href="<?php echo base_url();?>backend/SubCategory/deletesubcategory/<?php echo base64_encode($subcategory['id']);?>" onclick="javascript:return chk_isDeleteComnfirm();">
													<i data-feather="trash-2"></i>
													</a>

													<a href="<?php echo base_url();?>backend/Users/viewUsertask/<?php echo base64_encode($subcategory['id']);?>"><i data-feather="eye"></i></a>
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