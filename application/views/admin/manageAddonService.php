<div class="page-body">
	
		<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>ADDON SERVICES</h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								<a class="btn btn-default"  href="<?php echo base_url();?>backend/Service/addOnService" style="float:right;"><i class="fa fa-plus-circle"></i>Add Addon Service</a>
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
							<?php if($servicecnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th style="width:5%">Sr.No</th>
											<th style="width:10%"> Image</th>	
											<th style="width:10%">Parent Service</th>
											<th style="width:15%">Service Name</th>
											<th style="width:25%">Description</th>
											<th style="width:10%">Status</th>
											<th style="width:10%">Actions</th>	
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
												<td><?php echo $service['parent_service'];?></td>
												<td><?php echo $service['service_name'];?></td>
												<td><?php echo $service['service_description'];?></td>
												<td><?php echo $service['service_status'];?></td>
												<td class="actions">  
													<a href="<?php echo base_url();?>backend/Service/updateAddOnService/<?php echo base64_encode($service['service_id']);?>"><i data-feather="edit"></i></a>
													
													<a href="<?php echo base_url();?>backend/Service/deleteService/<?php echo base64_encode($service['service_id']);?>" onclick="javascript:return chk_isDeleteComnfirm();">
													<i data-feather="trash-2"></i>
													</a>

													<a href="<?php echo base_url();?>backend/Service/viewService/<?php echo base64_encode($service['service_id']);?>"><i data-feather="eye"></i></a>
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