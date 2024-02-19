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
						<h5>INCOME </h5>			
						<div class="card-header-right">
						<div class="row">
							<div class="col-lg-12">
								<a class="btn btn-default"  href="<?php echo base_url();?>backend/Booking/exportBookingCSV" style="float:right"><i class="fa fa-download"></i>Export CSV</a>
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
							<?php if(!empty($income_data))	{ ?>
								<table class="table table-bordered table-striped mb-0" id="datatable-default">
									<thead>
										<tr>
											<th>Date</th>
											<th>Order No</th>
											<th>Amount</th>
										</tr>
                                        <tr>
											<th>Total</th>
											<th></th>
											<th><?php echo $total;?></th>
										</tr>
									</thead>	
									<tbody>			
										<?php 
										$i=1;
										foreach($income_data as $booking)
										{
                                            $booking['dateadded']= new DateTime($booking['dateadded']);
                                            $booking['dateadded']=$booking['dateadded']->format('d-M-Y');
										?>		
										<tr>
												<td><?php echo $booking['dateadded'];?></td>
												<td><?php echo $booking['order_no'];?></td> 
												<td><?php echo $booking['amount'];?></td>				
										</tr>											
											<?php $i++; }?>
											</tbody>									
										</table>
										<div class="dataTables_paginate paging_simple_numbers col-md-10" id="datatable-default_paginate" style="margin-top:10px;float:left">
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