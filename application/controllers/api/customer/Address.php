<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Address extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('ApiModels/customer/AddressModel');
		$this->load->model('Common_Model');
	}
	
	public function addressList_post()
	{
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		$type		    = $this->input->post("type");
		$language	    = $this->input->post("lang");
		if($language=='zh')
		{ 
			$lang="chinese"; 
		}
		else
		{
			$lang="english";
		}
				
		if($token == TOKEN)
		{
            if($user_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
                $Arraddress = $this->AddressModel->getAllAddress($user_id,$lang);
                foreach($Arraddress as $key=>$address)
                {
                    $address['selected']= false;
                    if($type=='Pickup')
                    {
                        if($address['is_seleted']=='1')
                        {
                            $address['selected']= true;
                        }
                    }
                    else if($type=='Drop')
                    {
                        if($address['is_selected_drop']=='1')
                        {
                            $address['selected']= true;
                        }
                    }
                    $Arraddress[$key]=$address;
                }
                $data['responsecode'] = "200";
                $data['data'] = $Arraddress;
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

    public function addressDetails_post()
	{
        ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		$address_id		= $this->input->post("address_id");
				
		if($token == TOKEN)
		{
            if($user_id=="" || $address_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            {
                $address = $this->AddressModel->getAddressDetails($user_id,$address_id);

					$addressarr=explode(",",$address->address1);
					// print_r($addressarr);
					$address->flat_no=$addressarr[0];
					$address->street=$addressarr[1];
					$address->address=$addressarr[2];

                $data['responsecode'] = "200";
                $data['data'] = $address;
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
		$location_type	= $this->input->post("location_type");
		$type		    = $this->input->post("type");
		$flat_no	    = $this->input->post("flat_no");
		$street	        = $this->input->post("street");
		$address	    = $this->input->post("address");
		$city	        = $this->input->post("city");
		$latitude	    = $this->input->post("latitude");
		$longitude	    = $this->input->post("longitude");
		$language	    = $this->input->post("lang");
		if(isset($language) && $language=='zh')
		{ 
			$lang="chinese"; 
			$state="香港"; 
		}
		else
		{
			$lang="english";
			$state="Hong Kong"; 
		}
		if(!isset($city)) { $city='1'; }
        $addressarr=$flat_no.", ".$street.", ".$address;
		if($token == TOKEN)
		{
			if($type=="" || $location_type=="" || $user_id == "" || $flat_no == "" || $street == "" || $address == "" || $latitude == "" || $longitude == "") 
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
                $is_selected="is_seleted";
                if($location_type=='Pickup')
                {
                    $is_selected="is_seleted";
                }
                else if($location_type=='Drop')
                {
                    $is_selected="is_selected_drop";
                }
                
                $arrUserData = array(
                        'user_id' => $user_id,
                        'address_type'=>$type,
                        'address_lat'=>$latitude,
                        'address_lng'=>$longitude,
                        'address1'=>$addressarr,
                        'city'=>$city,
                        'state'=>$state,
                        'address_language'=>$lang,
                         $is_selected=>1,
                        'adress_status'=>'Active',
                        "dateadded"=>date('Y-m-d H:i:s'),
					    "dateupdated"=>date('Y-m-d H:i:s'),
                        );
                                
                $address_id   = $this->Common_Model->insert_data('adresses',$arrUserData);
                //echo $this->db->last_query();
                
                //$data['data'] = $arrData;
                $data['responsemessage'] = 'Address added successfully';
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

    public function editAddress_post()
	{
		$token 		    = $this->input->post("token");
		$address_id	    = $this->input->post("address_id");
		$user_id	    = $this->input->post("user_id");
		$location_type	= $this->input->post("location_type");
		$type		    = $this->input->post("type");
		$flat_no	    = $this->input->post("flat_no");
		$street	        = $this->input->post("street");
		$address	    = $this->input->post("address");
		$city	        = $this->input->post("city");
		$latitude	    = $this->input->post("latitude");
		$longitude	    = $this->input->post("longitude");
		$language	    = $this->input->post("lang");
		if($language=='zh')
		{ 
			$lang="chinese"; 
			$state="香港"; 
		}
		else
		{
			$lang="english";
			$state="Hong Kong"; 
		}
		if(!isset($city)) { $city='1'; }
        $addressarr=$flat_no." ".$street." ".$address;
		if($token == TOKEN)
		{
			if($type=="" || $location_type=="" || $user_id == "" || $flat_no == "" || $street == "" || $address == "" || $latitude == "" || $longitude == "") 
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
                $is_selected="is_seleted";
                if($location_type=='Pickup')
                {
                    $is_selected="is_seleted";
                    $this->AddressModel->isselected_pickup_update($user_id);
                }
                else if($location_type=='Drop')
                {
                    $is_selected="is_selected_drop";
                    $this->AddressModel->isselected_drop_update($user_id);
                }
                
                $arrUserData = array(
                        'user_id' => $user_id,
                        'address_type'=>$type,
                        'address_lat'=>$latitude,
                        'address_lng'=>$longitude,
                        'address1'=>$addressarr,
                        'city'=>$city,
                        'state'=>$state,
                         $is_selected=>1,
                        'adress_status'=>'Active',
                        "dateadded"=>date('Y-m-d H:i:s'),
					    "dateupdated"=>date('Y-m-d H:i:s'),
                        );
                                
               $this->Common_Model->update_data('adresses','address_id',$address_id,$arrUserData);
                //echo $this->db->last_query();
                
                //$data['data'] = $arrData;
                $data['responsemessage'] = 'Address updated successfully';
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

    public function deleteAddress_post()
	{
		$token 		    = $this->input->post("token");
		$address_id	    = $this->input->post("address_id");
		$user_id	    = $this->input->post("user_id");

        $addressarr=$flat_no." ".$street." ".$address;
		if($token == TOKEN)
		{
			if($user_id == "" || $address_id == "" ) 
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
               $this->Common_Model->delete_data('adresses','address_id',$address_id);
                //echo $this->db->last_query();
                $data['responsemessage'] = 'Address deleted successfully';
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

	public function cityList_post()
	{
		$token 		    = $this->input->post("token");

		if($token == TOKEN)
		{
			
			$city=$this->AddressModel->getAllCity();
			$data['data'] = $city;
			$data['responsemessage'] = 'Address deleted successfully';
			$data['responsecode'] = "200";
			
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
}
