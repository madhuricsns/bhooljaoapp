<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Booking extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('ApiModels/customer/BookingModel');
		$this->load->model('Common_Model');
	}
	
	public function index_post()
	{
		$token 		= $this->input->post("token");
		$user_id	= $this->input->post("user_id");
		$status		= $this->input->post("status");
		
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
						if($booking['booking_status']=='waiting')
						{
							$booking['booking_status']="Waiting";
						}
						else if($booking['booking_status']=='accepted')
						{
							$booking['booking_status']="Accepted";
						}
						else if($booking['booking_status']=='ongoing')
						{
							$booking['booking_status']="Ongoing";
						}
						else if($booking['booking_status']=='completed')
						{
							$booking['booking_status']="Completed";
						}
						else if($booking['booking_status']=='cancelled')
						{
							$booking['booking_status']="Cancelled";
						}
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
				$arrBookingData = $this->BookingModel->getBookingData($booking_id);
				
				$arrServiceDetails = $this->BookingModel->getServiceDetailsWOPricing($booking_id);
				
				$arrServiceDetailsPricing = $this->BookingModel->getServiceDetails($booking_id);
				
				$total = $admin_commision = $gst_percentage = $gst_amount = $coupon_amount = $coupon_percentage = 0;
				
				if(!empty($arrServiceDetailsPricing))
				{
					foreach($arrServiceDetailsPricing as $key=>$serviceDetails)
					{
						//print_r($serviceDetails);exit;
						$serviceDetails['SubTotal'] = $serviceDetails['option_amount'] * $serviceDetails['duration'];
						
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
					
					$arrServiceDetailsPricing['total'] = $total;
					$arrServiceDetailsPricing['admin_commision'] = $admin_commision;
					
					$arrServiceDetailsPricing['gst_percentage'] = $gst_percentage;
					$arrServiceDetailsPricing['gst_amount'] = $gst_amount;
					$arrServiceDetailsPricing['coupon_amount'] = $coupon_amount;
					$arrServiceDetailsPricing['coupon_percentage'] = $coupon_percentage;
					
					
					$arrServiceDetailsPricing['PayAmount'] = $total + $gst_amount + $admin_commision;
					
				}
				
                $data['responsecode'] = "200";
                $data['data'] = $arrBookingData;
                $data['ServiceDetails'] = $arrServiceDetails;
				$data['ServiceDetailsPricing'] = $arrServiceDetailsPricing;
                
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
		$service_id	= $this->input->post("service_id");
				
		if($token == TOKEN)
		{
            if($service_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
                $arrPromocode = $this->BookingModel->getPromocode($service_id);
               
                $data['responsecode'] = "200";
                $data['data'] = $arrPromocode;
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

    public function cardList_post()
	{
        error_reporting(E_ALL);
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
                $arrCard = $this->BookingModel->getAllCards($user_id);

				$userData=$this->BookingModel->getUserDetails($user_id);
				//print_r($userData);
				//echo $userData->stripe_customer_id;
                require_once('application/libraries/stripe_new/init.php');

				\Stripe\Stripe::setApiKey('sk_test_51NSHCBSDcd5hYqkEWmY8zKQZXuv4PNuoii4wbG3oPg01qaxdPmwFIkBVJ7bXEUqEhhV06bw0Qc88dkZpy7nyao4A00NYLKAYhR');
				
				$stripe = new \Stripe\StripeClient('sk_test_51Jz1PqLppcMzxtS6c05s7VALEpO5mN7F5nwvP7kQdNXEoMMF9xwz0JG3tzmk96sCrNA0MsoUOdNPQY6v7bbWz4DK00bCavTuAd');
				$Usercarddata=array();
				// print_r($stripe);
				// echo $userData->stripe_customer_id;
				try{
						$allCards3=$stripe->customers->allPaymentMethods(
							$userData->stripe_customer_id,
							['type' => 'card']
							);

						foreach($allCards3->data as $key=>$carddata)
						{
							$Usercarddata[$key]['id']=$carddata['id'];
							$Usercarddata[$key]['name']=$carddata['billing_details']['name'];
							$Usercarddata[$key]['last4']=$carddata['card']['last4'];
							if($carddata['card']['exp_month']<10){
							$Usercarddata[$key]['exp_month']="0".$carddata['card']['exp_month'];
							}
							else
							{
							$Usercarddata[$key]['exp_month']=$carddata['card']['exp_month'];
							}
							// $Usercarddata[$key]['exp_year']=$carddata['card']['exp_year'];
							$Usercarddata[$key]['exp_year']=substr($carddata['card']['exp_year'], strlen($carddata['card']['exp_year'])-2);
							$Usercarddata[$key]['card_type']=$carddata['card']['brand'];
						}
						// $data['stripedata']=$allCards3->data;
						$data['data']=$Usercarddata;
					}
					catch (Exception $e) 
					{
						$data['data']=array();
						//echo "error/".$e->getMessage();
					}


                $data['responsecode'] = "200";
                //$data['data'] = $arrCard;
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

    public function addcard_post()
	{
        error_reporting(E_ALL);
		$token 		= $this->input->post("token");
		$user_id	= $this->input->post("user_id");
		$card_type	= $this->input->post("card_type");
		$card_name	= $this->input->post("card_name");
		$card_no	= $this->input->post("card_no");
		$expiry_date	= $this->input->post("expiry_date");
		$expdt=explode("/", $expiry_date);
		$cvv_no	= $this->input->post("cvv");
		$is_new_card_save	= $this->input->post("is_new_card_save");
		$finalamt	= $this->input->post("booking_amount");
				
		if($token == TOKEN)
		{
            if($user_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
				$userData=$this->BookingModel->getUserDetails($user_id);
				$customer ="";

			    require_once('application/libraries/stripe-php/init.php');
				
				\Stripe\Stripe::setApiKey('sk_test_51Jz1PqLppcMzxtS6c05s7VALEpO5mN7F5nwvP7kQdNXEoMMF9xwz0JG3tzmk96sCrNA0MsoUOdNPQY6v7bbWz4DK00bCavTuAd');

							ini_set('display_errors', 1);
							ini_set('display_startup_errors', 1);
							error_reporting(E_ALL);
				if($userData->stripe_customer_id=="")
				{
					$customerData = \Stripe\Customer::create(array(
							'description' =>$userData->full_name,
							'name' => $userData->full_name,
							'phone' => $userData->mobile,
							'email' => $userData->email,
							"address" => [
										'line1' => $userData->address,
											'country' => 'Sweden'
										],
						));

					$addCustomerId=array(
									'stripe_customer_id'=>$customerData->id
							);
					$this->db->where('user_id',$userData->user_id);
					$this->db->update('loba_users',$addCustomerId);

					$customer =$customerData->id;
				}
				else
				{
					$customer =$userData->stripe_customer_id;
				}
				// echo $customer;
				try{
					$pm=\Stripe\PaymentMethod::create(array(
								'type' => 'card',
								'card' => [
								'number' => $card_no,
								'exp_month' => $expdt[0],
								'exp_year' => $expdt[1],
								'cvc' => $cvv_no,
							  ],
							));
							// print_r($pm);
					// if($is_new_card_save=='Yes')
					// {	
						if(isset($pm))
						{
							// echo $pm->id;
							$stripe = new \Stripe\StripeClient('sk_test_51Jz1PqLppcMzxtS6c05s7VALEpO5mN7F5nwvP7kQdNXEoMMF9xwz0JG3tzmk96sCrNA0MsoUOdNPQY6v7bbWz4DK00bCavTuAd');
								$attachData=$stripe->paymentMethods->attach(
								$pm->id,
								['customer' => $customer]
								);
						}
					// echo $card_id=$pm->id;
					$pay_method_id=$pm->id;
					$data['data']['payment_method_id'] =$pay_method_id;
						
					// }
					
					/*************************************************** */
					if($finalamt >=1)
					{
						$pay_output=$this->addcardPayemt($pay_method_id,$user_id,$finalamt);
						// print_r($pay_output);
						$paymentConfirm_id=$pay_output['data']['paymentConfirm_id'];
						$paymentConfirm_status=$pay_output['data']['paymentConfirm_status'];
					}
					else
					{
						$paymentConfirm_id="";
						$paymentConfirm_status="pending";
					}

					$data['data']['paymentConfirm_id'] =$paymentConfirm_id;
					$data['data']['paymentConfirm_status'] =$paymentConfirm_status;
					
					//if card not save- Delete Card
					$allCards3=$stripe->paymentMethods->all([
						'customer' => $customer,
						'type' => 'card',
						]);
					// print_r($allCards3);
					$delete_card_id=$allCards3->data[0]['id'];
					
					if($is_new_card_save=='No')
					{	
						$stripe->paymentMethods->detach(
							$delete_card_id,
							[]
						);
					}
						
					/**************************************************** */
					$data['responsecode'] = "200";
                	$data['responsemessage'] = "Card added successfully";
				}
				catch (Exception $e) 
				{
					// echo "error/".$e->getMessage();
					$data['responsecode'] = "402";
            	    $data['responsemessage'] = $e->getMessage();
				}
				
            //     $inputData=array(
			// 		'card_type' => $card_type,
			// 		'card_name' => $card_name,
			// 		'card_no' => $card_no,
			// 		'expiry_date' => $expiry_date,
			// 		'cvv_no' => $cvv,
			// 		'user_id' => $user_id,
			// 		'dateadded' => date('Y-m-d H:i:s')
			//    );
			//    $card_id = $this->Common_Model->insert_data('customer_cards',$inputData);
			//    $arrCard=$this->BookingModel->getCardDetails($user_id,$card_id);
            //     $data['responsecode'] = "200";
            //     $data['responsemessage'] = "Card added successfully";
            //     $data['data'] = $arrCard;
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

	function cardListData($user_id)
	{
        error_reporting(E_ALL);
           
			$userData=$this->BookingModel->getUserDetails($user_id);
			//print_r($userData);
			//echo $userData->stripe_customer_id;
			require_once('application/libraries/stripe_new/init.php');

			\Stripe\Stripe::setApiKey('sk_test_51NSHCBSDcd5hYqkEWmY8zKQZXuv4PNuoii4wbG3oPg01qaxdPmwFIkBVJ7bXEUqEhhV06bw0Qc88dkZpy7nyao4A00NYLKAYhR');
			
			$stripe1 = new \Stripe\StripeClient('sk_test_51Jz1PqLppcMzxtS6c05s7VALEpO5mN7F5nwvP7kQdNXEoMMF9xwz0JG3tzmk96sCrNA0MsoUOdNPQY6v7bbWz4DK00bCavTuAd');
			$Usercarddata=array();
			// echo $userData->stripe_customer_id;
			try{
					
					$allCards3=$stripe1->customers->allPaymentMethods(
						$userData->stripe_customer_id,
						['type' => 'card']
						);

					foreach($allCards3->data as $key=>$carddata)
					{
						$Usercarddata[$key]['id']=$carddata['id'];
						$Usercarddata[$key]['name']=$carddata['billing_details']['name'];
						$Usercarddata[$key]['last4']=$carddata['card']['last4'];
						if($carddata['card']['exp_month']<10){
						$Usercarddata[$key]['exp_month']="0".$carddata['card']['exp_month'];
						}
						else
						{
						$Usercarddata[$key]['exp_month']=$carddata['card']['exp_month'];
						}
						// $Usercarddata[$key]['exp_year']=$carddata['card']['exp_year'];
						$Usercarddata[$key]['exp_year']=substr($carddata['card']['exp_year'], strlen($carddata['card']['exp_year'])-2);
						$Usercarddata[$key]['card_type']=$carddata['card']['brand'];
					}
					// $data['stripedata']=$allCards3->data;
					print_r($Usercarddata);
					return $Usercarddata;
				}
				catch (Exception $e) 
				{
					// $data['data']=array();
					echo "error/".$e->getMessage();
				}
	}

	public function addcardPayemt($pay_method_id,$user_id,$finalamt)
	{
            if($user_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
				$userData=$this->BookingModel->getUserDetails($user_id);
				$customer ="";

			    require_once('application/libraries/stripe-php/init.php');
						\Stripe\Stripe::setApiKey('sk_test_51Jz1PqLppcMzxtS6c05s7VALEpO5mN7F5nwvP7kQdNXEoMMF9xwz0JG3tzmk96sCrNA0MsoUOdNPQY6v7bbWz4DK00bCavTuAd');

							ini_set('display_errors', 1);
							ini_set('display_startup_errors', 1);
							error_reporting(E_ALL);
				
					/*************************************************** */
					$payment_method_id=$pay_method_id;//$allCards->data[0]->id;
						$paymentData=\Stripe\PaymentIntent::create([
						  'payment_method_types' => ['card'],
						  'amount' => $finalamt*100,
						  'currency' => 'sek',
						  'customer' =>$userData->stripe_customer_id,
						  'payment_method' => $payment_method_id,
						  'setup_future_usage' => 'off_session',
						]);

						$stripe = new \Stripe\StripeClient('sk_test_51Jz1PqLppcMzxtS6c05s7VALEpO5mN7F5nwvP7kQdNXEoMMF9xwz0JG3tzmk96sCrNA0MsoUOdNPQY6v7bbWz4DK00bCavTuAd');
						$paymentConfirm=$stripe->paymentIntents->confirm(
						  $paymentData->id,
						  ['payment_method' => 'pm_card_visa']
						);

						$stripe->paymentMethods->detach(
							$payment_method_id,
							[]
						);

						// print_r($paymentConfirm);
						if(isset($paymentConfirm))
						{
							if($paymentConfirm->status=="succeeded")
							{
								// $data['data']['paymentConfirm'] =$paymentConfirm;
								
								$data['data']['paymentConfirm_id'] =$paymentConfirm->id;
								$data['data']['paymentConfirm_status'] =$paymentConfirm->status;
								$data['responsecode'] = "200";
								$data['responsemessage'] = "Your payment successfully";
							}
							else
							{
								// $data['data']['paymentConfirm'] =$paymentConfirm;
								
								$data['data']['paymentConfirm_id'] =$paymentConfirm->id;
								$data['data']['paymentConfirm_status'] =$paymentConfirm->status;
								$data['responsecode'] = "200";
								$data['responsemessage'] = "Your payment imcompleted";
							}
						}
						// echo "card_id-".$pay_method_id;
						// if($is_new_card_save=='No')
						// {	
						// 	$stripe = new \Stripe\StripeClient('sk_test_51Jz1PqLppcMzxtS6c05s7VALEpO5mN7F5nwvP7kQdNXEoMMF9xwz0JG3tzmk96sCrNA0MsoUOdNPQY6v7bbWz4DK00bCavTuAd');
						// 	$stripe->paymentMethods->detach(
						// 		$card_id,
						// 		[]
						// 	);
						// }
						
					/**************************************************** */
					// $data['responsecode'] = "200";
                	// $data['responsemessage'] = "Card added successfully";
						
            }
		
		return $data;
	}

	public function editcard_post()
	{
        error_reporting(E_ALL);
		$token 		= $this->input->post("token");
		$card_id	= $this->input->post("card_id");
		$user_id	= $this->input->post("user_id");
		$card_type	= $this->input->post("card_type");
		$card_name	= $this->input->post("card_name");
		$card_no	= $this->input->post("card_no");
		$expiry_date	= $this->input->post("expiry_date");
		$cvv	= $this->input->post("cvv");
				
		if($token == TOKEN)
		{
            if($user_id=="" || $card_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
               $inputData=array(
					'card_type' => $card_type,
					'card_name' => $card_name,
					'card_no' => $card_no,
					'expiry_date' => $expiry_date,
					'cvv_no' => $cvv,
					'user_id' => $user_id,
					'dateadded' => date('Y-m-d H:i:s'),
					'dateupdated' => date('Y-m-d H:i:s')
			   );
			   $this->Common_Model->update_data('customer_cards','card_id',$card_id,$inputData);
			   $arrCard=$this->BookingModel->getCardDetails($user_id,$card_id);
                $data['responsecode'] = "200";
                $data['responsemessage'] = "Card updated successfully";
                $data['data'] = $arrCard;
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
        ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$token 		        = $this->input->post("token");
		$user_id	        = $this->input->post("user_id");
		$service_id	        = $this->input->post("service_id");
		$pickup_address_id	= $this->input->post("pickup_address_id");
		$drop_address_id	= $this->input->post("drop_address_id");
		$booking_date	    = $this->input->post("booking_date");
		$time_slot	        = $this->input->post("time_slot");
		$no_of_hours	    = $this->input->post("no_of_hours");
		$mobility_aid	    = $this->input->post("mobility_aid");
		$doctor_id	        = $this->input->post("doctor_id");
		$nurse_id	        = $this->input->post("nurse_id");
		$promocode_id	    = $this->input->post("promocode_id");
		$coupon_code	    = $this->input->post("coupon_code");
		$booking_amount	    = $this->input->post("booking_amount");
		$discount_amount	= $this->input->post("discount_amount");
		$promocode_applied	= $this->input->post("promocode_applied");
		$payment_status	    = $this->input->post("payment_status");
		$booking_category_id= $this->input->post("booking_category_id");
		$paymentConfirm_id= $this->input->post("paymentConfirm_id");
		$paymentConfirm_status= $this->input->post("paymentConfirm_status");
		$lang= $this->input->post("lang");

		// Add Card code
		$card_type	= $this->input->post("card_type");
		$card_name	= $this->input->post("card_name");
		$card_no	= $this->input->post("card_no");
		$expiry_date	= $this->input->post("expiry_date");
		$expdt=explode("/", $expiry_date);
		$cvv_no	= $this->input->post("cvv");
		$is_new_card_save	= $this->input->post("is_new_card_save");


		if(!isset($booking_category_id))
		{
			$booking_category_id=0;
		}
		if(!isset($no_of_hours))
		{
			$booking_category_id=1;
		}
		$discount_amount=0;
		//$payment_type	    = $this->input->post("payment_type");
		//$payment_status='pending';

		$booking_date = str_replace('/','-',$booking_date);
		$booked_date = date("Y-m-d", strtotime($booking_date));

		if($service_id=='1' || $service_id=='2')
		{
			$doctor_id=0;
			$nurse_id=0;
			$bookingCategory=$this->BookingModel->getAllCategory($service_id);
			$booking_category_id=$bookingCategory[0]['booking_category_id'];
			
			$booking_amount=$bookingCategory[0]['category_amt_per_duration']*$no_of_hours;
			$order_place_amt=$bookingCategory[0]['category_amt_per_duration']*$no_of_hours;
			
		}
		else if($service_id=='3')
		{
			$nurse_id=0;
			$bookingCategory=$this->BookingModel->getCategoryDetails($booking_category_id);
			$booking_amount=$bookingCategory->category_amt_per_duration;
			$order_place_amt=$bookingCategory->category_amt_per_duration;
		}
		else if($service_id=='4')
		{
			$doctor_id=0;
			$bookingCategory=$this->BookingModel->getAllCategory($service_id);
			$booking_category_id=$bookingCategory[0]['booking_category_id'];
			$booking_amount=$bookingCategory[0]['category_amt_per_duration']*$no_of_hours;
			$order_place_amt=$bookingCategory[0]['category_amt_per_duration']*$no_of_hours;
		}
		// Get Promo Code
		if($promocode_id>0)
		{
			$promocode=$this->BookingModel->getPromocodeByid($promocode_id);
			//print_r($promocode);
			if($promocode->promocode_type=='Fixed Price')
			{
				$discount_amount=$promocode->promocode_discount;
				$coupon_code=$promocode->promocode_code;
				$order_place_amt=$booking_amount-$discount_amount;
			}
			else if($promocode->promocode_type=='Percentage')
			{
				$coupon_code=$promocode->promocode_code;
				$per_amount=($booking_amount*$promocode->promocode_discount/100);
				$discount_amount=$per_amount;
				$order_place_amt=$booking_amount-$per_amount;
			}
		}
		//echo $booking_amount;
		//print_r($_POST);
		
		//exit;
		if($token == TOKEN)
		{
            if($user_id=="" || $service_id=="" || $pickup_address_id=="" || $paymentConfirm_id=="" || $paymentConfirm_status=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
               $inputData=array(
					'user_id' => $user_id,
					'service_category_id' => $service_id,
					'booking_category_id' => $booking_category_id,
					'pickup_address_id' => $pickup_address_id,
					'drop_address_id' => $drop_address_id,
					'booking_date' => $booked_date,
					'time_slot' => $time_slot,
					'no_of_hourse' => $no_of_hours,
					'select_mobility_aid' => $mobility_aid,
					'booking_status' => 'waiting_for_accept',
					'doctor_id' => $doctor_id,
					'is_promo_code_applied' => $promocode_applied,
					'nurse_id' => $nurse_id,
					'date_added' => date('Y-m-d H:i:s')
			   );
			   $booking_id = $this->Common_Model->insert_data('service_booking',$inputData);
			   // Order Details add 
			   if($booking_id>0)
			   {
					$inputData=array(
						'user_id' => $user_id,
						'booking_id' => $booking_id,
						'offer_id' => $promocode_id,
						'coupon_code' => $coupon_code,
						'offer_amount' => $discount_amount,
						'total_order_amount' => $booking_amount,
						'order_place_amt' => $order_place_amt,
						'order_status' => $paymentConfirm_status,//$payment_status
						'booking_date' => $booked_date,
						'payment_type' => 'Card',
						'order_date' => date('Y-m-d H:i:s'),
						'dateadded' => date('Y-m-d H:i:s')
					);
					$intOrderId = $this->Common_Model->insert_data('orders',$inputData);

						$main_order_no="LOBA-ORD-".$intOrderId;
						$arrOrderData2 = array(
							"order_no"     	 => $main_order_no,
						);
						$this->db->where('order_id',$intOrderId);
						$this->db->update(TBPREFIX.'orders',$arrOrderData2);	
					
				/**************** Transaction add *************************** */
					// Transaction add
					$bookinginfo=$this->BookingModel->getBookingDetails($booking_id);
					$orderinfo=$this->BookingModel->getOrderDetails($booking_id);

					$total_amt=$orderinfo->total_order_amount;
					$finalamt=$orderinfo->order_place_amt;
					$discount=$orderinfo->offer_amount;
					$order_id=$orderinfo->order_id;
					//$payment_type = "stripe";

					//echo $userData->stripe_customer_id;
					$transaction_id = substr(hash('sha256', mt_rand() . microtime()), 0, 20);	
						if($paymentConfirm_status=="succeeded")
						{
							$arrOrderData = array(
								"user_id"     	 => $user_id,
								"order_id"     	 => $order_id,
								"transaction_id"=>$transaction_id,
								'stripe_pay_id'=>$paymentConfirm_id,
								// 'payment_response'=>$paymentConfirm,
								'offer_amount'=>$discount,
								'payment_type'=>"card",
								'total_order_amount'=>$total_amt,
								"payment_status"      =>$paymentConfirm_status,
								"is_refund"		=>"No",
								"dateadded"      => date('Y-m-d H:i:s'),
								"dateupdated"    => date('Y-m-d H:i:s'),
							);
							 $this->BookingModel->addOrderTransaction($arrOrderData);

								$arrOrderData3 = array(
									"order_status"     	 => $paymentConfirm_status,
								);
								$this->db->where('loba_orders.order_id',$order_id);
								$this->db->update('loba_orders',$arrOrderData3);

								$data['responsecode'] = "200";
								$data['responsemessage'] = "Your payment successfully";
								// redirect(base_url().'Home/paymentSuccessPage/'.base64_encode($intOrderId));
						}
						else
						{
							$arrOrderData = array(
								"user_id"     	 => $user_id,
								"order_id"     	 => $order_id,
								"transaction_id"=>$transaction_id,
								'stripe_pay_id'=>$paymentConfirm_id,
								// 'payment_response'=>$paymentConfirm,
								'offer_amount'=>round($discount,2),
								'payment_type'=>"card",
								'total_order_amount'=>round($total_amt,2),
								"payment_status"      =>"Incompleted",
								"is_refund"		=>"No",
								"dateadded"      => date('Y-m-d H:i:s'),
								"dateupdated"    => date('Y-m-d H:i:s'),
							);
							$intOrderId   = $this->BookingModel->addOrderTransaction($arrOrderData);
							
							$data['responsecode'] = "200";
							$data['responsemessage'] = "Your payment imcompleted";
						}
				/************************************************************ */
			   }

			   // Send Notification User
			   $title="LOBA Booking placed";
			   $Usermsg="Your booking ".$main_order_no." placed successfully";
			   $bookingUser=$this->BookingModel->getUserDetails($user_id);
			//    print_r($bookingUser);
				$arrGcmID="";
			    if(isset($bookinguser->user_fcm) && $bookinguser->user_fcm!="")
				{
					$arrGcmID=$bookinguser->user_fcm;
					$output=$this->Common_Model->SendNotification($title, $Usermsg, $arrGcmID);
				}
				
				$inputArr=array(
					'noti_user_type'=>'User',
					'noti_title'=>$title,
					'noti_message' => $Usermsg,
					'noti_user_id'=>$user_id,
					'noti_booking_id' =>$booking_id,
					'dateadded' => date('Y-m-d H:i:s')
				);
				$this->Common_Model->insert_data('notification',$inputArr);
				if(isset($bookingUser->email) && $bookingUser->email!=""){
					$usermail=$this->Common_Model->SendMail($bookingUser->email,$Usermsg,$title);
				}

				// SP / Doctor/ Nurse send Notifications
				if($service_id=='1' || $service_id=='2')
				{
					$title="LOBA New Booking placed";
					$msg="New booking placed ".$main_order_no;
					$spUsers=$this->BookingModel->getAllUser();
					$arrGcmID="";
					foreach($spUsers as $sp){
						// echo $sp['user_fcm'];
						if(isset($sp['user_fcm']) && $sp['user_fcm']!="")
						{
							$arrGcmID=$sp['user_fcm'];
							
						}
						$output=$this->Common_Model->SendNotification($title, $msg, $arrGcmID);
						$inputArr=array(
							'noti_user_type'=>'Service Provider',
							'noti_title'=>$title,
							'noti_message' => $msg,
							'noti_user_id'=>$sp['user_id'],
							'noti_booking_id' =>$booking_id,
							'dateadded' => date('Y-m-d H:i:s')
						);
						$this->Common_Model->insert_data('notification',$inputArr);
						if(isset($sp['email']) && $sp['email']!=""){
							
							$usermail=$this->Common_Model->SendMail($sp['email'],$msg,$title);
						}
						
					}
				}
				else if($service_id=='3')
				{
					$title="LOBA New Booking placed";
					$msg="New booking placed ".$main_order_no;
					$doctor=$this->BookingModel->getDoctorDetails($doctor_id);
					$sp=$this->BookingModel->getUserDetails($doctor->user_id);
					$arrGcmID="";
					if(isset($sp->user_fcm) && $sp->user_fcm!="")
					{
						$arrGcmID=$sp->user_fcm;
						$output=$this->Common_Model->SendNotification($title, $msg, $arrGcmID);
					}
					
					$inputArr=array(
						'noti_user_type'=>'Service Provider',
						'noti_title'=>$title,
						'noti_message' => $msg,
						'noti_user_id'=>$doctor->user_id,
						'noti_booking_id' =>$booking_id,
						'dateadded' => date('Y-m-d H:i:s')
					);
					$this->Common_Model->insert_data('notification',$inputArr);
					if(isset($sp->email) && $sp->email!=""){
						$usermail=$this->Common_Model->SendMail($sp->email,$msg,$title);
					}
				}
				else if($service_id=='4')
				{
					$title="LOBA New Booking placed";
					$msg="New booking placed ".$main_order_no;
					$nurse=$this->BookingModel->getNurseDetails($nurse_id);
					$sp=$this->BookingModel->getUserDetails($nurse->user_id);
					$arrGcmID="";
					if(isset($sp->user_fcm) && $sp->user_fcm!="")
					{
						$arrGcmID=$sp->user_fcm;
						$output=$this->Common_Model->SendNotification($title, $msg, $arrGcmID);
					}
					
					$inputArr=array(
						'noti_user_type'=>'Service Provider',
						'noti_title'=>$title,
						'noti_message' => $msg,
						'noti_user_id'=>$nurse->user_id,
						'noti_booking_id' =>$booking_id,
						'dateadded' => date('Y-m-d H:i:s')
					);
					$this->Common_Model->insert_data('notification',$inputArr);
					if(isset($sp->email) && $sp->email!=""){
						$usermail=$this->Common_Model->SendMail($sp->email,$msg,$title);
					}
				}

			  // $arrCard=$this->BookingModel->getCardDetails($user_id,$card_id);
                $data['responsecode'] = "200";
                $data['responsemessage'] = "Booking added successfully";
                $data['order_no'] = $main_order_no;
                $data['booking_id'] = $booking_id;
               // $data['data'] = $arrCard;
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

	public function bookingcancel_post()
	{
        error_reporting(E_ALL);
		$token 		= $this->input->post("token");
		$user_id	= $this->input->post("user_id");
		$booking_id	= $this->input->post("booking_id");
				
		if($token == TOKEN)
		{
            if($user_id=="" || $booking_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
               $inputData=array(
				"order_status"   	=> "cancel",
				"dateupdated"=>date('Y-m-d H:i:s')
			   );
			   $this->Common_Model->update_data('orders','booking_id',$booking_id,$inputData);

			   $inputData=array(
				"booking_status"   	=> "cancel",
				"date_updated"=>date('Y-m-d H:i:s')
			   );
			   $this->Common_Model->update_data('service_booking','booking_id',$booking_id,$inputData);

			   $arrCard=$this->BookingModel->getCardDetails($user_id,$card_id);
                $data['responsecode'] = "200";
                $data['responsemessage'] = "Booking cancel successfully";
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

	public function bookingInformation_post()
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$token 		= $this->input->post("token");
		$user_id	= $this->input->post("user_id");
		$service_id	= $this->input->post("service_id");
		$no_of_hours= $this->input->post("no_of_hours");
		$doctor_id	= $this->input->post("doctor_id");
		$nurse_id	= $this->input->post("nurse_id");
		$booking_category_id =$this->input->post("booking_category_id");
		if(!isset($booking_category_id) || $booking_category_id=="")	
		{
			$booking_category_id =0;
		}	
		// if(!isset($no_of_hours) || $no_of_hours=="")	
		// {
		// 	$no_of_hours =1;
		// }	
		if($token == TOKEN)
		{
            if($user_id=="" || $service_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
			   $bookinginfo=$this->BookingModel->getServiceDetails($service_id);
			   $userDetails=$this->BookingModel->getUserDetails($user_id);

			   if($service_id=='1' || $service_id=='2')
				{
					$doctor_id=0;
					$nurse_id=0;
					$bookingCategory=$this->BookingModel->getAllCategory($service_id);
					$booking_category_id=$bookingCategory[0]['booking_category_id'];
					$bookinginfo->amount=$bookingCategory[0]['category_amt_per_duration']*$no_of_hours;
					$bookinginfo->service_time=$no_of_hours." Hrs";
					$bookinginfo->category_name=$bookingCategory[0]['category_name'];
					$bookinginfo->category_duration=$bookingCategory[0]['category_duration']." Min";
					// $bookinginfo->service_time=$bookingCategory[0]['category_duration']." Min";
					$bookinginfo->Label1="Gender";
					$bookinginfo->Label2="Weight";
					$bookinginfo->Label3="Price per hour";

					$bookinginfo->full_name=$userDetails->full_name;
					$bookinginfo->profile_id=$userDetails->profile_id;
					$bookinginfo->gender=$userDetails->gender;
					$bookinginfo->weight=$userDetails->weight;
	 

					 $data['responsecode'] = "200";
					 $data['data'] = $bookinginfo;
					
				}
				else if($service_id=='3')
				{
					if($booking_category_id=="")
					{
						$data['responsemessage'] = 'Please provide Booking category Id ';
						$data['responsecode'] = "400"; //create an array
					}
					else if($doctor_id=="")
					{
						$data['responsemessage'] = 'Please provide Doctor Id ';
						$data['responsecode'] = "400"; //create an array
					}
					else
					{
						$doctor=$this->BookingModel->getDoctorDetails($doctor_id);
						$bookinginfo->sp_name=$doctor->doctor_full_name;
						$bookinginfo->sp_profile_id=$doctor->loba_id;
						$bookinginfo->sp_mobile=$doctor->mobile_no;
						$bookinginfo->sp_image=$doctor->doctor_image;

						$bookingCategory=$this->BookingModel->getCategoryDetails($booking_category_id);

						$bookinginfo->amount=$bookingCategory->category_amt_per_duration;
						$bookinginfo->service_time=$bookingCategory->category_duration." Min";
						$bookinginfo->category_name=$bookingCategory->category_name;
						$bookinginfo->category_duration=$bookingCategory->category_duration." Min";

						$bookinginfo->Label1="Appointment Date";
						$bookinginfo->Label2="Selected Time Slot";
						$bookinginfo->Label3="Consulting Fees";

						$bookinginfo->full_name=$userDetails->full_name;
						$bookinginfo->profile_id=$userDetails->profile_id;
						$bookinginfo->gender=$userDetails->gender;
						$bookinginfo->weight=$userDetails->weight;

						// Rating Percentage Code Start
							$rating_arr=array();
							$ratings=$this->BookingModel->getRatingPercentage($doctor->user_id);
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
							$rating_arr['average']=$average;
							$rating_arr['total']=$rowCount;

							$bookinginfo->rating_avg=$average;
							$bookinginfo->total_ratings=$rowCount;

						/************************************************ */
		 
						 $data['responsecode'] = "200";
						 $data['data'] = $bookinginfo;
					}
					
				}
				else if($service_id=='4')
				{
					if($nurse_id=="")
					{
						$data['responsemessage'] = 'Please provide Nurse Id ';
						$data['responsecode'] = "400"; //create an array
					}
					else
					{
						$nurse=$this->BookingModel->getNurseDetails($nurse_id);
						$bookinginfo->sp_name=$nurse->nurse_full_name;
						$bookinginfo->sp_profile_id=$nurse->loba_id;
						$bookinginfo->sp_mobile=$nurse->mobile_no;
						$bookinginfo->sp_image=$nurse->nurse_image;

						$bookingCategory=$this->BookingModel->getAllCategory($service_id);
						$booking_category_id=$bookingCategory[0]['booking_category_id'];

						$bookinginfo->amount=$bookingCategory[0]['category_amt_per_duration']*$no_of_hours;
						$bookinginfo->service_time=$no_of_hours." Hrs";
						// $bookinginfo->service_time=$bookingCategory[0]['category_duration']." Min";
						$bookinginfo->category_name=$bookingCategory[0]['category_name'];
						$bookinginfo->category_duration=$bookingCategory[0]['category_duration']." Min";

						$bookinginfo->Label1="Appointment Date";
						$bookinginfo->Label2="Selected Time Slot";
						$bookinginfo->Label3="Price Per Day";

						$bookinginfo->full_name=$userDetails->full_name;
						$bookinginfo->profile_id=$userDetails->profile_id;
						$bookinginfo->gender=$userDetails->gender;
						$bookinginfo->weight=$userDetails->weight;
		 
						// Rating Percentage Code Start
						$rating_arr=array();
						$ratings=$this->BookingModel->getRatingPercentage($nurse->user_id);
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
						$rating_arr['average']=$average;
						$rating_arr['total']=$rowCount;

						$bookinginfo->rating_avg=$average;
						$bookinginfo->total_ratings=$rowCount;

					/************************************************ */

						 $data['responsecode'] = "200";
						 $data['data'] = $bookinginfo;
					}
				}

					//    if(isset($doctor_id) && $doctor_id!="" && $service_id=='3')
					//    {
					// 		$doctorDetails=$this->BookingModel->getDoctorDetails($doctor_id);
					// 		$bookinginfo->doctor_charges=$doctorDetails->charges_per_visit;
					//    }
					//    if(isset($nurse_id) && $nurse_id!="" && $service_id=='4')
					//    {
					// 		$nurseDetails=$this->BookingModel->getDoctorDetails($nurse_id);
					// 		$bookinginfo->nurse_charges=$nurseDetails->charges_per_visit;
					//    }
			  
			  
              //  $data['user'] = $userDetails;
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

	public function mybookingList_post()
	{
		$token 		    = $this->input->post("token");
		$user_id 		= $this->input->post("user_id");
		$status 		= $this->input->post("status");
		
		if($token == TOKEN)
		{
			if($user_id=="" || $status=="")
			{
				$response_array['responsecode'] = "400";
				$response_array['responsemessage'] = 'Please Provide valid data';
			}
			else
			{
				$arrBookings=$this->BookingModel->getMyBookings($user_id,$status);
				
				//echo $this->db->last_query();
				foreach($arrBookings as $key=>$booking)
				{
					if(isset($booking['profile_pic']) && $booking['profile_pic']!="")
					{
						$booking['profile_pic']=base_url()."uploads/user/profile_photo/".$booking['profile_pic'];
					}
					if($booking['booking_date'] && $booking['booking_date']!="")
					{
						$booking['booking_date']=new DateTime($booking['booking_date']);
						$booking['booking_date']=$booking['booking_date']->format('M d,Y');
					}
					if($booking['booking_status']=='accepted')
					{
						$booking['booking_status']="Accepted";
					}
					else if($booking['booking_status']=='ongoing')
					{
						$booking['booking_status']="Ongoing";

						if($booking['booking_sub_status']=="start_journey")
						{
							$booking['booking_sub_status']="Start Journey";
						}
						else if($booking['booking_sub_status']=="reached")
						{
							$booking['booking_sub_status']="Reached";
						}
						else if($booking['booking_sub_status']=="start_service")
						{
							$booking['booking_sub_status']="Start Service";
						}
					}
					else if($booking['booking_status']=='completed')
					{
						$booking['booking_status']="Completed";
					}
					else if($booking['booking_status']=='cancel')
					{
						$booking['booking_status']="Cancelled";
					}
					
					$arrBookings[$key]=$booking;
				}
				
				$response_array['responsecode'] = "200";
				$response_array['data'] = $arrBookings;
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

	public function bookingDetails_post()
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$token 		= $this->input->post("token");
		$booking_id = $this->input->post("booking_id");
		$user_id 	= $this->input->post("user_id");
		
		if($token == TOKEN)
		{
			if($booking_id=="")
			{
				$response_array['responsecode'] = "400";
				$response_array['responsemessage'] = 'Please Provide valid data';
			}
			else
			{
				//print_r($user);
				$booking=$this->BookingModel->getBookingDetails($booking_id);
				
					//echo $user->service_type;
				$booking->service_charges=0;
				$booking->chat_service_provider_id=0;
				$booking->rating=0;

				//echo $this->db->last_query();
				$booking->raised_service_type="";
				if($booking->service_category_id=='1' || $booking->service_category_id=='2')
				{
					$bookingCategory=$this->BookingModel->getAllCategory($booking->service_category_id);
					$booking_category_id=$bookingCategory[0]['booking_category_id'];
					
					$category=$this->BookingModel->getCategoryDetails($booking_category_id);
					$booking->service_charges=$category->category_amt_per_duration;
					$booking->amount=$category->category_amt_per_duration;
					$booking->no_of_hourse=$booking->no_of_hourse." Hrs";
					$booking->category_name=$category->category_name;
					$booking->category_time=$category->category_duration." Min";

					$booking->raised_service_type='Service Provider';
					// Get Chat service provider id 
					$booking->chat_service_provider_id=$booking->service_provider_id;
					$user=$this->BookingModel->getUserDetails($booking->service_provider_id);
					if(!empty($user))
					{
						$booking->sp_name=$user->full_name;
						$booking->sp_mobile=$user->mobile;
						$booking->sp_profile_pic=$user->profile_pic;
						$booking->sp_profile_id=$user->profile_id;
						$booking->available_in_call=$user->available_in_call;
						$booking->notification_allowed=$user->notification_allowed;
					}

					// Rating
					$ratings=$this->BookingModel->getMyratings($booking->service_provider_id,1);
					//print_r($ratings);
					$star1=$star2=$star3=$star4=$star5=$rowCount=$tot_stars=$average=$percent=0;
					if(!empty($ratings))
					{
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
					}
					$booking->rating=$average;
				}
				else if($booking->service_category_id=='3')
				{
					$category=$this->BookingModel->getCategoryDetails($booking->booking_category_id);
					$booking->service_charges=$category->category_amt_per_duration;
					$booking->no_of_hourse=$category->category_duration." Min";
					$booking->category_name=$category->category_name;
					$booking->category_time=$category->category_duration." Min";


					$booking->raised_service_type='Doctor';
					// Get Chat service provider id 
					$doctor=$this->BookingModel->getDoctorDetails($booking->doctor_id);
					$booking->chat_service_provider_id=$doctor->user_id;

					$booking->doctor_name=$doctor->doctor_full_name;
					$booking->doctor_mobile=$doctor->mobile_no;
					$booking->doctor_profile_pic=$doctor->doctor_image;
					$booking->doctor_profile_id=$doctor->loba_id;
					$booking->doctor_specialization=$doctor->specialization;
					
					$userD=$this->BookingModel->getUserDetails($doctor->user_id);
					$booking->available_in_call=$userD->available_in_call;
					$booking->notification_allowed=$userD->notification_allowed;
					// Rating
					$ratingCount=$this->BookingModel->getMyratings($doctor->user_id,0);
					$booking->rating=$ratingCount;
				}
				else if($booking->service_category_id=='4')
				{
					$bookingCategory=$this->BookingModel->getAllCategory($booking->service_category_id);
					$booking_category_id=$bookingCategory[0]['booking_category_id'];
					// $booking_amount=$bookingCategory[0]['category_amt_per_duration']*$no_of_hours;
					// $order_place_amt=$bookingCategory[0]['category_amt_per_duration']*$no_of_hours;

					$category=$this->BookingModel->getCategoryDetails($booking_category_id);
					$booking->service_charges=$category->category_amt_per_duration;
					$booking->no_of_hourse=$booking->no_of_hourse." Hrs";
					$booking->category_name=$category->category_name;
					$booking->category_time=$category->category_duration." Min";

					
					$booking->raised_service_type='Nurse';
					// Get Chat service provider id 
					$nurse=$this->BookingModel->getNurseDetails($booking->nurse_id);
					$booking->chat_service_provider_id=$nurse->user_id;

					$userN=$this->BookingModel->getUserDetails($nurse->user_id);
					$booking->available_in_call=$userN->available_in_call;
					$booking->notification_allowed=$userN->notification_allowed;


					$booking->nurse_name=$nurse->nurse_full_name;
					$booking->nurse_mobile=$nurse->mobile_no;
					$booking->nurse_profile_pic=$nurse->nurse_image;
					$booking->nurse_profile_id=$nurse->loba_id;
					// Rating
					$ratingCount=$this->BookingModel->getMyratings($nurse->user_id,0);
					$booking->rating=$ratingCount;
				}

				if(isset($booking->profile_pic) && $booking->profile_pic!="")
				{
					$booking->profile_pic=base_url()."uploads/user/profile_photo/".$booking->profile_pic;
				}
				if(isset($booking->service_image) && $booking->service_image!="")
				{
					$booking->service_image=base_url()."uploads/service_img/".$booking->service_image;
				}
				if(isset($booking->service_app_image) && $booking->service_app_image!="")
				{
					$booking->service_app_image=base_url()."uploads/service_img/".$booking->service_app_image;
				}
				if($booking->booking_status=='waiting_for_accept')
				{
					$booking->booking_status="Waiting";
				}
				else if($booking->booking_status=='accepted')
				{
					$booking->booking_status="Accepted";
				}
				else if($booking->booking_status=='ongoing')
				{
					$booking->booking_status="Ongoing";

					if($booking->booking_sub_status=="start_journey")
					{
						$booking->booking_sub_status="Start Journey";
					}
					else if($booking->booking_sub_status=="reached")
					{
						$booking->booking_sub_status="Reached";
					}
					else if($booking->booking_sub_status=="start_service")
					{
						$booking->booking_sub_status="Start Service";
					}
				}
				else if($booking->booking_status=='completed')
				{
					$booking->booking_status="Completed";
				}
				else if($booking->booking_status=='rejected')
				{
					$booking->booking_status="Rejected";
				}

				if($booking->booking_date && $booking->booking_date!="")
				{
					$booking->booking_date=new DateTime($booking->booking_date);
					$booking->booking_date=$booking->booking_date->format('M d,Y');
				}

				$booking->pdf_link=base_url('Pdf_link/generatepdf/'.base64_encode($booking_id));
				// $booking->pdf_link=$this->Common_Model->generatepdf(base64_encode($booking_id));
				// $booking->pdf_link="";
				
				$response_array['responsecode'] = "200";
				$response_array['data'] = $booking;
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

	//code for service booking time slot
	public function getTimeSlot_post()
	{
		//date_default_timezone_set(DEFAULT_TIME_ZONE);	
		$token 		= $this->input->post("token");
		$booking_date=$_POST['booking_date'];
		$service_id=$_POST['service_id'];
		$doctor_id=$_POST['doctor_id'];
		$nurse_id=$_POST['nurse_id'];
		$time_slot_type=$_POST['time_slot_type'];

		if($token == TOKEN)
		{
			$date = $booking_date;
			$booking_date = date("Y-m-d", strtotime($date));
			// print_r($booking_date);
			// exit;
			$todays_date=date("Y-m-d");

			$current_time=date("H:i");
			$StartTime    ="";
			$EndTime      ="";
			$ReturnArray = array ();// Define output
			$duration="60";
			if($todays_date==$booking_date)
			{
				if($time_slot_type=='morning')
				{
					$StartTime    = strtotime ($booking_date." "."09:00"); //Get Timestamp
					$EndTime      = strtotime ($booking_date." "."11:00"); //Get Timestamp
				}
				else if($time_slot_type=='afternoon')
				{
					$StartTime    = strtotime ($booking_date." "."12:00"); //Get Timestamp
					$EndTime      = strtotime ($booking_date." "."16:00"); //Get Timestamp
				}
				else if($time_slot_type=='evening')
				{
					$StartTime    = strtotime ($booking_date." "."17:00"); //Get Timestamp
					$EndTime      = strtotime ($booking_date." "."19:00"); //Get Timestamp
				}
				else
				{
					$StartTime    = strtotime ($booking_date." "."09:00"); //Get Timestamp
					$EndTime      = strtotime ($booking_date." "."19:00"); //Get Timestamp
				}
				
			}
			else
			{
				if($time_slot_type=='morning')
				{
					$StartTime    = strtotime ($booking_date." "."09:00"); //Get Timestamp
					$EndTime      = strtotime ($booking_date." "."11:00"); //Get Timestamp
				}
				else if($time_slot_type=='afternoon')
				{
					$StartTime    = strtotime ($booking_date." "."12:00"); //Get Timestamp
					$EndTime      = strtotime ($booking_date." "."16:00"); //Get Timestamp
				}
				else if($time_slot_type=='evening')
				{
					$StartTime    = strtotime ($booking_date." "."17:00"); //Get Timestamp
					$EndTime      = strtotime ($booking_date." "."19:00"); //Get Timestamp
				}
				else
				{
					$StartTime    = strtotime ($booking_date." "."09:00"); //Get Timestamp
					$EndTime      = strtotime ($booking_date." "."19:00"); //Get Timestamp
				}
			}
			$AddMins  = $duration * 60;
			
			while ($StartTime <= $EndTime) //Run loop
			{
				$ReturnArray[] = date ("G:i", $StartTime);
				$StartTime += $AddMins; //Endtime check
			}

			$timslot_arr=array();
			$todaysdate=date("Y-m-d");
			$todaysTime=date("H:i");
			$flagechk=0;
			if(count($ReturnArray)>0)
			{
				$cnt=0;$timeslot="";
				foreach($ReturnArray as $key=>$row)
				{
					$cnt++;
					$todate= date('H:i', strtotime($row));
					if($booking_date > $todaysdate)
					{
						$chktime= date('h:i A', strtotime($todate));
						$bookingData=$this->BookingModel->getCheckTimeSlotBook($service_id,$doctor_id,$nurse_id,$chktime,$booking_date,0);
						//echo $this->db->last_query();
						// print_r()
						if($bookingData>0)
						{
							//$chktime="";
						}
						else
						{
							$timslot_arr[]=$chktime;
						}
					}
				}
			}
			//print_r($ReturnArray);
			$response_array['responsecode'] = "200";
			$response_array['data'] = $timslot_arr;
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

	public function getAllBookingCategory_post()
	{
		$token 		= $this->input->post("token");
		$service_id =$_POST['service_id'];

		if($token == TOKEN)
		{
			if($service_id=="")
			{
				$response_array['responsecode'] = "400";
				$response_array['responsemessage'] = 'Please provide valid data';
			}
			else
			{
				$categoryData=$this->BookingModel->getAllCategory($service_id);
				// foreach($categoryData as $key=>$category)
				// {
				// 	$category['category_name']=$category['category_name']." for ".$category['category_duration']." Minutes Price Should be - $".$category['category_amt_per_duration'];
				// 	$categoryData[$key]=$category;
				// }
				//print_r($ReturnArray);
				$response_array['responsecode'] = "200";
				$response_array['data'] = $categoryData;
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

	public function addReview_post()
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$token 			     = $this->input->post("token");
		$user_id 		     = $this->input->post("user_id");
		$service_provider_id = $this->input->post("service_provider_id");
		$review	             = $this->input->post("review");
		$rating	             = $this->input->post("rating");
		$booking_id	         = $this->input->post("booking_id");
		
		if($token == TOKEN)
		{
			if($user_id =="" || $service_provider_id=="" || $review==""  || $booking_id=="")
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
				$arrUserData = array(
					'booking_id' => $booking_id,
					'user_id' => $user_id,
					'service_provider_id' => $service_provider_id,
					'rating' => $rating,
					'review' => $review,
					'dateadded' => date('Y-m-d H:i:s')
					);

				$checkReview=$this->BookingModel->checkreviewExist($user_id,$service_provider_id,$booking_id);		
				if($checkReview>0)
				{
					$this->Common_Model->update_data('sp_reviews','booking_id',$booking_id,$arrUserData);
				}  
				else
				{
					$result   = $this->Common_Model->insert_data('sp_reviews',$arrUserData);
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
		$user_id 	    = $this->input->post("sp_id");
		
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
				$rating_arr['average']=$average;
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
					$rating_arr['star'.$i.'_per']=round($percent)."%";
				}

				$arrReviews=$this->BookingModel->getReviews($user_id);
				//echo $this->db->last_query();
				foreach($arrReviews as $key=>$review)
				{
					if(isset($review['profile_pic']) && $review['profile_pic']!="")
					{
						$review['profile_pic']=base_url()."uploads/user/profile_photo/".$review['profile_pic'];
					} 
					
					$arrReviews[$key]=$review;
				}
				
				$response_array['responsecode'] = "200";
				$response_array['Ratings'] = $rating_arr;
				$response_array['Reviews'] = $arrReviews;
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

	public function notificationList_post()
	{
		$token 		    = $this->input->post("token");
		$user_id 		= $this->input->post("user_id");
		
		if($token == TOKEN)
		{
			if($user_id=="")
			{
				$response_array['responsecode'] = "400";
				$response_array['responsemessage'] = 'Please Provide valid data';
			}
			else
			{
				$notification=$this->BookingModel->getnotifications($user_id);
				//echo $this->db->last_query();
				
				$response_array['responsecode'] = "200";
				$response_array['data'] = $notification;
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

	public function payment_post()
	{
        ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$token 		= $this->input->post("token");
		$user_id	= $this->input->post("user_id");
		$pay_method_id	= $this->input->post("pay_method_id");
		$booking_id	= $this->input->post("booking_id");
		$finalamt	= $this->input->post("amount");
				
		if($token == TOKEN)
		{
            if($user_id=="" || $pay_method_id=="" || $finalamt=="" || $finalamt=='0')
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
				$userData=$this->BookingModel->getUserDetails($user_id);
				// $bookinginfo=$this->BookingModel->getBookingDetails($booking_id);
				// $orderinfo=$this->BookingModel->getOrderDetails($booking_id);

				// $total_amt=$orderinfo->total_order_amount;
				// $finalamt=$orderinfo->order_place_amt;
				// $discount=$orderinfo->offer_amount;
				// $order_id=$orderinfo->order_id;
				// //$payment_type = "stripe";

				// //echo $userData->stripe_customer_id;
				// $transaction_id = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
				$payment_type = "stripe";
				
				$payment_status = "pending";

				if($payment_type == "stripe" && $finalamt >=1)
				{
					require_once('application/libraries/stripe-php/init.php');
						\Stripe\Stripe::setApiKey('sk_test_51Jz1PqLppcMzxtS6c05s7VALEpO5mN7F5nwvP7kQdNXEoMMF9xwz0JG3tzmk96sCrNA0MsoUOdNPQY6v7bbWz4DK00bCavTuAd');
							ini_set('display_errors', 1);
							ini_set('display_startup_errors', 1);
							error_reporting(E_ALL);
						 
                        $payment_method_id=$pay_method_id;//$allCards->data[0]->id;
						$paymentData=\Stripe\PaymentIntent::create([
						  'payment_method_types' => ['card'],
						  'amount' => $finalamt*100,
						  'currency' => 'sek',
						  'customer' =>$userData->stripe_customer_id,
						  'payment_method' => $payment_method_id,
						  'setup_future_usage' => 'off_session',
						]);

						$stripe = new \Stripe\StripeClient('sk_test_51Jz1PqLppcMzxtS6c05s7VALEpO5mN7F5nwvP7kQdNXEoMMF9xwz0JG3tzmk96sCrNA0MsoUOdNPQY6v7bbWz4DK00bCavTuAd');
						$paymentConfirm=$stripe->paymentIntents->confirm(
						  $paymentData->id,
						  ['payment_method' => 'pm_card_visa']
						);

						$stripe->paymentMethods->detach(
							$payment_method_id,
							[]
						);

						//print_r($paymentConfirm);
						if(isset($paymentConfirm))
						{
							if($paymentConfirm->status=="succeeded")
							{
								// $data['data']['paymentConfirm'] =$paymentConfirm;
								$data['data']['paymentConfirm_id'] =$paymentConfirm->id;
								$data['data']['paymentConfirm_status'] =$paymentConfirm->status;
								$data['responsecode'] = "200";
								$data['responsemessage'] = "Your payment successfully";
							}
							else
							{
								// $data['data']['paymentConfirm'] =$paymentConfirm;
								$data['data']['paymentConfirm_id'] =$paymentConfirm->id;
								$data['data']['paymentConfirm_status'] =$paymentConfirm->status;
								$data['responsecode'] = "200";
								$data['responsemessage'] = "Your payment imcompleted";
							}
							// if($paymentConfirm->status=="succeeded")
							// {
							// 	$arrOrderData = array(
							// 		"user_id"     	 => $user_id,
							// 		"order_id"     	 => $order_id,
							// 		"transaction_id"=>$transaction_id,
							// 		'stripe_pay_id'=>$paymentConfirm->id,
							// 		'payment_response'=>$paymentConfirm,
							// 		'offer_amount'=>$discount,
							// 		'payment_type'=>"card",
							// 		'total_order_amount'=>$total_amt,
							// 		"payment_status"      =>$paymentConfirm->status,
							// 		"is_refund"		=>"No",
							// 		"dateadded"      => date('Y-m-d H:i:s'),
							// 		"dateupdated"    => date('Y-m-d H:i:s'),
							// 	);
							// 	$intOrderId   = $this->BookingModel->addOrderTransaction($arrOrderData);

							// 	// $arrbooking = array(
							// 	// 		"booking_status"     	 => "waiting_for_accept",
							// 	// 		"booking_amount"     	 => $total_amt,
							// 	// 		"discount"     	 => $discount,
							// 	// 		"total_booking_amount"     	 => $finalamt,
							// 	// 	);
							// 	// 	$this->db->where('loba_service_booking.booking_id',$booking_id);
							// 	// 	$this->db->update('loba_service_booking',$arrbooking);

							// 		$arrOrderData3 = array(
							// 			"order_status"     	 => $paymentConfirm->status,
							// 		);
							// 		$this->db->where('loba_orders.order_id',$order_id);
							// 		$this->db->update('loba_orders',$arrOrderData3);

							// 		$data['responsecode'] = "200";
							// 		$data['responsemessage'] = "Your payment successfully";
							// 		// redirect(base_url().'Home/paymentSuccessPage/'.base64_encode($intOrderId));
							// }
							// else
							// {
							// 	$arrOrderData = array(
							// 		"user_id"     	 => $user_id,
							// 		"order_id"     	 => $intOrderId,
							// 		"transaction_id"=>$transaction_id,
							// 		'stripe_pay_id'=>$paymentConfirm->id,
							// 		'payment_response'=>$paymentConfirm,
							// 		'offer_amount'=>round($discount,2),
							// 		'payment_type'=>"card",
							// 		'total_order_amount'=>round($total_amt,2),
							// 		"payment_status"      =>"Incompleted",
							// 		"is_refund"		=>"No",
							// 		"dateadded"      => date('Y-m-d H:i:s'),
							// 		"dateupdated"    => date('Y-m-d H:i:s'),
							// 	);
							// 	$intOrderId   = $this->BookingModel->addOrderTransaction($arrOrderData);
								
							// 	$data['responsecode'] = "200";
							// 	$data['responsemessage'] = "Your payment imcompleted";
							// }
						}
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

	public function deleteCard_post()
	{
        ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$token 		= $this->input->post("token");
		$user_id	= $this->input->post("user_id");
		$pay_method_id	= $this->input->post("pay_method_id");
				
		if($token == TOKEN)
		{
            if($user_id=="" || $pay_method_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
				$userData=$this->BookingModel->getUserDetails($user_id);

				//echo $userData->stripe_customer_id;
				$payment_type = "stripe";
				
				$payment_status = "pending";

				if($payment_type == "stripe")
				{
					require_once('application/libraries/stripe-php/init.php');
					\Stripe\Stripe::setApiKey('sk_test_51Jz1PqLppcMzxtS6c05s7VALEpO5mN7F5nwvP7kQdNXEoMMF9xwz0JG3tzmk96sCrNA0MsoUOdNPQY6v7bbWz4DK00bCavTuAd');
							
					
                        $payment_method_id=$pay_method_id;//$allCards->data[0]->id;
						// $paymentData=\Stripe\PaymentIntent::create([
						//   'payment_method_types' => ['card'],
						//   'amount' => $finalamt*100,
						//   'currency' => 'sek',
						//   'customer' =>$userData->stripe_customer_id,
						//   'payment_method' => $payment_method_id,
						//   'setup_future_usage' => 'off_session',
						// ]);
						// $customer = \Stripe\Customer::retrieve($userData->stripe_customer_id);
						// $customer->sources->retrieve($payment_method_id)->delete();

						$stripe = new \Stripe\StripeClient('sk_test_51Jz1PqLppcMzxtS6c05s7VALEpO5mN7F5nwvP7kQdNXEoMMF9xwz0JG3tzmk96sCrNA0MsoUOdNPQY6v7bbWz4DK00bCavTuAd');
						// $paymentConfirm=$stripe->paymentIntents->confirm(
						//   $paymentData->id,
						//   ['payment_method' => 'pm_card_visa']
						// );

						$stripe->paymentMethods->detach(
							$payment_method_id,
							[]
						);
						
						$data['responsecode'] = "200";
						$data['responsemessage'] = "Card deleted successfully";
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

	public function reorderBooking_post()
	{
        error_reporting(E_ALL);
		$token 		        = $this->input->post("token");
		$user_id	        = $this->input->post("user_id");
		$oldbooking_id	    = $this->input->post("booking_id");
		$newbooking_date	    = $this->input->post("booking_date");
		$time_slot	        = $this->input->post("time_slot");

		// print_r($_POST);
		
		//exit;
		if($token == TOKEN)
		{
            if($user_id=="" || $oldbooking_id=="" || $newbooking_date=="" || $time_slot=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
				$booking= $this->BookingModel->getBookingDetails($oldbooking_id);
					// print_r($booking);
				$service_id	        = $booking->service_category_id;
				$pickup_address_id	= $booking->pickup_address_id;
				$drop_address_id	= $booking->drop_address_id;
				$no_of_hours	    = $booking->no_of_hourse;
				$mobility_aid	    = $booking->select_mobility_aid;
				$doctor_id	        = $booking->doctor_id;
				$nurse_id	        = $booking->nurse_id;
				$promocode_id	    = 0;
				$coupon_code	    = '';
				$booking_amount	    = 0;
				$discount_amount	= 0;
				$promocode_applied	= 'No';
				$payment_status	    = 'pending';
				$booking_category_id= $booking->booking_category_id;
				$booking_status     = 'waiting_for_accept';

				if(!isset($booking_category_id))
				{
					$booking_category_id=0;
				}
				if(!isset($no_of_hours))
				{
					$no_of_hours=1;
				}
				$discount_amount=0;
				//$payment_type	    = $this->input->post("payment_type");
				//$payment_status='pending';

				$newbooking_date = str_replace('/','-',$newbooking_date);
				$booked_date = date("Y-m-d", strtotime($newbooking_date));

				if($service_id=='1' || $service_id=='2')
				{
					$doctor_id=0;
					$nurse_id=0;
					$bookingCategory=$this->BookingModel->getAllCategory($service_id);
					$booking_category_id=$bookingCategory[0]['booking_category_id'];
					$booking_amount=$bookingCategory[0]['category_amt_per_duration']*$no_of_hours;
					$order_place_amt=$bookingCategory[0]['category_amt_per_duration']*$no_of_hours;
					
				}
				else if($service_id=='3')
				{
					$nurse_id=0;
					$bookingCategory=$this->BookingModel->getCategoryDetails($booking_category_id);
					$booking_amount=$bookingCategory->category_amt_per_duration;
					$order_place_amt=$bookingCategory->category_amt_per_duration;
				}
				else if($service_id=='4')
				{
					$doctor_id=0;
					$bookingCategory=$this->BookingModel->getAllCategory($service_id);
					$booking_category_id=$bookingCategory[0]['booking_category_id'];
					$booking_amount=$bookingCategory[0]['category_amt_per_duration']*$no_of_hours;
					$order_place_amt=$bookingCategory[0]['category_amt_per_duration']*$no_of_hours;
				}
				// Get Promo Code
				if($promocode_id>0)
				{
					$promocode=$this->BookingModel->getPromocodeByid($promocode_id);
					//print_r($promocode);
					if($promocode->promocode_type=='Fixed Price')
					{
						$discount_amount=$promocode->promocode_discount;
						$coupon_code=$promocode->promocode_code;
						$order_place_amt=$booking_amount-$discount_amount;
					}
					else if($promocode->promocode_type=='Percentage')
					{
						$coupon_code=$promocode->promocode_code;
						$per_amount=($booking_amount*$promocode->promocode_discount/100);
						$discount_amount=$per_amount;
						$order_place_amt=$booking_amount-$per_amount;
					}
				}



               $inputData=array(
					'user_id' => $user_id,
					'service_category_id' => $service_id,
					'booking_category_id' => $booking_category_id,
					'pickup_address_id' => $pickup_address_id,
					'drop_address_id' => $drop_address_id,
					'booking_date' => $booked_date,
					'time_slot' => $time_slot,
					'no_of_hourse' => $no_of_hours,
					'select_mobility_aid' => $mobility_aid,
					'booking_status' => 'waiting_for_accept',
					'doctor_id' => $doctor_id,
					'is_promo_code_applied' => $promocode_applied,
					'nurse_id' => $nurse_id,
					'date_added' => date('Y-m-d H:i:s')
			   );
			   $booking_id = $this->Common_Model->insert_data('service_booking',$inputData);
			   // Order Details add 
			   if($booking_id>0)
			   {
					$inputData=array(
						'user_id' => $user_id,
						'booking_id' => $booking_id,
						'offer_id' => $promocode_id,
						'coupon_code' => $coupon_code,
						'offer_amount' => $discount_amount,
						'total_order_amount' => $booking_amount,
						'order_place_amt' => $order_place_amt,
						'order_status' => $payment_status,
						'booking_date' => $booked_date,
						'payment_type' => 'Card',
						'order_date' => date('Y-m-d H:i:s'),
						'dateadded' => date('Y-m-d H:i:s')
				);
				$intOrderId = $this->Common_Model->insert_data('orders',$inputData);

					$main_order_no="LOBA-ORD-".$intOrderId;
						$arrOrderData2 = array(
							"order_no"     	 => $main_order_no,
						);
						$this->db->where('order_id',$intOrderId);
						$this->db->update(TBPREFIX.'orders',$arrOrderData2);				
			   }

			   // Send Notification User
			   $title="LOBA Booking placed";
			   $Usermsg="Your booking ".$main_order_no." placed successfully";
			   $bookingUser=$this->BookingModel->getUserDetails($user_id);
			   $arrGcmID="";
			   if(isset($bookinguser->user_fcm) && $bookinguser->user_fcm!="")
				{
					$arrGcmID=$bookinguser->user_fcm;
				}
				$output=$this->Common_Model->SendNotification($title, $Usermsg, $arrGcmID);

				// SP / Doctor/ Nurse send Notifications
				if($service_id=='1' || $service_id=='2')
				{
					$title="LOBA New Booking placed";
					$msg="New booking placed ".$main_order_no;
					$spUsers=$this->BookingModel->getAllUser($user_id);
					foreach($spUsers as $sp)
					if(isset($sp->user_fcm) && $sp->user_fcm!="")
					{
						$arrGcmID=$sp->user_fcm;
					}
					$output=$this->Common_Model->SendNotification($title, $msg, $arrGcmID);
				}
				else if($service_id=='3')
				{
					$title="LOBA New Booking placed";
					$msg="New booking placed ".$main_order_no;
					$doctor=$this->BookingModel->getDoctorDetails($doctor_id);
					$sp=$this->BookingModel->getUserDetails($doctor->user_id);
					if(isset($sp->user_fcm) && $sp->user_fcm!="")
					{
						$arrGcmID=$sp->user_fcm;
					}
					$output=$this->Common_Model->SendNotification($title, $msg, $arrGcmID);
				}
				else if($service_id=='4')
				{
					$title="LOBA New Booking placed";
					$msg="New booking placed ".$main_order_no;
					$nurse=$this->BookingModel->getNurseDetails($nurse_id);
					$sp=$this->BookingModel->getUserDetails($nurse->user_id);
					if(isset($sp->user_fcm) && $sp->user_fcm!="")
					{
						$arrGcmID=$sp->user_fcm;
					}
					$output=$this->Common_Model->SendNotification($title, $msg, $arrGcmID);
				}

			  // $arrCard=$this->BookingModel->getCardDetails($user_id,$card_id);
                $data['responsecode'] = "200";
                $data['responsemessage'] = "Booking added successfully";
                $data['order_no'] = $main_order_no;
                $data['booking_id'] = $booking_id;
               // $data['data'] = $arrCard;
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
						'booking_sub_status' => $substatus,
						'service_provider_id'=>5
					);
					$this->Common_Model->update_data('booking','booking_id',$booking_id,$inputData);
					// echo $this->db->last_query();
					$response_array['responsecode'] = "200";
					$response_array['responsemessage'] = 'Please Provide valid data';
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
