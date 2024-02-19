<?php

require(APPPATH.'/libraries/REST_Controller.php');



class Booking extends REST_Controller {

 

	public function __construct()

    {

        parent::__construct();

		$this->load->model('ApiModels/customer/BookingModel');

		$this->load->model('ApiModels/customer/AddressModel');

		$this->load->model('Common_Model');

		date_default_timezone_set('Asia/Kolkata');

	}

	

	public function index_post()

	{

		$token 		= $this->input->post("token");

		$user_id	= $this->input->post("user_id");

		$status		= $this->input->post("status");

		

		// $invID = str_pad($invID, 4, '0', STR_PAD_LEFT);



		if($token == TOKEN)

		{

            if($user_id=="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

             	$arrBookings = $this->BookingModel->getMyBookings($user_id, $status);

				

				if(!empty ($arrBookings))

				{

					foreach($arrBookings as $key=>$booking)

					{

						$categoryData=$this->BookingModel->getCategory($booking['category_id']);

						$main_category="";

						if($categoryData->category_parent_id!=0)

						{

							$category=$this->BookingModel->getCategory($categoryData->category_parent_id);

							$category_id=$categoryData->category_parent_id;

							$main_category=$category->category_name;

							$booking['category_name']=$main_category."-".$booking['category_name'];

						}



						if($booking['booking_status']=='waiting')

						{

							$booking['booking_status']="Waiting";

						}

						else if($booking['booking_status']=='ongoing')

						{

							$booking['booking_status']="Ongoing";

						}

						else if($booking['booking_status']=='completed')

						{

							$booking['booking_status']="Completed";

						}

						else if($booking['booking_status']=='canceled')

						{

							$booking['booking_status']="Canceled";

						}

						// Calculate Days

						$date1 = new DateTime($booking['booking_date']);

						$date1 = $date1->format('Y-m-d');

						if($booking['is_demo']=='Yes')

						{

							$date1="";

						}

						

						if($booking['expiry_date']!="" || $booking['expiry_date']!=null)

						{

							$date2 = new DateTime($booking['expiry_date']);

							$date2 = $date2->format('Y-m-d');

						}

						else

						{

							$date2="";

						}



						$date1=date_create($date1);

						$date2=date_create($date2);

						

						$interval = date_diff($date1, $date2); 

						$days  = $interval->format('%a days left'); 

						

						$booking['left_days']=$days;



						if($booking['service_provider_id']==0 && $booking['service_group_id']>0 && $booking['service_group_assigned']=='YES')

						{

							$group=$this->BookingModel->getSingleGroupInfo($booking['service_group_id'],1);

							$groupSP=$this->BookingModel->getGroupSP($booking['service_group_id'],1);

							if(isset($groupSP[0]['service_provider_id']))

							{

								$booking['service_provider_id']=$groupSP[0]['service_provider_id'];

							}

							else

							{

								$booking['service_provider_id']=0;

							}

						}

						if($booking['booking_status']!='waiting' && $booking['service_provider_id']>0)

						{

							$sp = $this->BookingModel->getUserDetails($booking['service_provider_id']);

							$booking['sp_name']=$sp->full_name;

							if($booking['service_group_id']>0)

							{

								$booking['sp_name']=$group->group_name;

							}

							$booking['sp_profile_pic']=$sp->profile_pic;

							$booking['sp_profile_id']=$sp->profile_id;

							$booking['sp_mobile']=$sp->mobile;

						}

						if($booking['is_demo']=='Yes' && $booking['booking_date']=='0000-00-00')

						{

							$booking['booking_date']=$booking['booking_date'];

							$booking['expiry_date']=$booking['expiry_date'];

						}

						else

						{

							$booking['booking_date']=$date1->format('M d,Y');

							$booking['expiry_date']=$date2->format('M d,Y');

						}

						// $booking['booking_date']=$date1->format('M d,Y');

						$arrBookings[$key]=$booking;



					}

				}

				

                $data['responsecode'] = "200";

                $data['data'] = $arrBookings;

            }

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}

		

	public function selectLocation_post()

	{

		$token 		= $this->input->post("token");

		$user_id 	= $this->input->post("user_id");

		

		if($token == TOKEN)

		{

            if($user_id =="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				$arrAddress = $this->AddressModel->getAllAddress($user_id);

				$data['responsecode'] = "200";

                $data['data'] = $arrAddress;

			}

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}

	

	public function addAddress_post()

	{

		$token 		    = $this->input->post("token");

		$user_id	    = $this->input->post("user_id");

		$address_id	    = $this->input->post("address_id");

		$type		    = $this->input->post("type");

		$address	    = $this->input->post("address");

		$city	        = $this->input->post("city");

		$zip		    = $this->input->post("zip");

		$latitude	    = $this->input->post("latitude");

		$longitude	    = $this->input->post("longitude");

		

		if($token == TOKEN)

		{

			if($type=="" || $user_id == "" || $address == "" || $city == "" || $zip == "") 

			{

				$data['responsemessage'] = 'Please provide valid data';

				$data['responsecode'] = "400";

			}	

			else

			{

                $arrUserData = array(

                        'user_id' => $user_id,

                        'address_type'=> $type,

						'address_lat'=> $latitude,

						'address_lng'=> $longitude,

                        'address1'=> $address,

                        'city'=> $city,

						'zip'=> $zip,

						'address_status'=>'Active',

                        'dateadded'=>date('Y-m-d H:i:s')

					    );



				$data['responsecode'] = "200";		

                if($address_id>0)    

				{

					$update   = $this->Common_Model->update_data('addresses','address_id',$address_id,$arrUserData);

					$data['responsemessage'] = 'Address updated successfully';

				}      

				else

				{      

                	$address_id   = $this->Common_Model->insert_data('addresses',$arrUserData);

					$data['responsemessage'] = 'Address added successfully';

				}

                

				$data['data'] = $arrUserData;

			}

		}

		else

		{

			$data['responsemessage'] = 'Token not match';

			$data['responsecode'] =  "201";

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}

	

	public function deleteAddress_post()

	{

		$token 		    = $this->input->post("token");

		$user_id	    = $this->input->post("user_id");

		$address_id	    = $this->input->post("address_id");

		

		if($token == TOKEN)

		{

			if($address_id=="" || $user_id == "") 

			{

				$data['responsemessage'] = 'Please provide valid data';

				$data['responsecode'] = "400";

			}	

			else

			{

                $arrUserData = array(

						'address_status'=>'Delete',

                        'dateupdated'=>date('Y-m-d H:i:s')

					    );



				$data['responsecode'] = "200";		

				$update   = $this->Common_Model->update_data('addresses','address_id',$address_id,$arrUserData);

				$data['responsemessage'] = 'Address deleted successfully';

				

				// $data['data'] = $arrUserData;

			}

		}

		else

		{

			$data['responsemessage'] = 'Token not match';

			$data['responsecode'] =  "201";

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function selectDateTime_post()

	{

		$token 		= $this->input->post("token");

		$user_id 	= $this->input->post("user_id");

		$date	 	= $this->input->post("date");

		$time 		= $this->input->post("time");

		$duration	= $this->input->post("duration");

		

		if($token == TOKEN)

		{

            if($user_id =="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				/*$arrAddress = $this->AddressModel->getAllAddress($user_id);

				$data['responsecode'] = "200";

                $data['data'] = $arrAddress;*/

			}

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}

	

	public function checkout_post()

	{

		$token 		= $this->input->post("token");

		$booking_id = $this->input->post("booking_id");

		

		if($token == TOKEN)

		{

            if($booking_id =="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				$tempData = $this->BookingModel->getAllCartBookingTemp();

				// print_r($tempData);

				$arrBookingData = $this->BookingModel->getCartBookingData($booking_id);

				$arrBookingData->booking_date=new DateTime($arrBookingData->booking_date);

				$arrBookingData->booking_date=$arrBookingData->booking_date->format('M d,Y');



				/***** Category with Sub Category Name **************** */

					$categoryData=$this->BookingModel->getCategory($arrBookingData->category_id);

					$main_category="";

					if($categoryData->category_parent_id!=0)

					{

						$category=$this->BookingModel->getCategory($categoryData->category_parent_id);

						$category_id=$categoryData->category_parent_id;

						$main_category=$category->category_name;

						$arrBookingData->category_name=$main_category."-".$arrBookingData->category_name;

					}

				/********************** */

				

				$arrServiceDetails = $this->BookingModel->getCartServiceDetailsWOPricing($booking_id);

				

				$arrServiceDetailsPricing = $this->BookingModel->getCartServiceDetails($booking_id);

				// print_r($arrServiceDetailsPricing);

				$total = $admin_commision = $gst_percentage = $gst_amount = $coupon_amount = $coupon_percentage = 0;

				

				if(!empty($arrServiceDetailsPricing))

				{

					foreach($arrServiceDetailsPricing as $key=>$serviceDetails)

					{

						//print_r($serviceDetails);exit;

						if($serviceDetails['duration']=='1 Year')

						{

							// $duration=str_split('12 Month');

							$duration[0]="12";

						}

						else

						{

							$duration=str_split($serviceDetails['duration']);

						}

						// print_r($duration);



						$serviceDetails['SubTotal'] = $serviceDetails['option_amount'] * $duration[0];

						$serviceDetails['duration']=$duration[0];

						$split = explode(" ", $serviceDetails['option_label']);



						// echo $split[count($split)-1];

						$serviceDetails['optionLabel'] =$serviceDetails['option_value']." ".$split[count($split)-1];

						$arrServiceDetailsPricing[$key] = $serviceDetails;

						

						$admin_commision = $serviceDetails['admin_commision'];

						

						$gst_percentage = $serviceDetails['gst_percentage'];

						

						$gst_amount = $serviceDetails['gst_amount'];

						

						$total += $serviceDetails['SubTotal'];

						

						$coupon_amount = $serviceDetails['coupon_amount'];

						

						$coupon_percentage = $serviceDetails['coupon_percentage'];

						unset($arrServiceDetailsPricing[$key]['admin_commision']);

						unset($arrServiceDetailsPricing[$key]['gst_percentage']);

						unset($arrServiceDetailsPricing[$key]['gst_amount']);

						unset($arrServiceDetailsPricing[$key]['coupon_code']);

						unset($arrServiceDetailsPricing[$key]['coupon_amount']);

						unset($arrServiceDetailsPricing[$key]['coupon_percentage']);

					}

					

					if(isset($coupon_amount) && $coupon_amount != 0)

					{

						$total = $total - $coupon_amount;

					}

				}

				/*********************************************** */

					$adminSetting=$this->Common_Model->adminSetting(1);

					// print_r($adminSetting);

					$adminper=$gstper=0;

					if($arrBookingData->category_id=='10'){ $commision_type="Daily Car Wash";}else {  $commision_type="Admin";}

					

					foreach($adminSetting as $setting)

					{

						// print_r($setting);

						

						if($setting['commission_type']==$commision_type)

						{

							$adminper=$setting['commission'];

							$admin_commision_old=($adminper/100)*$total;

						}

						// if($setting['commission_type']=='Admin')

						// {

						// 	$adminper=$setting['commission'];

						// 	$admin_commision_old=($adminper/100)*$total;

						// }

						if($setting['commission_type']=='GST')

						{

							$gstper=$setting['commission'];

							$admin_commision=$admin_commision_old*100/(100+$gstper);// New calculation

							$gst_amount=($gstper/100)*$admin_commision;

						}

					}

					// $payamount=$total + $gst_amount + $admin_commision;

					$payamount=$total;

					$updateData=array(

						'booking_amount'=>round($total),

						'gst_percentage'=>$gstper,

						'gst_amount'=>round($gst_amount),

						'admin_commision'=>round($admin_commision),

						'total_booking_amount'=>round($payamount),

					);

					$this->Common_Model->update_data('cart_booking','booking_id',$booking_id,$updateData);

				/*********************************************** */

					$paymentDetails=array();

					$paymentDetails['total'] = round($total);

					$paymentDetails['admin_commision'] = number_format($admin_commision,2);

					$paymentDetails['admin_percentage'] = $adminper;



					$paymentDetails['gst_percentage'] = $gstper;

					$paymentDetails['gst_amount'] = number_format($gst_amount,2);

					$paymentDetails['coupon_amount'] = round($coupon_amount);

					$paymentDetails['coupon_percentage'] = $coupon_percentage;

					

					// $paymentDetails['PayAmount'] = $payamount=round($total + $gst_amount + $admin_commision);

					// $paymentDetails['onemonthpayment'] = $onemonthpayment=round($payamount/$duration[0]);

					$paymentDetails['PayAmount'] = $payamount=round($total);// New calculation

					$paymentDetails['onemonthpayment'] = $onemonthpayment=round($payamount/$duration[0]);// New calculation

					

					

                $data['responsecode'] = "200";

                $data['data'] = $arrBookingData;

                $data['ServiceDetails'] = $arrServiceDetails;

				$data['ServiceDetailsPricing'] = $arrServiceDetailsPricing;

				$data['paymentDetails'] = $paymentDetails;

			}

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function Democheckout_post()

	{

		$token 		= $this->input->post("token");

		$booking_id = $this->input->post("booking_id");

		

		if($token == TOKEN)

		{

            if($booking_id =="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				$arrBookingData = $this->BookingModel->getCartBookingData($booking_id);

				$spData = $this->BookingModel->getUserDetails($arrBookingData->service_provider_id);

				$arrBookingData->sp_name=$spData->full_name;

				$arrBookingData->sp_profile_pic=$spData->profile_pic;

				$arrBookingData->sp_profile_id=$spData->profile_id;



				

				$arrServiceDetails = $this->BookingModel->getCartServiceDetailsWOPricing($booking_id);

				

				$arrServiceDetailsPricing = $this->BookingModel->getCartServiceDetails($booking_id);

				// print_r($arrServiceDetailsPricing);

				$total = $admin_commision = $gst_percentage = $gst_amount = $coupon_amount = $coupon_percentage = 0;

				

				if(!empty($arrServiceDetailsPricing))

				{

					foreach($arrServiceDetailsPricing as $key=>$serviceDetails)

					{

						$serviceDetails['SubTotal'] = $serviceDetails['option_amount'];

						

						$arrServiceDetailsPricing[$key] = $serviceDetails;

						

						$admin_commision = $serviceDetails['admin_commision'];

						

						$gst_percentage = $serviceDetails['gst_percentage'];

						

						$gst_amount = $serviceDetails['gst_amount'];

						

						$total += $serviceDetails['SubTotal'];

						

						unset($arrServiceDetailsPricing[$key]['admin_commision']);

						unset($arrServiceDetailsPricing[$key]['gst_percentage']);

						unset($arrServiceDetailsPricing[$key]['gst_amount']);

						unset($arrServiceDetailsPricing[$key]['coupon_code']);

						unset($arrServiceDetailsPricing[$key]['coupon_amount']);

						unset($arrServiceDetailsPricing[$key]['coupon_percentage']);

					}

					

				}

				

				/*****************Payment Details ************************* */

				$adminSetting=$this->Common_Model->adminSetting(1);

					// print_r($adminSetting);

					$adminper=$gstper=0;

					if($arrBookingData->category_id=='10'){ $commision_type="Daily Car Wash";}else {  $commision_type="Admin";}



					foreach($adminSetting as $setting)

					{

						if($setting['commission_type']==$commision_type)

						{

							$adminper=$setting['commission'];

							$admin_commision_old=($adminper/100)*$total;

						}

						if($setting['commission_type']=='GST')

						{

							$gstper=$setting['commission'];

							$admin_commision=$admin_commision_old*100/(100+$gstper);// New calculation

							$gst_amount=($gstper/100)*$admin_commision;

						}

					}

					$payamount=$total;

					$updateData=array(

						'booking_amount'=>round($total),

						'gst_percentage'=>$gstper,

						'gst_amount'=>number_format($gst_amount,2),

						'admin_commision'=>number_format($admin_commision,2),

						'total_booking_amount'=>round($payamount),

					);

					$this->Common_Model->update_data('cart_booking','booking_id',$booking_id,$updateData);

					/*********************************************** */

					$paymentDetails=array();

					$paymentDetails['total'] = $total;

					$paymentDetails['admin_commision'] = number_format($admin_commision,2);

					$paymentDetails['admin_percentage'] = $adminper;

					

					$paymentDetails['gst_percentage'] = $gst_percentage;

					$paymentDetails['gst_amount'] = number_format($gst_amount,2);

					

					

					// $paymentDetails['PayAmount'] = $payamount=round($total + $gst_amount + $admin_commision);

					$paymentDetails['PayAmount'] = $payamount=round($total);

					

					

                $data['responsecode'] = "200";

                $data['data'] = $arrBookingData;

				$data['ServiceDetailsPricing'] = $arrServiceDetailsPricing;

				$data['paymentDetails'] = $paymentDetails;

                

			}

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}





	public function applyPromocode_post()

	{

		$token 		= $this->input->post("token");

		$booking_id = $this->input->post("booking_id");

		$promocode_id = $this->input->post("promocode_id");

		$promocode_applied = $this->input->post("promocode_applied");

		

		if($token == TOKEN)

		{

            if($booking_id =="" )

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				$arrBookingData = $this->BookingModel->getCartBookingDataDetails($booking_id);

				$booking_amount=$arrBookingData->booking_amount;

				

				if($promocode_applied=='Yes')

				{

					$arrPromcode = $this->BookingModel->getPromocodeByid($promocode_id);

					if($arrPromcode->promocode_type=='Percentage')

					{

						$promocode_per=$arrPromcode->promocode_discount;

						$promocode_discount=($promocode_per/100)*$booking_amount;

					}

					else

					{

						$promocode_discount=$arrPromcode->promocode_discount;

					}

					$promocode_code=$arrPromcode->promocode_code;

					$coupon_percentage=$arrPromcode->promocode_discount;

				}

				else

				{

					$promocode_id=0;

					$promocode_code="";

					$promocode_discount=0;

					$coupon_percentage=0;

				}



				$inputData=array(

					'is_promo_code_applied'=>$promocode_applied,

					'coupon_id'=>$promocode_id,

					'coupon_code'=>$promocode_code,

					'coupon_amount'=>$promocode_discount,

					'coupon_percentage'=>$coupon_percentage

				);

					$this->Common_Model->update_data('cart_booking','booking_id',$booking_id,$inputData);

					

                $data['responsecode'] = "200";

				if($promocode_applied=='Yes')

				{

					$data['responsemessage'] = 'Coupon Apply Successfully';

				}

				else if($promocode_applied=='No')

				{

					$data['responsemessage'] = 'Coupon remove Successfully';

				}

				else

				{

					$data['responsemessage'] = 'Coupon apply failed';

				}

                // $data['data'] = $arrBookingData;

                

			}

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function Paymentcheckout_post()

	{

		$token 		= $this->input->post("token");

		$booking_id = $this->input->post("booking_id");

		

		if($token == TOKEN)

		{

            if($booking_id =="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				$arrBookingData = $this->BookingModel->getBookingData($booking_id);

				

				$arrServiceDetails = $this->BookingModel->getServiceDetailsWOPricing($booking_id);

				

				$arrServiceDetailsPricing = $this->BookingModel->getServiceDetails($booking_id);

				

				$total = $admin_commision = $gst_percentage = $gst_amount = $coupon_amount = $coupon_percentage = 0;

				

				if(!empty($arrServiceDetailsPricing))

				{

					foreach($arrServiceDetailsPricing as $key=>$serviceDetails)

					{

						//print_r($serviceDetails);exit;

						//print_r($serviceDetails);exit;

						if($serviceDetails['duration']=='1 Year')

						{

							// $duration=str_split('12 Month');

							$duration[0]="12";

						}

						else

						{

							$duration=str_split($serviceDetails['duration']);

						}



						$serviceDetails['SubTotal'] = $serviceDetails['option_amount'] * $duration[0];

						$serviceDetails['duration']=$duration[0];

						$arrServiceDetailsPricing[$key] = $serviceDetails;

						

						$admin_commision = $serviceDetails['admin_commision'];

						

						$gst_percentage = $serviceDetails['gst_percentage'];

						

						$gst_amount = $serviceDetails['gst_amount'];

						

						$total += $serviceDetails['SubTotal'];

						

						$coupon_amount = $serviceDetails['coupon_amount'];

						

						$coupon_percentage = $serviceDetails['coupon_percentage'];

						unset($arrServiceDetailsPricing[$key]['admin_commision']);

						unset($arrServiceDetailsPricing[$key]['gst_percentage']);

						unset($arrServiceDetailsPricing[$key]['gst_amount']);

						unset($arrServiceDetailsPricing[$key]['coupon_code']);

						unset($arrServiceDetailsPricing[$key]['coupon_amount']);

						unset($arrServiceDetailsPricing[$key]['coupon_percentage']);

					}

					

					if(isset($coupon_amount) && $coupon_amount != 0)

					{

						$total = $total - $coupon_amount;

					}

					

				}

					

					$paymentDetails=array();

					// $paymentDetails['total'] = $total;

					// $paymentDetails['admin_commision'] = $admin_commision;

					

					// $paymentDetails['gst_percentage'] = $gst_percentage;

					// $paymentDetails['gst_amount'] = $gst_amount;

					// $paymentDetails['coupon_amount'] = $coupon_amount;

					// $paymentDetails['coupon_percentage'] = $coupon_percentage;

					

					$paymentDetails['PayFullAmount'] = $PayFullAmount=$total + $gst_amount + $admin_commision;

					$paymentDetails['PayOneMonthAmount'] = $PayOneMonthAmount=$total/$duration[0];

					$paymentDetails['TotalAmount'] = $PayFullAmount;

					$paymentDetails['PendingAmount'] = $PayOneMonthAmount=$PayFullAmount-$PayOneMonthAmount;

					

                $data['responsecode'] = "200";

				$data['data'] = $paymentDetails;

			}

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	

	

	public function details_post()

	{

		$token 		= $this->input->post("token");

		$booking_id = $this->input->post("booking_id");

		

		if($token == TOKEN)

		{

            if($booking_id =="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				$arrBookingData = $this->BookingModel->getBookingData($booking_id);

				/***** Category with Sub Category Name **************** */

					$categoryData=$this->BookingModel->getCategory($arrBookingData->category_id);

					$main_category="";

					if($categoryData->category_parent_id!=0)

					{

						$category=$this->BookingModel->getCategory($categoryData->category_parent_id);

						$category_id=$categoryData->category_parent_id;

						$main_category=$category->category_name;

						$arrBookingData->category_name=$main_category."-".$arrBookingData->category_name;

					}

				/********************** */

				// echo $arrBookingData->is_demo;

				if($arrBookingData->is_demo=='No')

				{

					// Calculate Days

					$date1 = new DateTime($arrBookingData->booking_date);

					$date1 = $date1->format('Y-m-d');

					

					$date2 = new DateTime($arrBookingData->expiry_date);

					$date2 = $date2->format('Y-m-d');



					$date1=date_create($date1);

					$date2=date_create($date2);

					

					$interval = date_diff($date1, $date2); 

					$days  = $interval->format('%a'); 

					$arrBookingData->booking_date=$date1->format('M d,Y');

					$arrBookingData->expiry_date=$date2->format('M d,Y');

					$arrBookingData->left_days=$days." days left";

				

				

					// Service expire Before payment alert message

					if($days<=5)

					{

						$beforePaynow="Your service subscription is set to expire in ".$days." days. To continue enjoying the benefits of service complete your payment for the remeaning period.";	

					}

					else

					{

						$beforePaynow="";

					}

				}

				else

				{

					$beforePaynow="";

				}



				// Service provider details

				// print_r($arrBookingData);

				$sp="";

				if($arrBookingData->service_provider_id==0 && $arrBookingData->service_group_id>0 && $arrBookingData->service_group_assigned=='YES')

				{

					$group=$this->BookingModel->getSingleGroupInfo($arrBookingData->service_group_id,1);

					$groupSP=$this->BookingModel->getGroupSP($arrBookingData->service_group_id,1);

					$arrBookingData->service_provider_id=$groupSP[0]['service_provider_id'];

				}

				if($arrBookingData->service_provider_id>0)

				{

					$sp=$this->BookingModel->getSPDetails($arrBookingData->service_provider_id);

					if($arrBookingData->service_group_id>0)

					{

						$sp->full_name=$group->group_name;

					}

					$Review=$this->BookingModel->checkreviewExist(1,$arrBookingData->user_id,$arrBookingData->service_provider_id,$booking_id);

					// print_r($Review);

					//  Review

					$arrReviews=$this->BookingModel->getReviews($arrBookingData->service_provider_id);

					//echo $this->db->last_query();

					$star1=$star2=$star3=$star4=$star5=$rowCount=$average=$percent=0;

					foreach($arrReviews as $key=>$review)

					{

						if(isset($review['profile_pic']) && $review['profile_pic']!="")

						{

							$review['profile_pic']=base_url()."uploads/user_profile/".$review['profile_pic'];

						} 

						$reviewdate = new DateTime($review['dateadded']);

						$review['dateadded'] = $reviewdate->format('d M Y');



						if($review['rating']=='1')

						{

							$star1+=$review['rating'];

						}

						if($review['rating']=='2')

						{

							$star2+=$review['rating'];

						}

						if($review['rating']=='3')

						{

							$star3+=$review['rating'];

						}

						if($review['rating']=='4')

						{

							$star4+=$review['rating'];

						}

						if($review['rating']=='5')

						{

							$star5+=$review['rating'];

						}

						$arrReviews[$key]=$review;

					}

					$tot_stars = $star1 + $star2 + $star3 + $star4 + $star5;

					$reviewCount=count($arrReviews);

					if($tot_stars>0)

					{

						$average = $tot_stars/$reviewCount;

					}

					//Total Review & Rating Count

					$sp->total_rating=$reviewCount;

					$sp->rating_avg=number_format($average,1);

					if(!empty($Review))

					{

						$sp->review=$Review->review;

						$sp->rating=$Review->rating;

					}

					else

					{

						$sp->review="";

						$sp->rating=0;

					}

				}



				$arrServiceDetails = $this->BookingModel->getServiceDetailsWOPricing($booking_id);

				

				$arrServiceDetailsPricing = $this->BookingModel->getServiceDetails($booking_id);

				

				$total = $admin_commision = $gst_percentage = $gst_amount = $coupon_amount = $coupon_percentage = 0;

				

				if(!empty($arrServiceDetailsPricing))

				{

					foreach($arrServiceDetailsPricing as $key=>$serviceDetails)

					{

						//print_r($serviceDetails);exit;

						if($serviceDetails['duration']=='1 Year')

						{

							// $duration=str_split('12 Month');

							$duration[0]="12";

						}

						else

						{

							$duration=str_split($serviceDetails['duration']);

						}



						if($arrBookingData->is_demo=='No')

						{

							$serviceDetails['SubTotal'] = $serviceDetails['option_amount'] * $duration[0];

							$serviceDetails['duration']=$duration[0];

							$split = explode(" ", $serviceDetails['option_label']);



							// echo $split[count($split)-1];

							$serviceDetails['optionLabel'] =$serviceDetails['option_value']." ".$split[count($split)-1];

							$arrServiceDetailsPricing[$key] = $serviceDetails;

						}

						else

						{

							$serviceDetails['SubTotal'] = $serviceDetails['option_amount'];

							$arrServiceDetailsPricing[$key] = $serviceDetails;

						}

						

						$admin_commision = $serviceDetails['admin_commision'];

						

						$gst_percentage = $serviceDetails['gst_percentage'];

						

						$gst_amount = $serviceDetails['gst_amount'];

						

						$total += $serviceDetails['SubTotal'];

						

						$coupon_amount = $serviceDetails['coupon_amount'];

						

						$coupon_percentage = $serviceDetails['coupon_percentage'];

						unset($arrServiceDetailsPricing[$key]['admin_commision']);

						unset($arrServiceDetailsPricing[$key]['gst_percentage']);

						unset($arrServiceDetailsPricing[$key]['gst_amount']);

						unset($arrServiceDetailsPricing[$key]['coupon_code']);

						unset($arrServiceDetailsPricing[$key]['coupon_amount']);

						unset($arrServiceDetailsPricing[$key]['coupon_percentage']);

					}

					

					if(isset($coupon_amount) && $coupon_amount != 0)

					{

						$total = $total - $coupon_amount;

					}

				}



				/*********************************************** */

					$adminSetting=$this->Common_Model->adminSetting(1);

					// print_r($adminSetting);

					$adminper=$gstper=0;

					if($arrBookingData->category_id=='10'){ $commision_type="Daily Car Wash";}else {  $commision_type="Admin";}



					foreach($adminSetting as $setting)

					{

						if($setting['commission_type']==$commision_type)

						{

							$adminper=$setting['commission'];

							$admin_commision_old=($adminper/100)*$total;

							// $newch=$total

						}

						if($setting['commission_type']=='GST')

						{

							$gstper=$setting['commission'];

							$admin_commision=$admin_commision_old*100/(100+$gstper);// New calculation

							$gst_amount=($gstper/100)*$admin_commision;

							

						}

					}

					$payamount=$total + $gst_amount + $admin_commision;

					$updateData=array(

						'booking_amount'=>$total,

						'gst_percentage'=>$gstper,

						'gst_amount'=>number_format($gst_amount,2),

						'admin_commision'=>number_format($admin_commision,2),

						'total_booking_amount'=>$payamount,

					);

					$this->Common_Model->update_data('cart_booking','booking_id',$booking_id,$updateData);

				/*********************************************** */



					$paymentDetails=array();

					$paymentDetails['total'] = $total;

					$paymentDetails['admin_commision_old'] = $admin_commision_old;

					$paymentDetails['admin_commision'] = number_format($admin_commision,2);

					$paymentDetails['admin_percentage'] = $adminper;

					

					$paymentDetails['gst_percentage'] = $gstper;

					$paymentDetails['gst_amount'] = number_format($gst_amount,2);

					$paymentDetails['coupon_amount'] = $coupon_amount;

					$paymentDetails['coupon_percentage'] = $coupon_percentage;

					

					

					// $paymentDetails['PayAmount'] = $payamount=$total + $gst_amount + $admin_commision;

					$paymentDetails['PayAmount'] = $payamount=$total;

					

					

				//*********** */ Payment History ***************************

					$arrPaymentHistory=array();

					$PaymentHistory = $this->BookingModel->getBookingPaymentHistory($booking_id);

					$paid_amount=0;

					$payCount=0;

					foreach($PaymentHistory as $payHistory)

					{

						$payHistory['dateadded']=new DateTime($payHistory['dateadded']);

						$payHistory['dateadded']=$payHistory['dateadded']->format('d-m-Y');



						$payHistoryArr['payment_date']=$payHistory['dateadded'];

						$payHistoryArr['payment_amount']=$payHistory['paid_amount'];

						$payHistoryArr['reference_id']=$payHistory['transaction_id'];

						$payHistoryArr['payment_status']=$payHistory['payment_response'];

						if($payHistory['payment_response']=='success')

						{

							$paid_amount+=$payHistory['paid_amount'];

							$payCount+=1;

						}



						$arrPaymentHistory[]=$payHistoryArr;

					}

					if($duration[0]>0)

					{

						$pendingMonth=$duration[0]-$payCount;

					}

					else

					{

						$pendingMonth=0;

					}

					

					// echo $duration[0];

					// echo $payCount;

				

					$paymentDetails['PaidAmount'] = $paidamount=round($paid_amount);

					$paymentDetails['PendingAmount'] = $PendingAmount=round($payamount-$paidamount);

					if($pendingMonth>0)

					{

						$paymentDetails['onemonthpayment'] = $onemonthpayment=round($PendingAmount/$pendingMonth);

					}

					else

					{

						$paymentDetails['onemonthpayment'] =0;

					}

					



				// $arrPaymentHistory[]=array("payment_date"=>"10-11-2023","payment_amount"=>"1000","reference_id"=>"BJS123","payment_status"=>"paid");

				// $arrPaymentHistory[]=array("payment_date"=>"10-11-2023","payment_amount"=>"1000","reference_id"=>"BJS123","payment_status"=>"failed");

				

                $data['responsecode'] = "200";

                $data['data'] = $arrBookingData;

                $data['ExpiryDaysBeforePaynow'] = $beforePaynow;

                $data['ServiceProviderDetails'] = $sp;

                $data['ServiceDetails'] = $arrServiceDetails;

				$data['ServiceDetailsPricing'] = $arrServiceDetailsPricing;

				$data['paymentDetails'] = $paymentDetails;

				$data['PaymentHistory'] = $arrPaymentHistory;

                

			}

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}

	

	public function addCartBooking_post()

	{

		$token 		= $this->input->post("token");

		$user_id	= $this->input->post("user_id");

		$category_id	= $this->input->post("category_id");

		$address_id = $this->input->post("address_id");

		$booking_date = $this->input->post("booking_date");

		$time_slot = $this->input->post("time_slot");

		$duration = $this->input->post("duration");

		$is_demo = $this->input->post("is_demo");



		$category_service = $this->input->post("category_service");

		$vehichle_details = $this->input->post("vehichle_details");

		$addon_service = $this->input->post("addon_service");





		$categoryArr=json_decode($category_service);

		$vehichledetailsArr=json_decode($vehichle_details);

		$serviceData=json_decode($addon_service);



		// print_r($_POST);

		// print_r($category_service);

		// print_r($vehichle_details);

		// print_r($addon_service);



		// exit;

		$expiryDate=date('Y-m-d', strtotime('+'.$duration, strtotime($booking_date)) );

		

		if($token == TOKEN)

		{

			if($user_id=="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

                $arrBookingData = array(

								'payment_type'=>'Cash',

								'user_id' => $user_id,

								'category_id' => $category_id,

								'address_id' => $address_id,

								'booking_date' => $booking_date,

								'time_slot' => $time_slot,

								'duration' => $duration,

								'expiry_date' => $expiryDate,

								'booking_status' => 'waiting',

								'dateadded' => date('Y-m-d H:i:s'),

								);

				$booking_id = $this->Common_Model->insert_data('cart_booking',$arrBookingData);

				if($booking_id>0)

				{ 

					// $order_no= sprintf("%05d", $booking_id);

					$updateData=array(

						'order_no'=>"BJO".$booking_id

					);

					$update=$this->Common_Model->update_data('cart_booking','booking_id',$booking_id,$updateData);

					// echo $this->db->last_query();



					// Service Details data add

					if(!empty($categoryArr)) 

					{

						foreach($categoryArr as $serviceDetails)

						{

							// print_r($serviceDetails);

							$arrServiceDetails = array(

								'booking_id' => $booking_id,

								'service_id' => $serviceDetails->service_id,

								'option_label' => $serviceDetails->option_label,

								'option_value' => $serviceDetails->option_value,

								'option_amount' => $serviceDetails->option_amount,

								'dateadded' => date('Y-m-d H:i:s')

							);

							$this->Common_Model->insert_data('cart_booking_details',$arrServiceDetails);

						}

					}



					//Vehicle Details data add

					//  print_r($vehichledetailsArr);

					if(isset($vehichledetailsArr->service_id) && !empty($vehichledetailsArr) ) 

					{

						// echo "ok";

						// foreach($vehichledetailsArr as $vehichle)

						// {

							$arrVehicleDetails1 = array(

								'booking_id' => $booking_id,

								'service_id' => $vehichledetailsArr->service_id,

								'option_label' => "Car Wash",

								'option_value' => $vehichledetailsArr->option_name,

								'option_amount' => $vehichledetailsArr->option_amount,

								'dateadded' => date('Y-m-d H:i:s')

							);

							$this->Common_Model->insert_data('cart_booking_details',$arrVehicleDetails1);

							// echo $this->db->last_query();

							$arrVehicleDetails = array(

								'booking_id' => $booking_id,

								'option_label' => "Vehicle Type",

								'option_value' => $vehichledetailsArr->option_name,

								'option_amount' => "0",//$vehichledetailsArr->option_amount,

								'service_id' => $vehichledetailsArr->service_id,

								'dateadded' => date('Y-m-d H:i:s')

							);

							$this->Common_Model->insert_data('cart_booking_details',$arrVehicleDetails);

						// }

					}



					// Addon service data add

					$bookingDetails = array();

					if(!empty($serviceData)) 

					{

						foreach($serviceData as $service)

						{

							$arrBookingDetails = array(

								'booking_id' => $booking_id,

								'service_id' => $service->service_id,

								'option_label' => $service->option_label,

								'option_value' => $service->option_value,

								'option_amount' => $service->option_amount,

								'dateadded' => date('Y-m-d H:i:s')

							);

							$bookingDetails[] = $arrBookingDetails;

							

							$this->Common_Model->insert_data('cart_booking_details',$arrBookingDetails);

						}

					}

			}

				$bookingData = $this->BookingModel->getCartBookingDetails($booking_id);

                $data['responsecode'] = "200";

                $data['responsemessage'] = "Cart Booking added successfully";

                $data['data'] = $bookingData;

				

				// $data['BookingDetails'] = $bookingDetails;

            }

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function addBooking_post()

	{

		$token 		= $this->input->post("token");

		$user_id	= $this->input->post("user_id");

		$cart_booking_id	= $this->input->post("booking_id");

		$paidamount	= $this->input->post("paidamount");

		$payment_status	= $this->input->post("payment_status");

		$transaction_id	= $this->input->post("transaction_id");

		$payment_type	= $this->input->post("payment_type");



		$arrBookingData = $this->BookingModel->getCartBookingDataDetails($cart_booking_id);



		$category_id	= $arrBookingData->category_id;

		$address_id = $arrBookingData->address_id;

		$booking_date = $arrBookingData->booking_date;

		$time_slot = $arrBookingData->time_slot;

		$duration = $arrBookingData->duration;

		$expiryDate = $arrBookingData->expiry_date;

		$is_demo = $arrBookingData->is_demo;

		$coupon_id = $arrBookingData->coupon_id;

		$coupon_code = $arrBookingData->coupon_code;

		$coupon_amount = $arrBookingData->coupon_amount;

		$coupon_percentage = $arrBookingData->coupon_percentage;

		$booking_amount = $arrBookingData->booking_amount;

		$gst_percentage = $arrBookingData->gst_percentage;

		$gst_amount = $arrBookingData->gst_amount;

		$total_booking_amount = $arrBookingData->total_booking_amount;

		$admin_commision = $arrBookingData->admin_commision;		

		$service_provider_id = $arrBookingData->service_provider_id;		

		$category_name = $arrBookingData->category_name;		

		



		// echo $arrBookingData->is_demo;



		$arrAddonServiceDetails = $this->BookingModel->getCartAddonServiceDetails($cart_booking_id);

		

		if($token == TOKEN)

		{

			if($user_id=="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

                $arrBookingData = array(

					'payment_type'=>$payment_type,

					'user_id' => $user_id,

					'category_id' => $category_id,

					'address_id' => $address_id,

					'booking_date' => $booking_date,

					'time_slot' => $time_slot,

					'duration' => $duration,

					'expiry_date' => $expiryDate,

					'coupon_id' => $coupon_id,

					'coupon_code' => $coupon_code,

					'coupon_amount' => $coupon_amount,

					'coupon_percentage' => $coupon_percentage,

					'booking_amount' => $booking_amount,

					'gst_percentage' => $gst_percentage,

					'gst_amount' => $gst_amount,

					'total_booking_amount' => $total_booking_amount,

					'admin_commision' => $admin_commision,

					'service_provider_id' => $service_provider_id,

					'is_demo' => $is_demo,

					'booking_status' => 'waiting',

					'dateadded' => date('Y-m-d H:i:s'),

					);



				$booking_id = $this->Common_Model->insert_data('booking',$arrBookingData);

				if($booking_id>0)

				{ 

					$order_no= sprintf("%05d", $booking_id);

					$updateData=array(

						'order_no'=>"BJO".$order_no

					);

					$update=$this->Common_Model->update_data('booking','booking_id',$booking_id,$updateData);

					// echo $this->db->last_query();



					//Update use coupon code

					if($coupon_id>0)

					{

						$coupon_data=array('coupon_used'=>'YES');

						$this->Common_Model->update_data('promo_code','promocode_id',$coupon_id,$coupon_data);

					}

				

					// Addon service data add

					if(!empty($arrAddonServiceDetails)) 

					{

						foreach($arrAddonServiceDetails as $service)

						{

							$arrBookingDetails = array(

								'booking_id' => $booking_id,

								'service_id' => $service['service_id'],

								'option_label' => $service['option_label'],

								'option_value' => $service['option_value'],

								'option_amount' => $service['option_amount'],

								'dateadded' => date('Y-m-d H:i:s')

							);

							$this->Common_Model->insert_data('booking_details',$arrBookingDetails);

						}

					}



					//Paid Amount Transaction Entry

					if($paidamount>0)

					{

						$arrTransactionDetails = array(

							'booking_id' => $booking_id,

							'paid_amount' => $paidamount,

							'transaction_id' => $transaction_id,

							'payment_response' => $payment_status,

							'payment_type' => $payment_type,

							'user_id' => $user_id,

							'dateadded' => date('Y-m-d H:i:s')

						);

						$this->Common_Model->insert_data('booking_transaction',$arrTransactionDetails);

					}



					$userDetails=$this->BookingModel->getUserDetails($user_id);



					if($payment_status=='SUCCESS' || $payment_status=='success')

					{

						// Send Email For Payment

						$dataArr['fullname']=$userDetails->full_name;

						$dataArr['category_name']=$category_name;

						$dataArr['transaction_id']=$transaction_id;

						$dataArr['date_time']=date('Y-m-d H:i:s');

						$dataArr['paidamount']=$paidamount;

						$dataArr['payment_type']=$payment_type;



						$SubjectPay="Payment successfully";

						$mailbodyPay = $this->Common_Model->email_content('Payment',$dataArr);

						$mailPay=$this->Common_Model->SendMail($userDetails->email,$mailbodyPay,$SubjectPay);

					}



					// Send Notification order placed

					$title="New booking placed";

					$message="Your new booking no BJO$order_no successfully placed";

					$output=$this->Common_Model->sendexponotification($title,$message,$userDetails->user_fcm);



					// Send Email

					$dataMail['fullname']=$userDetails->full_name;

					$dataMail['order_no']="BJO$order_no";

					if($is_demo=='No'){

						$dataMail['booking_date']=$booking_date;

						$dataMail['expiry_date']=$expiryDate;

						$dataMail['duration']=$duration;

					} else {

						$dataMail['booking_date']=""; 

						$dataMail['expiry_date']="";

						$dataMail['duration']="";

					}



					$dataMail['category_name']=$category_name;

					$dataMail['total_booking_amount']=$total_booking_amount;

					$Subject="New booking placed";

					$mailbody = $this->Common_Model->email_content('Booking',$dataMail);

					// echo $mailbody;

					$mail=$this->Common_Model->SendMail($userDetails->email,$mailbody,$Subject);



					date_default_timezone_set('Asia/Kolkata');

					// $todayDate=date('Y-m-d H:i:s');

					$inputData=array(

						'noti_user_type'=>'Customer',

						'noti_type'=>'Booking',

						'noti_title'=>$title,

						'noti_message'=>$message,

						'noti_gcmID'=>$userDetails->user_fcm,

						'noti_user_id'=>$user_id,

						'noti_booking_id'=>$booking_id,

						'created_by'=>'1',

						'dateadded'=>date('Y-m-d H:i:s')

					);

					$this->Common_Model->insert_data('notification',$inputData);



					//Service provider Send notification 

					if($is_demo=='Yes')

					{

						$spDetails=$this->BookingModel->getUserDetails($service_provider_id);

						$title="New Booking Assigned";

						$message="Booking no BJO$order_no has been assigned to you";

						$output=$this->Common_Model->sendexponotification($title,$message,$spDetails->user_fcm);



						date_default_timezone_set('Asia/Kolkata');

						// $todayDate=date('Y-m-d H:i:s');

						$inputData=array(

							'noti_user_type'=>'Service Provider',

							'noti_type'=>'Booking',

							'noti_title'=>$title,

							'noti_message'=>$message,

							'noti_gcmID'=>$spDetails->user_fcm,

							'noti_user_id'=>$service_provider_id,

							'noti_booking_id'=>$booking_id,

							'created_by'=>'1',

							'dateadded'=>date('Y-m-d H:i:s')

						);

						$this->Common_Model->insert_data('notification',$inputData);

					}

				}



				$bookingData = $this->BookingModel->getBookingDetails($booking_id);

                $data['responsecode'] = "200";

                $data['responsemessage'] = "Booking added successfully";

                $data['data'] = $bookingData;

				

				// $data['BookingDetails'] = $bookingDetails;

            }

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function paymentBooking_post()

	{

		$token 		= $this->input->post("token");

		$user_id	= $this->input->post("user_id");

		$booking_id	= $this->input->post("booking_id");

		$paidamount	= $this->input->post("paidamount");

		$payment_status	= $this->input->post("payment_status");

		$transaction_id	= $this->input->post("transaction_id");

		$payment_type	= $this->input->post("payment_type");

		

		if($token == TOKEN)

		{

			if($user_id=="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				$bookingData = $this->BookingModel->getBookingDetails($booking_id);

					//Paid Amount Transaction Entry

					if($paidamount>0)

					{

						$arrTransactionDetails = array(

							'booking_id' => $booking_id,

							'paid_amount' => $paidamount,

							'transaction_id' => $transaction_id,

							'payment_response' => $payment_status,

							'payment_type' => $payment_type,

							'user_id' => $user_id,

							'dateadded' => date('Y-m-d H:i:s')

						);

						$this->Common_Model->insert_data('booking_transaction',$arrTransactionDetails);

					}





					// Send Notification order Payment

					if($bookingData->service_provider_id>0)

					{

						$userDetails=$this->BookingModel->getUserDetails($bookingData->service_provider_id);

						$title="Payment successfully";

						$message="Your booking no $bookingData->order_no payment successfully paid";

						$output=$this->Common_Model->sendexponotification($title,$message,$userDetails->user_fcm);



						date_default_timezone_set('Asia/Kolkata');

						$inputData=array(

							'noti_user_type'=>'Service Provider',

							'noti_type'=>'Payment',

							'noti_title'=>$title,

							'noti_message'=>$message,

							'noti_gcmID'=>$userDetails->user_fcm,

							'noti_user_id'=>$bookingData->service_provider_id,

							'noti_booking_id'=>$booking_id,

							'created_by'=>'1',

							'dateadded'=>date('Y-m-d H:i:s')

						);

						$this->Common_Model->insert_data('notification',$inputData);

					}

				

                $data['responsecode'] = "200";

                $data['responsemessage'] = "payment added successfully";

                // $data['data'] = $bookingData;

				

				// $data['BookingDetails'] = $bookingDetails;

            }

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function ccavenuepayment_post()
	{

		$token 		= $this->input->post("token");

		$user_id	= $this->input->post("user_id");

		$amount = $this->input->post("amount");

		

		if($token == TOKEN)

		{

			if(isset($amount) && $amount>0)

			{

				$order_id = rand(1000000,9999999);  

				

				$billing_name = $this->input->post('billing_name');

				$billing_address = $this->input->post('billing_address');

				$billing_city = $this->input->post('billing_city');

				$billing_state = $this->input->post('billing_state');

				$billing_country = $this->input->post('billing_country');

				$billing_tel = $this->input->post('billing_tel');

				$billing_zip = $this->input->post('billing_zip');

				$billing_email = $this->input->post('billing_email');

				$currency ='INR';

				$mid = '3082045';



				$redirect_url = 'https://appbackend.bhooljao.com/api/customer/Booking/status_payment';

				$cancel_url = 'https://appbackend.bhooljao.com/api/customer/Booking/status_payment';

				// $cancel_url = 'https://bhooljao.csns.info/api/customer/Booking/cancel_payment';

				$thankyou_url = 'https://appbackend.bhooljao.com/thankyou.php';



				// $redirect_url = 'https://bhooljao.csns.info/mobipayment/status_payment.php';

				// $cancel_url = 'https://bhooljao.csns.info/mobipayment/cancel.php';



				$access_code = 'AVFU49LA71BG61UFGB';	//Shared by CCAVENUES

				$working_key = '25F89BBF860FEB5AB9911401C1BFF915';	//Shared by CCAVENUES

				$merchant_data = 'currency='.$currency.'&merchant_id='.$mid.'&order_id='.$order_id.'&redirect_url='.$redirect_url.'&cancel_url='.$cancel_url.'&amount='.$amount.'&billing_name='.$billing_name.'&billing_address='.$billing_address.'&billing_city='.$billing_city.'&billing_state='.$billing_state.'&billing_state='.$billing_state.'&billing_country='.$billing_country.'&billing_tel='.$billing_tel.'&billing_zip='.$billing_zip.'&billing_email='.$billing_email;

				$encrypted_data = $this->Common_Model->encrypt($merchant_data, $working_key); // Method for encrypting the data.



				$data['data'] = array(

								"status" => 0,

								"status_message" => "SUCCESS",

								"order_id" => $order_id,

								"access_code" => $access_code,

								"redirect_url" => $redirect_url,

								"cancel_url" => $cancel_url,

								"thankyou_url" => $thankyou_url,

								"enc_val" => $encrypted_data

							);



				

                $data['responsecode'] = "200";

                $data['responsemessage'] = "payment added successfully";

                // $data['data'] = $bookingData;

				

				// $data['BookingDetails'] = $bookingDetails;

			}

			else

			{

				$data['data'] = array(

					"status" => 1,

					"status_message" => "amount parameter is mandatory",

				);

				$data['responsecode'] = "201";

			}

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function status_payment_post()
	{

		// $token 		= $this->input->post("token");
		// $user_id	= $this->input->post("user_id");
		$order_no 	= $this->input->post("orderNo");
		// if($token == TOKEN)
		// {
			$status = '';

			if(isset($order_no))
			{
				$access_code = 'AVFU49LA71BG61UFGB'; 	//Shared by CCAVENUES
				$working_key = '25F89BBF860FEB5AB9911401C1BFF915'; 	//Shared by CCAVENUES
				$merchant_json_data = array(
										'order_no' => $order_no,
									);

				$merchant_data = json_encode($merchant_json_data);
				$encrypted_data =$this->Common_Model->encrypt($merchant_data, $working_key); 	// Method for encrypting the data.

				// $final_data = "request_type=JSON&accessCode=".$access_code."&access_code=".$access_code."&command=orderStatusTracker&version=1.2&enc_request=" . $encrypted_data;

				$mid = '3082045';

				$final_data = "response_type=JSON&request_type=JSON&access_code=".$access_code."&command=orderStatusTracker&version=1.2&enc_request=".$encrypted_data;

				

				//$final_data = "merchant_id=".$mid."&request_type=JSON&accessCode=".$access_code."&access_code=".$access_code."&command=orderStatusTracker&version=1.2&enc_request=".$encrypted_data;

				//curl_setopt($ch, CURLOPT_URL, "https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction");


				$ch = curl_init();

				 curl_setopt($ch, CURLOPT_URL, "https://api.ccavenue.com/apis/servlet/DoWebTrans");

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

				curl_setopt($ch, CURLOPT_VERBOSE, 1);

				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

				curl_setopt($ch, CURLOPT_POST, 1);

				curl_setopt($ch, CURLOPT_POSTFIELDS, $final_data);

				curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
				$result = curl_exec($ch);
				curl_close($ch);

				$status = '';
				// print_r($result);

				$information = explode('&', $result);

				$dataSize = sizeof($information);
				// echo "<pre> Infor ";print_r($information);
				for ($i = 0; $i < $dataSize; $i++) {
					$info_value = explode('=', $information[$i]);
					if ($info_value[0] == 'enc_response') {
					$status = $this->Common_Model->decrypt(trim($info_value[1]), $working_key);
					// echo $status;
					//decrypting response
					}
				}

				// echo $status;//exit;
				$paymentResponse=$status;
				 $dataStatus=json_decode($status);

				//  if($dataStatus->order_status=='Unsuccessful')
				//  {
				//  	$data['responsecode'] = "201";
	            //     $data['data'] = array(
				// 	"status" => 1,
				// 	"status_message" => "Payment failed",
				// 	);
				//  }
				// else if((isset($dataStatus->status) && $dataSize>0))
				// {

					$data['responsecode'] = "200";
	                $data['responsemessage'] = "payment added successfully";
					 // echo $paymentResponse;
					$inputData=array(
						'reference_no'=>$dataStatus->reference_no,
						'order_no'=>$dataStatus->order_no,
						'order_amt'=>$dataStatus->order_amt,
						'order_date_time'=>$dataStatus->order_date_time,
						'order_bill_name'=>$dataStatus->order_bill_name,
						'order_bill_address'=>$dataStatus->order_bill_address,
						'order_bill_zip'=>$dataStatus->order_bill_zip,
						'order_bill_tel'=>$dataStatus->order_bill_tel,
						'order_bill_email'=>$dataStatus->order_bill_email,
						'order_bill_country'=>$dataStatus->order_bill_country,
						'error_desc'=>$dataStatus->error_desc,
						'status'=>$dataStatus->status,
						'order_status'=>$dataStatus->order_status,
						'error_code'=>$dataStatus->error_code,
						'payment_response'=>$paymentResponse,
						'dateadded'=>date('Y-m-d H:i:s')
					);

					$this->Common_Model->insert_data('booking_payment',$inputData);
					// echo $this->db->last_query();
					// $payment=$this->BookingModel->getAllpayment($dataStatus->order_no);

					// print_r($payment);

	                $data['data'] = $status;

	            // }
	            // else
	            // {
	            // 	$data['responsecode'] = "201";
	            //     $data['data'] = array(
				// 	"status" => 1,
				// 	"status_message" => "Payment failed",
				// 	);
	            // }

				// print_r($status);

                // $data['data'] = $bookingData;
				// $data['BookingDetails'] = $bookingDetails;
			}
			else
			{
				$data['data'] = array(
					"status" => 1,
					"status_message" => "order number is mandatory",
				);
				$data['responsecode'] = "201";
			}
			header("Location: https://appbackend.bhooljao.com/thankyou.php"); 
			exit;

			// redirect('https://bhooljao.csns.info/thankyou.php');

		//  	$obj = (object)$data;//Creating Object from array

		// 	$response = json_encode($obj);

		// // $response = $obj;

		// 	print_r($response);

	}



	public function cancel_payment_post()

	{

		$data['responsecode'] = "200";

		// $data['responsemessage'] = "payment added successfully";

		$data['data'] = "You transaction is cancelled you will be redirecting Shortly";

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function ccavenueBookingpayment_post()
	{

		$token 		= $this->input->post("token");
		$user_id	= $this->input->post("user_id");
		$order_no	= $this->input->post("order_no");

		if($token == TOKEN)

		{

			if($order_no=="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				$paymentData = $this->BookingModel->getAllpayment($order_no);
				// print_r($paymentData);
				

                $data['responsecode'] = "200";
                $data['data'] = $paymentData;
				// $data['BookingDetails'] = $bookingDetails;

            }

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function BackeupaddBooking_post()

	{

		$token 		= $this->input->post("token");

		$user_id	= $this->input->post("user_id");

		$category_id	= $this->input->post("category_id");

		$address_id = $this->input->post("address_id");

		$booking_date = $this->input->post("booking_date");

		$time_slot = $this->input->post("time_slot");

		$duration = $this->input->post("duration");

		$is_demo = $this->input->post("is_demo");



		$category_service = $this->input->post("category_service");

		$vehichle_details = $this->input->post("vehichle_details");

		$addon_service = $this->input->post("addon_service");





		$categoryArr=json_decode($category_service);

		$vehichledetailsArr=json_decode($vehichle_details);

		$serviceData=json_decode($addon_service);



		// print_r($_POST);

		// print_r($category_service);

		// print_r($vehichle_details);

		// print_r($addon_service);



		// exit;

		$expiryDate=date('Y-m-d', strtotime('+'.$duration, strtotime($booking_date)) );

		

		if($token == TOKEN)

		{

			if($user_id=="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

                $arrBookingData = array(

								'payment_type'=>'Cash',

								'user_id' => $user_id,

								'category_id' => $category_id,

								'address_id' => $address_id,

								'booking_date' => $booking_date,

								'time_slot' => $time_slot,

								'duration' => $duration,

								'expiry_date' => $expiryDate,

								'booking_status' => 'waiting',

								'dateadded' => date('Y-m-d H:i:s'),

								);

				$booking_id = $this->Common_Model->insert_data('booking',$arrBookingData);

				if($booking_id>0)

				{ 

					$order_no= sprintf("%05d", $booking_id);

					$updateData=array(

						'order_no'=>"BJO".$order_no

					);

					$update=$this->Common_Model->update_data('booking','booking_id',$booking_id,$updateData);

					// echo $this->db->last_query();



					// Service Details data add

					if(!empty($categoryArr)) 

					{

						foreach($categoryArr as $serviceDetails)

						{

							// print_r($serviceDetails);

							$arrServiceDetails = array(

								'booking_id' => $booking_id,

								'service_id' => $serviceDetails->service_id,

								'option_label' => $serviceDetails->option_label,

								'option_value' => $serviceDetails->option_value,

								'option_amount' => $serviceDetails->option_amount,

								'dateadded' => date('Y-m-d H:i:s')

							);

							$this->Common_Model->insert_data('booking_details',$arrServiceDetails);

						}

					}



					//Vehicle Details data add

					// print_r($vehichledetailsArr);

					if(isset($vehichledetailsArr->service_id) && !empty($vehichledetailsArr) ) 

					{

						// echo "ok";

						// foreach($vehichledetailsArr as $vehichle)

						// {

							$arrVehicleDetails1 = array(

								'booking_id' => $booking_id,

								'service_id' => $vehichledetailsArr->service_id,

								'option_label' => "Car Wash",

								'option_value' => $vehichledetailsArr->option_name,

								'option_amount' => $vehichledetailsArr->option_amount,

								'dateadded' => date('Y-m-d H:i:s')

							);

							$this->Common_Model->insert_data('booking_details',$arrVehicleDetails1);



							$arrVehicleDetails = array(

								'booking_id' => $booking_id,

								'option_label' => "Vehicle Type",

								'option_value' => $vehichledetailsArr->option_name,

								'option_amount' => "0",//$vehichledetailsArr->option_amount,

								'service_id' => $vehichledetailsArr->service_id,

								'dateadded' => date('Y-m-d H:i:s')

							);

							$this->Common_Model->insert_data('booking_details',$arrVehicleDetails);

						// }

					}



					// Addon service data add

					$bookingDetails = array();

					if(!empty($serviceData)) 

					{

						foreach($serviceData as $service)

						{

							$arrBookingDetails = array(

								'booking_id' => $booking_id,

								'service_id' => $service->service_id,

								'option_label' => $service->option_label,

								'option_value' => $service->option_value,

								'option_amount' => $service->option_amount,

								'dateadded' => date('Y-m-d H:i:s')

							);

							$bookingDetails[] = $arrBookingDetails;

							

							$this->Common_Model->insert_data('booking_details',$arrBookingDetails);

						}

					}

			}

				$bookingData = $this->BookingModel->getBookingDetails($booking_id);

                $data['responsecode'] = "200";

                $data['responsemessage'] = "Booking added successfully";

                $data['data'] = $bookingData;

				

				// $data['BookingDetails'] = $bookingDetails;

            }

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}

	

	public function addDemoBooking_post()

	{

		$token 		= $this->input->post("token");

		$user_id	= $this->input->post("user_id");

		$service_provider_id	= $this->input->post("service_provider_id");

		$category_id	= $this->input->post("category_id");

		$address_id = $this->input->post("address_id");

		// $payment_type = $this->input->post("payment_type");

		$is_demo = "Yes";

	

		// exit;

		

		if($token == TOKEN)

		{

			if($user_id=="" || $service_provider_id=="" || $category_id=="" || $address_id=="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				$sp=$this->BookingModel->getSPDetails($service_provider_id);

				// print_r($sp);

				// $category_id=$sp->category_id;

				// echo $category_id;

				// exit;

                $arrBookingData = array(

								'payment_type'=>'Cash',

								'user_id' => $user_id,

								'category_id' => $category_id,

								'address_id' => $address_id,

								'service_provider_id' => $service_provider_id,

								'booking_status' => 'waiting',

								'is_demo' => $is_demo,

								'dateadded' => date('Y-m-d H:i:s'),

								);

				$booking_id = $this->Common_Model->insert_data('cart_booking',$arrBookingData);

				if($booking_id>0)

				{ 

					// $order_no= sprintf("%05d", $booking_id);

					$updateData=array(

						'order_no'=>"BJO".$booking_id

					);

					$update=$this->Common_Model->update_data('cart_booking','booking_id',$booking_id,$updateData);

					// echo $this->db->last_query();



					// Service Details data add

					$serviceDetails=$this->BookingModel->getServiceDetailsByCategoryId($category_id);

					// print_r($serviceDetails);

					$arrServiceDetails = array(

						'booking_id' => $booking_id,

						'service_id' => $serviceDetails[0]['service_id'],

						'option_label' => $serviceDetails[0]['service_name'],

						'option_value' => "",

						'option_amount' => $serviceDetails[0]['service_demo_discount_price'],

						'dateadded' => date('Y-m-d H:i:s')

					);

					$this->Common_Model->insert_data('cart_booking_details',$arrServiceDetails);



					/*****************GST And Admin Service Charges Calculation ****************************** */

					$booking_amount=$serviceDetails[0]['service_demo_discount_price'];

					$adminSetting=$this->Common_Model->adminSetting(1);

					// print_r($adminSetting);

					$adminper=$gstper=$admin_commision=$gst_amount=0;



					foreach($adminSetting as $setting)

					{

						if($setting['commission_type']=='Admin')

						{

							$adminper=$setting['commission'];

							$admin_commision=($adminper/100)*$booking_amount;

						}

						if($setting['commission_type']=='GST')

						{

							$gstper=$setting['commission'];

							$gst_amount=($gstper/100)*$booking_amount;

						}

					}



					$payamount=$booking_amount + $gst_amount + $admin_commision;

					// Update AMount

					$updateDataArr=array(

						'booking_amount'=> $serviceDetails[0]['service_demo_discount_price'],

						'gst_percentage'=>$gstper,

						'gst_amount'=>$gst_amount,

						'admin_commision'=>$admin_commision,

						'total_booking_amount'=> $payamount,

					);

					$update=$this->Common_Model->update_data('cart_booking','booking_id',$booking_id,$updateDataArr);

				/*********************************************** */



					

					// echo $this->db->last_query();

			}

				$bookingData = $this->BookingModel->getCartBookingDataDetails($booking_id);

                $data['responsecode'] = "200";

                $data['responsemessage'] = "Demo Booking added successfully";

                $data['data'] = $bookingData;

				

				// $data['BookingDetails'] = $bookingDetails;

            }

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function addFavourite_post()

	{

		$token 		= $this->input->post("token");

		$user_id = $this->input->post("user_id");

		$service_provider_id = $this->input->post("service_provider_id");

		$isfavourite = $this->input->post("isfavourite");

		

		if($token == TOKEN)

		{

            if($user_id =="" || $service_provider_id=="" || $isfavourite=="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				if($isfavourite=='true')

				{

					$favourite='Yes';

				}

				else

				{

					$favourite='No';

				}

					$inputData=array(

						'user_id'=>$user_id,

						'service_provider_id'=>$service_provider_id,

						'is_favourite'=>$favourite,

						'dateupdated'=>date('Y-m-d H:i:s')

					);



					$check=$this->BookingModel->checkFavourite(0,$user_id,$service_provider_id);

					if($check>0)

					{

						$checkData=$this->BookingModel->checkFavourite(1,$user_id,$service_provider_id);

						$this->Common_Model->update_data('sp_favourite_verify','favourite_id',$checkData->favourite_id,$inputData);

					}

					else

					{

						$this->Common_Model->insert_data('sp_favourite_verify',$inputData);

					}

					

                $data['responsecode'] = "200";



				if($isfavourite=='true')

				{

					$data['responsemessage'] = 'Favourite added successfully';

				}

				else

				{

					$data['responsemessage'] = 'Favourite remove successfully';

				}



			}

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function FavouriteList_post()

	{

		$token 		= $this->input->post("token");

		$user_id = $this->input->post("user_id");

		// $service_provider_id = $this->input->post("service_provider_id");

		

		if($token == TOKEN)

		{

            if($user_id =="" )

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				$favList=$this->BookingModel->FavouriteList(1,$user_id);

				foreach($favList as $k=>$sp)

				{

					//  Review

					$arrReviewsData=$this->BookingModel->getReviews($sp['service_provider_id']);

					//echo $this->db->last_query();

					$star1=$star2=$star3=$star4=$star5=$rowCount=$average=$percent=$tot_stars=0;

					foreach($arrReviewsData as $key=>$review)

					{

						if(isset($review['profile_pic']) && $review['profile_pic']!="")

						{

							$review['profile_pic']=base_url()."uploads/user_profile/".$review['profile_pic'];

						} 

						$reviewdate = new DateTime($review['dateadded']);

						$review['dateadded'] = $reviewdate->format('d M Y');



						if($review['rating']=='1')

						{

							$star1+=$review['rating'];

						}

						if($review['rating']=='2')

						{

							$star2+=$review['rating'];

						}

						if($review['rating']=='3')

						{

							$star3+=$review['rating'];

						}

						if($review['rating']=='4')

						{

							$star4+=$review['rating'];

						}

						if($review['rating']=='5')

						{

							$star5+=$review['rating'];

						}

						$arrReviewsData[$key]=$review;

					}

					$tot_stars = $star1 + $star2 + $star3 + $star4 + $star5;

					$reviewCount=count($arrReviewsData);

					// echo $tot_stars."<br>";

					if($tot_stars>0)

					{

						$average = $tot_stars/$reviewCount;

					}

					else

					{

						$average=0;

					}

					//Total Review & Rating Count

					$sp['total_rating']=$reviewCount;

					// $sp['rating_avg']=number_format($average,1);

					$sp['rating_avg']=$average;



					

					$sp['isVerified']=false;

					$sp['isFavourite']=false;



					// Is Favourite and Verified

					$isFavourite = $this->BookingModel->checkIsFavourite($user_id,$sp['service_provider_id']);

					$isverified = $this->BookingModel->checkIsVerified($sp['service_provider_id']);

					// print_r($isFavourite);

					if(!empty($isFavourite))

					{

						if($isFavourite->is_favourite=='Yes')

						{

							$sp['isFavourite']=true;

						}

					}



					if(!empty($isverified))

					{

						if($isverified->is_verified=='Yes')

						{

							$sp['isVerified']=true;

						}

					}

					

					if(!isset($sp['distance']))

					{

						$sp['distance']="";

					}

					if(!isset($sp['address']))

					{

						$sp['address']="";

					}

					if(!isset($sp['category_name']))

					{

						$sp['category_name']="";

					}

					if(!isset($sp['profile_pic']))

					{

						$sp['profile_pic']="";

					}



					// Subcategory available

					$subcategories = $this->BookingModel->getAllSubCategories(0,$sp['category_id']);

					$sp['isSubcategoryAvailable']=false;

					if($subcategories>0)

					{

						$sp['isSubcategoryAvailable']=true;

					}



					$favList[$k]=$sp;

				}



                $data['data'] = $favList;

                $data['responsecode'] = "200";

			}

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function bookingCanceled_post()

	{

		$token 		= $this->input->post("token");

		$booking_id = $this->input->post("booking_id");

		

		if($token == TOKEN)

		{

            if($booking_id =="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				$inputData=array(

					'booking_status'=>'canceled',

					'dateupdated'=>date('Y-m-d H:i:s')

				);

				 $this->Common_Model->update_data('booking','booking_id',$booking_id,$inputData);



				$bookingDate=$this->BookingModel->getBookingDetails($booking_id);

				$categoryData=$this->BookingModel->getCategory($bookingDate->category_id);





				// Send Notification order placed

				$customerDetails=$this->BookingModel->getUserDetails($bookingDate->user_id);

				$title="Booking Canceled";

				$message="The booking of $bookingDate->order_no has canceled";

				$output=$this->Common_Model->sendexponotification($title,$message,$customerDetails->user_fcm);



				date_default_timezone_set('Asia/Kolkata');

				$inputDataCustomer=array(

					'noti_user_type'=>'Customer',

					'noti_type'=>'Booking',

					'noti_title'=>$title,

					'noti_message'=>$message,

					'noti_gcmID'=>$customerDetails->user_fcm,

					'noti_user_id'=>$bookingDate->user_id,

					'noti_booking_id'=>$booking_id,

					'created_by'=>'1',

					'dateadded'=>date('Y-m-d H:i:s')

				);

				$this->Common_Model->insert_data('notification',$inputDataCustomer);



				// Send Email for customer

				$data['fullname']=$customerDetails->full_name;

				$data['order_no']=$bookingDate->order_no;

				$data['booking_date']=$bookingDate->booking_date;

				$data['time_slot']=$bookingDate->time_slot;

				$data['category_name']=$categoryData->category_name;



				$Subject="Booking canceled - $bookingDate->order_no";

				$mailbody = $this->Common_Model->email_content('BookingCancel',$data);

				$mail=$this->Common_Model->SendMail($customerDetails->email,$mailbody,$Subject);



				$userDetails=$this->BookingModel->getUserDetails($bookingDate->service_provider_id);

				if(isset($userDetails->user_fcm) && $userDetails->user_fcm!="")

				{

				// Sp Notification Send

					$title="Booking Canceled";

					$message="The booking of $bookingDate->order_no has canceled";

					$output=$this->Common_Model->sendexponotification($title,$message,$userDetails->user_fcm);

					

					// Send Mail SP

					$dataArr['fullname']=$userDetails->full_name;

					$dataArr['order_no']=$bookingDate->order_no;

					$dataArr['booking_date']=$bookingDate->booking_date;

					$dataArr['time_slot']=$bookingDate->time_slot;

					$dataArr['category_name']=$categoryData->category_name;

					$mailbody = $this->Common_Model->email_content('BookingCancel',$dataArr);

					// $mailsp=$this->Common_Model->SendMail($userDetails->email,$mailbody,$Subject);



					date_default_timezone_set('Asia/Kolkata');

					$inputData=array(

						'noti_user_type'=>'Service Provider',

						'noti_type'=>'Booking',

						'noti_title'=>$title,

						'noti_message'=>$message,

						'noti_gcmID'=>$userDetails->user_fcm,

						'noti_user_id'=>$bookingDate->service_provider_id,

						'noti_booking_id'=>$booking_id,

						'created_by'=>'1',

						'dateadded'=>date('Y-m-d H:i:s')

					);

					$this->Common_Model->insert_data('notification',$inputData);

				}

				

                $data['responsecode'] = "200";

				$data['responsemessage'] = 'Your Booking canceled successfully';

			}

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function workHistory_post()

	{

		$token 		= $this->input->post("token");

		$booking_id	= $this->input->post("booking_id");

				

		if($token == TOKEN)

		{

            if($booking_id=="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				

				$bookingData = $this->BookingModel->getBookingDetails($booking_id);



                $arrWorkhistory = $this->BookingModel->getBookingWorkHistory($booking_id);

				foreach($arrWorkhistory as $key=>$history)

				{

					$history['history_date']=new DateTime($history['history_date']);

					$history['history_date']=$history['history_date']->format('d-m-Y');

					$arrWorkhistory[$key]=$history;

				}

                $data['responsecode'] = "200";

                $data['order_no'] = $bookingData->order_no;

                $data['booking_status'] = $bookingData->booking_status;

                $data['data'] = $arrWorkhistory;

            }

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function promocodeList_post()

	{

		$token 		= $this->input->post("token");

		$user_id 	= $this->input->post("user_id");

				

		if($token == TOKEN)

		{

			$arrPromocode = $this->BookingModel->getPromocode();

			$arrUserPromocode = $this->BookingModel->getUserPromocode($user_id);

			

			$promocode=array_merge($arrPromocode,$arrUserPromocode);

			// print_r($promocode);

			$data['responsecode'] = "200";

			$data['data'] = $promocode;

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function addFeedback_post()

	{

		$token 					= $this->input->post("token");

		$user_id 				= $this->input->post("user_id");

		$booking_id 			= $this->input->post("booking_id");

	    $service_provider_id 	= $this->input->post("service_provider_id");

		$feedback 				= $this->input->post("feedback");

				

		if($token == TOKEN)

		{

			if($booking_id=="" || $user_id=="" || $service_provider_id=="" || $feedback=="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				$inputData=array(

					'booking_id'=>$booking_id,

					'user_id'=>$user_id,

					'service_provider_id'=>$service_provider_id,

					'feedback_message'=>$feedback,

					'dateadded'=>date('Y-m-d H:i:s')

				);



				$feedbackExist=$this->BookingModel->checkFeedbackExist(0,$booking_id,$user_id,$service_provider_id);

				if($feedbackExist>0)

				{

					$feedback=$this->BookingModel->checkFeedbackExist(1,$booking_id,$user_id,$service_provider_id);

					$feedback_id=$feedback->feedback_id;

					$this->Common_Model->update_data('feedback','feedback_id',$feedback_id,$inputData);

				}

				else 

				{	

					$feedback_id=$this->Common_Model->insert_data('feedback',$inputData);

				}



				$arrFeedback = $this->BookingModel->getFeedback($feedback_id);

				

				$data['responsecode'] = "200";

				$data['data'] = $arrFeedback;

			}

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function addReview_post()

	{

		// ini_set('display_errors', 1);

		// ini_set('display_startup_errors', 1);

		// error_reporting(E_ALL);

		$token 			     = $this->input->post("token");

		$user_id 		     = $this->input->post("user_id");

		$service_provider_id = $this->input->post("service_provider_id");

		$review	             = $this->input->post("review");

		$rating	             = $this->input->post("rating");

		$booking_id	         = $this->input->post("booking_id");

		

		if($token == TOKEN)

		{

			if($user_id =="" || $service_provider_id=="" || $service_provider_id=="undefined" || $review==""  || $booking_id=="" || $booking_id=="undefined")

			{

				$data['responsemessage'] = 'Please provide valid data';

				$data['responsecode'] = "400";

			}	

			else

			{

				$arrUserData = array(

					'user_id' => $user_id,

					'service_provider_id' => $service_provider_id,

					'rating' => $rating,

					'review' => $review,

					'dateadded' => date('Y-m-d H:i:s')

					);



				$checkReview=$this->BookingModel->checkreviewExist(0,$user_id,$service_provider_id,$booking_id);		

				if($checkReview>0)

				{

					$Review=$this->BookingModel->checkreviewExist(1,$user_id,$service_provider_id,$booking_id);

					$review_id=$Review->review_id;

					$this->Common_Model->update_data('review','review_id',$review_id,$arrUserData);

				}  

				else

				{

					$result   = $this->Common_Model->insert_data('review',$arrUserData);

				}

				$data['responsemessage'] = 'Rating added successfully';

				$data['responsecode'] = "200";

			}

		}

		else

		{

			$data['responsemessage'] = 'Token not match';

			$data['responsecode'] =  "201";

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function Reviews_post()

	{

		$token 		= $this->input->post("token");

		$user_id 	= $this->input->post("service_provider_id");

		

		if($token == TOKEN)

		{

			if($user_id=="")

			{

				$response_array['responsecode'] = "400";

				$response_array['responsemessage'] = 'Please Provide valid data';

			}

			else

			{

				// Rating Percentage Code Start

				$rating_arr=array();

				$ratings=$this->BookingModel->getRatingPercentage($user_id);

				$star1=$star2=$star3=$star4=$star5=$rowCount=$average=$percent=0;

				foreach($ratings as $rating)

				{

					if($rating['rating']=='1')

					{

						$star1+=$rating['rating'];

					}

					if($rating['rating']=='2')

					{

						$star2+=$rating['rating'];

					}

					if($rating['rating']=='3')

					{

						$star3+=$rating['rating'];

					}

					if($rating['rating']=='4')

					{

						$star4+=$rating['rating'];

					}

					if($rating['rating']=='5')

					{

						$star5+=$rating['rating'];

					}

				}



				$tot_stars = $star1 + $star2 + $star3 + $star4 + $star5;

				$rowCount=count($ratings);



				if($tot_stars>0)

				{

					$average = $tot_stars/$rowCount;

				}

				$rating_arr['average']=number_format($average,1);

				$rating_arr['total']=$rowCount;



				for ($i=1;$i<=5;++$i) 

				{

					$var = "star$i";

					$count = $$var;

					if($tot_stars>0)

					{

						$percent = $count * 100 / $tot_stars;

					}

					$rating_arr['star'.$i.'_total']=$count;

					$rating_arr['star'.$i.'_per']=round($percent);

				}



				$arrReviews=$this->BookingModel->getReviews($user_id);

				//echo $this->db->last_query();

				foreach($arrReviews as $key=>$review)

				{

					if(isset($review['profile_pic']) && $review['profile_pic']!="")

					{

						$review['profile_pic']=base_url()."uploads/user_profile/".$review['profile_pic'];

					} 

					

					$arrReviews[$key]=$review;

				}

				

				$response_array['responsecode'] = "200";

				$response_array['data']['Ratings'] = $rating_arr;

				$response_array['data']['Reviews'] = $arrReviews;

			}

		}

		else

		{

			$response_array['responsecode'] = "201";

			$response_array['responsemessage'] = 'Token did not match';

		}

		$obj = (object)$response_array;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	public function paymentList_post()

	{

		$token 		= $this->input->post("token");

		$user_id	= $this->input->post("user_id");

				

		if($token == TOKEN)

		{

            if($user_id=="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				

				$arrPaymentHistory=array();

				$PaymentHistory = $this->BookingModel->getPaymentHistoryByCustomer($user_id);

				$paid_amount=0;

				$payCount=0;

				foreach($PaymentHistory as $payHistory)

				{

					$payHistory['dateadded']=new DateTime($payHistory['dateadded']);

					$payHistory['dateadded']=$payHistory['dateadded']->format('d-m-Y');



					$payHistoryArr['payment_date']=$payHistory['dateadded'];

					$payHistoryArr['payment_amount']=$payHistory['paid_amount'];

					$payHistoryArr['reference_id']=$payHistory['transaction_id'];

					$payHistoryArr['payment_status']=$payHistory['payment_response'];

					if($payHistory['payment_response']=='success')

					{

						$paid_amount+=$payHistory['paid_amount'];

						$payCount+=1;

					}



					$arrPaymentHistory[]=$payHistoryArr;

				}

                $data['responsecode'] = "200";

                $data['data'] = $arrPaymentHistory;

            }

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}

	

	public function notifications_post()

	{

		$token 		= $this->input->post("token");

		$user_id = $this->input->post("user_id");

		

		if($token == TOKEN)

		{

            if($user_id =="")

            {

                $data['responsemessage'] = 'Please provide valid data ';

                $data['responsecode'] = "400"; //create an array

            }

            else

            {

				$arrNotifications = $this->BookingModel->getnotifications($user_id);

                $data['responsecode'] = "200";

                $data['data'] = $arrNotifications;

			}

		}

		else

		{

			$data['responsecode'] = "201";

			$data['responsemessage'] = 'Token did not match';

		}	

		$obj = (object)$data;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}

	/* ------------------------------------------- */ 	

	

	public function change_status_post()

	{

		$substatus="";

		$token 		= $this->input->post("token");

		$user_id 		= $this->input->post("user_id");

		$booking_id 	= $this->input->post("booking_id");

		$status 		= $this->input->post("status");

	 

		if($token == TOKEN)

		{

			if($user_id=="" || $booking_id=="" || $status=="")

			{

				$response_array['responsecode'] = "400";

				$response_array['responsemessage'] = 'Please Provide valid data';

			}

			else

			{

				// echo $this->db->last_query();

				//print_r($user);

				$checkBooking=0;

				

					$inputData=array(

						'booking_status' => $status,

						'service_provider_id'=>5

					);

					$this->Common_Model->update_data('booking','booking_id',$booking_id,$inputData);

					// echo $this->db->last_query();

					$response_array['responsecode'] = "200";

					$response_array['responsemessage'] = 'Status updated successfully';

			}

		}

		else

		{

			$response_array['responsecode'] = "201";

			$response_array['responsemessage'] = 'Token did not match';

		}

		$obj = (object)$response_array;//Creating Object from array

		$response = json_encode($obj);

		print_r($response);

	}



	



}

