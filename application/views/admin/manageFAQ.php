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
						<h5>FAQ </h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								<a class="btn btn-default"  href="<?php echo base_url();?>backend/FAQ/addFAQ" style="float:right"><i class="fa fa-plus-circle"></i>Add FAQ</a>
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
						<form method="POST" action="<?php echo base_url().'backend/FAQ/manageFAQ/'; ?><?php if($this->uri->segment(4)!=""){ echo $this->uri->segment(4);}?>/
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
							<?php if($faqcnt > 0)	{ ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
												
											<th>FAQ Question</th>
											<th>FAQ Answer</th>
											<th>FAQ Type</th>
											<th>Status</th>
											<th>Change Status</th>
											<th>Actions</th>	
										</tr>
									</thead>	
									<tbody>			
										<?php 
										foreach($FAQS as $faq)
										{
											
											?>		
										<tr>
												<td><?php echo $faq['faq_question'];?></td>
												
												
												<td><?php echo $faq['faq_answer'];?></td>
												<td><?php echo $faq['faq_type'];?></td>
												<td><?php echo $faq['faq_status'];?></td>
												<td>
													<?php if($faq['faq_status']!='Active') { ?>
														<a href="<?php echo base_url();?>backend/FAQ/change_status/<?php echo base64_encode($faq['faq_id']);?>/<?php echo base64_encode('Active');?>" class="btn-sm btn-success">Active</a>
														<?php } else { ?>
														<a href="<?php echo base_url();?>backend/FAQ/change_status/<?php echo base64_encode($faq['faq_id']);?>/<?php echo base64_encode('Inactive');?>" class="btn-sm btn-danger">Inactive</a>
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
													<a href="<?php echo base_url();?>backend/FAQ/updateFAQ/<?php echo base64_encode($faq['faq_id']);?>"><i data-feather="edit"></i></a>
													
													<a href="<?php echo base_url();?>backend/FAQ/deleteFAQ/<?php echo base64_encode($faq['faq_id']);?>" onclick="javascript:return chk_isDeleteComnfirm();">
													<i data-feather="trash-2"></i>
													</a>
											</td>				
											</tr>											
											<?php  }?>
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