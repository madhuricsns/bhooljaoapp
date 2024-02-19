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
						<h5>MATERIAL REQUEST</h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								<!-- <a class="btn btn-default"  href="<?php echo base_url();?>backend/Material/addMaterial" style="float:right;"><i class="fa fa-plus-circle"></i>Add Material</a> -->
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
							<?php if($requestList > 0)	{ 
                                // print_r($requestList);
                                ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th style="width:5%;">Sr.No</th>	
											<th style="width:20%;">Service Giver</th>
											<th style="width:30%;">Material Name</th>
											<th style="width:10%;">Qty</th>
											<th style="width:10%;">Status</th>
											<th style="width:30%;">Actions</th>	
										</tr>
									</thead>	
									<tbody>			
										<?php $i=1;
										foreach($requestList as $material)
										{
										?>		
										<tr>
												<td><?php echo $i;?></td>
												<td><?php echo $material['full_name'];?></td>
												<td><?php echo $material['material_name'];?></td>
												<td><?php echo $material['request_material_qty'];?></td>
												<td><?php echo $material['request_status'];?></td>
												<td>
													<?php if($material['request_status']=='Waiting') { ?>
														<a href="<?php echo base_url();?>backend/Material/updateStatus/<?php echo base64_encode($material['request_id']);?>/<?php echo base64_encode('Approved');?>/<?php echo base64_encode($material_id);?>" class="btn-sm btn-success">Approve</a>
														<?php //} else { ?>
														<a href="<?php echo base_url();?>backend/Material/updateStatus/<?php echo base64_encode($material['request_id']);?>/<?php echo base64_encode('Rejected');?>/<?php echo base64_encode($material_id);?>" class="btn-sm" style="background-color: #f41818;color:white">Reject</a>
													<?php } ?>
												</td>
															
											</tr>											
											<?php $i++; }?>
									</tbody>									
								</table>
								<div class="dataTables_paginate paging_simple_numbers" id="datatable-default_paginate" style="margin-top:10px;">
									<?php //echo $links; ?>
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