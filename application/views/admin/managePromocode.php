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
						<h5>PROMOCODES	 </h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								<a class="btn btn-default"  href="<?php echo base_url();?>backend/Promocode/addPromocode" style="float:right"><i class="fa fa-plus-circle"></i>Add Promocode</a>
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

<form method="POST" action="<?php echo base_url().'backend/Promocode/managePromocode/'; ?><?php if($this->uri->segment(4)!=""){ echo $this->uri->segment(4);}?>/
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
								<option value='<?php echo base_url();?>backend/Promocode/managePromocode/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/10' <?php if($per_page=='10'){ echo 'selected';}?>>10</option>
								<option value='<?php echo base_url();?>backend/Promocode/managePromocode/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/20' <?php if($per_page=='20'){ echo 'selected';}?>>20</option>
								<option value='<?php echo base_url();?>backend/Promocode/managePromocode/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/50' <?php if($per_page=='50'){ echo 'selected';}?>>50</option>
								<option value='<?php echo base_url();?>backend/Promocode/managePromocode/<?php if(isset($pageNo) && $pageNo!='Na') { echo $pageNo; } else { echo 'Na';}?>/100' <?php if($per_page=='100'){ echo 'selected';}?>>100</option>
								
							</select>	



						<div class="table-responsive">
							<div id="basicScenario" class="product-physical"></div>
							<?php if($promocodecnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th>Sr.No</th>
												
											<th>Promocode Code</th>
											<th>Promocode Description</th>
											<th>Promocode Type</th>
											<th>Promocode Discount</th>
											<th>Status</th>
											<th>Change Status</th>
											<th>Actions</th>	
										</tr>
									</thead>	
									<tbody>			
										<?php $i=1;
										foreach($promocodes as $promocode)
										{
										
											?>		
										<tr>
											<td><?php echo $i;?></td>
											
												<td><?php echo $promocode['promocode_code'];?></td>
												
												<td><?php echo $promocode['promocode_description'];?></td>
												<td><?php echo $promocode['promocode_type'];?></td>
												
												<td><?php echo $promocode['promocode_discount'];?></td>
												<td><?php echo $promocode['promocode_status'];?></td>
												<td>
													<?php if($promocode['promocode_status']!='Active') { ?>
														<a href="<?php echo base_url();?>backend/Promocode/change_status/<?php echo base64_encode($promocode['promocode_id']);?>/<?php echo base64_encode('Active');?>" class="btn-sm btn-success">Active</a>
														<?php } else { ?>
														<a href="<?php echo base_url();?>backend/Promocode/change_status/<?php echo base64_encode($promocode['promocode_id']);?>/<?php echo base64_encode('Inactive');?>" class="btn-sm btn-danger">Inactive</a>
													<?php } ?>
												</td>
												<td class="actions" <?php
												
												/* if(isset($modulesId)&& count($modulesId)>0)
							{ 
								if (array_search('CATEGORY', array_column($modulesId, 'edit')) !== FALSE) 
								{ 
									echo 'style="display:block;"';
							    } 
								else 
								{ 
									echo 'style="display:none;"'; 
								}
							} */
							?>>
													<a href="<?php echo base_url();?>backend/Promocode/updatePromocode/<?php echo base64_encode($promocode['promocode_id']);?>"><i data-feather="edit"></i></a>
													
													<a href="<?php echo base_url();?>backend/Promocode/deletePromocode/<?php echo base64_encode($promocode['promocode_id']);?>" onclick="javascript:return chk_isDeleteComnfirm();">
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