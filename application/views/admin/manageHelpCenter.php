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
						<h5>HELP CENTER </h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								 <a class="btn btn-default"  href="<?php echo base_url();?>backend/HelpCenter/addHelpCenter" style="float:right"><i class="fa fa-plus-circle"></i>Add HelpCenter</a>
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
							<?php if($Helpcentercnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th>Sr.No </th>
											<th>Help Image</th>	
											<th>Help Name</th>
											<th>Help Value</th>
											<th style="width:10%">Actions</th>	
											
											
										</tr>
									</thead>	
									<tbody>			
										<?php $i=1;
										foreach($HelpCenter as $help)
										{
											//   $feedback['dateadded']= new DateTime($feedback['dateadded']);
                                            // $feedback['dateadded']=$feedback['dateadded']->format('d-M-Y');
                                            $str_images='';										
											if($help['help_image']!="")
											{
												$str_images='<img src="'.base_url().'uploads/helpcenter/'.$help['help_image'].'" style="width:80px;height:80px">';
											}	
											?>		
											
												
										<tr>
											<td><?php echo $i;?></td>
											
												<?php if($str_images!="") {?>
												<td> <?php echo $str_images;?></td>
												<?php } else {?>
												<td> <img src="<?php echo base_url();?>template/admin/assets/images/lookbook.jpg" alt="No image Found"style="width:80px;height:80px" /></td>
												<?php } ?>
											
												<td><?php echo $help['help_name'];?></td>
												
												
												<td><?php echo $help['help_value'];?></td>
											<td class="actions">  
													<a href="<?php echo base_url();?>backend/HelpCenter/updateHelpCenter/<?php echo base64_encode($help['help_id']);?>"><i data-feather="edit"></i></a>
													
													<a href="<?php echo base_url();?>backend/HelpCenter/deleteHelpCenter/<?php echo base64_encode($help['help_id']);?>" onclick="javascript:return chk_isDeleteComnfirm();">
													<i data-feather="trash-2"></i>
													</a>

													<!-- <a href="<?php //echo base_url();?>backend/Service/viewService/<?php //echo base64_encode($service['service_id']);?>"><i data-feather="eye"></i></a> -->
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