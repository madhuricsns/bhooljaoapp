<div class="page-body">
	
		<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h5>SUB-CATEGORY</h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								
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
							<?php if($subcategorycnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th style="width:5%">Sr.No</th>
											<th style="width:10%"> Image</th>	
											<th style="width:10%">Parent Category</th>
											<th style="width:15%">Category Name</th>
											<th style="width:25%">Description</th>
											<th style="width:10%">Status</th>
											<th style="width:10%">Actions</th>	
										</tr>
									</thead>	
									<tbody>			
										<?php $i=1;
										// print_r($serviceList);
										foreach($subcategoryList as $sub)
										{
										?>		
										<tr>
												<td><?php echo $i;?></td>
												<td><img src="<?php echo $sub['category_image'];?>" width="50px"></td>
												<td><?php echo $sub['parent_category'];?></td>
												<td><?php echo $sub['category_name'];?></td>
												
												<td><?php echo $sub['category_description'];?></td>
												<td style="color:<?php if($sub['category_status']=='Active'){ echo '#058f05';}else { echo 'red';}?>"><?php echo $sub['category_status'];?></td>
												<td class="actions">  
													<a href="<?php echo base_url();?>backend/Category/updateCategory/<?php echo base64_encode($sub['category_id']);?>"><i data-feather="edit"></i></a>
													
													<a href="<?php echo base_url();?>backend/Category/deleteCategory/<?php echo base64_encode($sub['category_id']);?>" onclick="javascript:return chk_isDeleteComnfirm();">
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