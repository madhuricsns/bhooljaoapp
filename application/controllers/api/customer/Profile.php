<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Profile extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('ApiModels/customer/CustomerModel');
		$this->load->model('Common_Model');
	}
	
	public function signup_post()
	{
		$token 			= $this->input->post("token");
		$fullname		= $this->input->post("full_name");
		$mobile_number	= $this->input->post("mobile");
		$email_address	= $this->input->post("email");
		$password	= $this->input->post("password");
		
		if($token == TOKEN)
		{
			if($fullname=="" || $email_address == "" || $mobile_number == "" || $password == "") //$password == "" || $password!=$cpassword
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
				$userExists = $this->CustomerModel->checkUserMobile($mobile_number,$email_address);
				if($userExists>0)
				{	
					$data['responsemessage'] = 'User already exists';
					$data['responsecode'] = "402";
				}
				else
				{
					$profile_id="BJC".$this->Common_Model->randomCode();
					// Random Number for OTP  
					$otp_code = $this->Common_Model->otp();
					if($mobile_number=='8087877835' || $mobile_number=='8668766511')
					{
						$otp_code='1234';
					}
					
					$arrUserData = array(
							'profile_id' => $profile_id,
							'full_name'=>$fullname,
							'email'=>$email_address,
							'password'=>md5($password),
							'mobile'=>$mobile_number,
							'otp' => $otp_code,
							'user_type'=>'Customer',
							'status'=>'Active',
							'dateadded' => date('Y-m-d H:i:s')
							);
								  
					$user_id   = $this->Common_Model->insert_data('users',$arrUserData);
					//echo $this->db->last_query();
					$arrData = $this->CustomerModel->getUserDetails($user_id);
					// Send SMS
					$strMessage=urlencode("$otp_code is your OTP. Please do not share it with anybody. Panan Saathi Ventures");
					$output=$this->Common_Model->SendSms($strMessage, $mobile_number);	

					/**** Send Email Code Start *********************** */
					//Sign up mail
						$data['fullname']=$fullname;
						$title="Signup successfully";
						$mailMsg = $this->Common_Model->email_content('Signup',$data);
						$this->Common_Model->SendMail($email_address,$mailMsg,$title);
					
					/**********Email Code End ***************** */


					
					$data['data'] = $arrData;
					$data['responsemessage'] = 'OTP send successfully';
					$data['responsecode'] = "200";
				}
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

	public function editprofile_post()
	{
		$token 			= $this->input->post("token");
		$user_id 		= $this->input->post("user_id");
		$fullname		= $this->input->post("full_name");
		$mobile_number	= $this->input->post("mobile");
		$email_address	= $this->input->post("email");
		
		if($token == TOKEN)
		{
			if($user_id =="" || $fullname=="" || $mobile_number==""  || $email_address=="")
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
				$arrUserData = array(
					'full_name' => $fullname,
					'mobile' => $mobile_number,
					'email' => $email_address,
					'dateupdated' => date('Y-m-d H:i:s')
					);
						  
				$result   = $this->Common_Model->update_data('users','user_id',$user_id,$arrUserData);
				
				$arrData = $this->CustomerModel->getUserDetails($user_id);
				
				$data['data'] = $arrData;
				$data['responsemessage'] = 'User updated successfully';
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

	public function updateProfilephoto_post()
	{
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		
		if($token == TOKEN)
		{
			if($user_id=="" || $_FILES['profile_photo']['name']=="") 
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
				 //Image Upload Code 
				 if(count($_FILES) > 0) 
				 {
					 $ImageName1 = "profile_photo";
					 $target_dir = "uploads/user_profile/";
					 $profile_pic= $this->Common_Model->ImageUpload($ImageName1,$target_dir);
				 }
				$arrUserData = array('profile_pic' => $profile_pic);
								
				$this->Common_Model->update_data('users','user_id',$user_id,$arrUserData);
				$arrData = $this->CustomerModel->getUserDetails($user_id);
				
				$data['data'] = $arrData;
				$data['responsemessage'] = 'Profile photo updated successfully';
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
	
	public function userDetails_post()
	{
		$token 			= $this->input->post("token");
		$user_id			= $this->input->post("user_id");
		
		if($token == TOKEN)
		{
            if($user_id=="") 
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
				// $updatedata = array('mobile_code'=>'852','alt_mobile_code'=>'852');
					// $this->db->where('mobile_code','');
			  	// 	$this->db->update('loba_users',$updatedata);

				$arrData = $this->CustomerModel->getUserDetails($user_id);

                $data['data'] = $arrData;
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

	public function zoneList_post()
	{
		$token 			= $this->input->post("token");
		// $user_id		= $this->input->post("user_id");
		
		if($token == TOKEN)
		{
			$arrData = $this->CustomerModel->getAllZones(1);
			$data['data'] = $arrData;
			$data['responsecode'] = "200";		
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
	
	public function sitepages_post()
	{
		$token 			= $this->input->post("token");
		$pagename		= $this->input->post("pagename");
				
		if($token == TOKEN)
		{
			$sitePage = $this->CustomerModel->getPageContent($pagename);
			
			$data['data'] = $sitePage;
			$data['responsecode'] = "200";
			$response_array=json_encode($data);						
		}
		else
		{
			$data['responsecode'] = "201";
			$response_array['responsemessage'] = 'Token did not match';
		}	
		print_r($response_array);
	}

	public function faqList_post()
	{
		$token 			= $this->input->post("token");
		$type		    = 'Customer';
				
		if($token == TOKEN)
		{
			$sitePage = $this->CustomerModel->getAllfaqList($type);
			// foreach($sitePage as $key=>$page)
			// {
			// 	$page['checked']='false';
			// 	$sitePage[$key]=$page;
			// }
			
			$data['data'] = $sitePage;
			$data['responsecode'] = "200";
			$response_array=json_encode($data);						
		}
		else
		{
			$data['responsecode'] = "201";
			$response_array['responsemessage'] = 'Token did not match';
		}	
		print_r($response_array);
	}

	public function contactus_post()
	{
		$token 			= $this->input->post("token");
				
		if($token == TOKEN)
		{
			$ContactUs = $this->CustomerModel->getContactUs();
			
			$data['data'] = $ContactUs;
			$data['responsecode'] = "200";
			$response_array=json_encode($data);						
		}
		else
		{
			$data['responsecode'] = "201";
			$response_array['responsemessage'] = 'Token did not match';
		}	
		print_r($response_array);
	}


	public function serviceproviderDetails_post()
	{
		$token 			= $this->input->post("token");
		$user_id			= $this->input->post("user_id");
		$service_provider_id	= $this->input->post("service_provider_id");
		$userLat 		= $this->input->post("userLat");
		$userLong 		= $this->input->post("userLong");
		
		
		if($token == TOKEN)
		{
            if($user_id=="" || $service_provider_id=="") 
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
				// $input=array('service_provider_id'=>'5','description'=>'car wash business');
				// $this->Common_Model->insert_data('sp_whatwedo',$input);
				// echo $this->db->last_query();
				// $input=array('service_provider_id'=>'5','description'=>'car wash business');
				// $this->Common_Model->insert_data('sp_whatwedo',$input);

				$arrData = $this->CustomerModel->getServiceProviderDetails($service_provider_id,$userLat,$userLong);
				$arrWhatWeDo = $this->CustomerModel->getSPWhatWeDo($service_provider_id);
				$arrWhatWeDoData =array();
				foreach($arrWhatWeDo as $whatwedo)
				{
					$arrWhatWeDoData[]=$whatwedo['description'];
				}
				// print_r($arrWhatWeDo);exit;
				// If Favourite
				$isFavourite = $this->CustomerModel->checkIsFavourite($user_id,$service_provider_id);
				$isverified = $this->CustomerModel->checkIsVerified($service_provider_id);
				$favourite=false;
				$verified=false;
				if(!empty($isFavourite))
				{
					if($isFavourite->is_favourite=='Yes')
					{
						$favourite=true;
					}
				}
				$arrData->isFavourite=$favourite;
				if(!empty($isverified))
				{
					if($isverified->is_verified=='Yes')
					{
						$verified=true;
					}
				}
				$arrData->isVerified=$verified;

				$category_id=$arrData->category_id;
				$category = $this->CustomerModel->getCategory($arrData->category_id);
				$arrData->category_name=$category->category_name;
				$arrData->about=$category->category_description;
				$arrData->year=$arrData->experience;
				if($arrData->distance=='' || $arrData->distance==null)
				{
					$arrData->distance="0";
				}
				else
				{
					$arrData->distance=number_format($arrData->distance,2);
				}
			
				//  Review
				$arrAllReviews=$this->CustomerModel->getAllReviews($service_provider_id);
				foreach($arrAllReviews as $k=>$r)
				{
					if(isset($r['profile_pic']) && $r['profile_pic']!="")
					{
						$r['profile_pic']=base_url()."uploads/user_profile/".$r['profile_pic'];
					} 
					$arrAllReviews[$k]=$r;
				}
				$arrReviews=$this->CustomerModel->getReviews($service_provider_id);
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
				// echo $tot_stars."<br>";
				if($tot_stars>0)
				{
					$average = $tot_stars/$reviewCount;
				}
				//Total Review & Rating Count
				$arrData->rating_avg=number_format($average,1);
				$arrData->total_rating=$reviewCount;

				// Subcategory available
				$subcategoriesCheck = $this->CustomerModel->getAllSubCategories(0,$category_id);
				// print_r($subcategoriesCheck);
				$arrData->isSubcategoryAvailable=false;
				if($subcategoriesCheck>0)
				{
					$arrData->isSubcategoryAvailable=true;
				}

				$arrData->whatwedo=$arrWhatWeDoData;

				
				// // print_r($category);
				$main_category="";
				if($category->category_parent_id==0)
				{
					$subcategory=$this->CustomerModel->getSubCategory($arrData->category_id);
					// print_r($subcategory);
					if(!empty($subcategory))
					{
						foreach($subcategory as $subcat)
						{
							$arrData->category_id=$subcat['category_id'];
						}
					}
				}
				// echo $arrData->category_id;
				$service = $this->CustomerModel->getAllServiceByCategoryId($arrData->category_id);
				$service_id=0;
				if(!empty($service))
				{
					$service->service_id=0;
				}
				// print_r($service);
				$images=array();
				$services_images = $this->CustomerModel->getAllServiceImages($service_id);
				foreach($services_images as $image)
				{
					$images[]=$image['service_image'];
				}

				// SP Photos
				$spimages=array();
				$sp_photos = $this->CustomerModel->getPhotos($service_provider_id);
				// print_r($sp_photos);
				if(!empty($sp_photos))
				{
					foreach($sp_photos as $spphoto)
					{
						$spimages[]=$spphoto['photo'];
					}
				}
				
				// Banners
				$banners = $this->CustomerModel->getAllBanners();
				foreach($banners as $key=>$banner)
				{
					if($banner['banner_url']=="")
					{
						$banner['banner_url']="";
					}
					if($banner['banner_start_date']=="")
					{
						$banner['banner_start_date']="";
					}
					if($banner['banner_end_date']=="")
					{
						$banner['banner_end_date']="";
					}

					$banners[$key]=$banner;
				}

				//Similar Service Providers
				$arrServiceGivers = $this->CustomerModel->getNearByServiceGivers(3,$userLat,$userLong,$category_id,$service_provider_id);
				foreach($arrServiceGivers as $key=>$sp)
				{
					//Rating
					$arrReviewsData=$this->CustomerModel->getReviews($sp['service_provider_id']);
					//echo $this->db->last_query();
					$star1=$star2=$star3=$star4=$star5=$rowCount=$average=$percent=0;
					foreach($arrReviewsData as $k=>$review)
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
						$arrReviewsData[$k]=$review;
					}
					$tot_stars = $star1 + $star2 + $star3 + $star4 + $star5;
					$reviewCount=count($arrReviewsData);
					if($tot_stars>0)
					{
						$average = $tot_stars/$reviewCount;
					}
					//Total Review & Rating Count
					$sp['total_rating']=$reviewCount;
					$sp['rating_avg']=$average;


					// Is Favourite Check
					$isFavourite = $this->CustomerModel->checkIsFavourite($user_id,$sp['service_provider_id']);
					$isVerified = $this->CustomerModel->checkIsVerified($sp['service_provider_id']);
					$favourite=false;
					$verified=false;
					if(!empty($isFavourite))
					{
						if($isFavourite->is_favourite=='Yes')
						{
							$favourite=true;
						}
					}
					if(!empty($isVerified))
					{
						if($isVerified->is_verified=='Yes')
						{
							$verified=true;
						}
					}
					$sp['isVerified']=$verified;
					$sp['isFavourite']=$favourite;



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
					$subcategories = $this->CustomerModel->getAllSubCategories(0,$sp['category_id']);
					$sp['isSubcategoryAvailable']=false;
					if($subcategories>0)
					{
						$sp['isSubcategoryAvailable']=true;
					}

					$arrServiceGivers[$key]=$sp;
				}

				$arrData->category_id=$category_id;

                $data['data'] = $arrData;
                $data['ServiceImages'] = $images;
                $data['Photos'] = $spimages;
                $data['Banners'] = $banners;
                $data['ServiceProviders'] = $arrServiceGivers;
                $data['ReviewListing'] = $arrAllReviews;
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

	public function searchSP_post()
	{
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		$searchtype		= $this->input->post("searchtype");
		$searchkeyword 	= $this->input->post("searchkeyword");
		
		
		if($token == TOKEN)
		{
            if($searchtype=="" || $searchkeyword=="") 
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
				$arrData = $this->CustomerModel->getServiceProviderDetails($searchtype,$searchkeyword);
                $data['data'] = $arrData;
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

	public function deleteAccount_post()
	{
		$token 			= $this->input->post("token");
		$user_id 		= $this->input->post("user_id");
		
		if($token == TOKEN)
		{
			if($user_id =="" )
			{
				$data['responsemessage'] = 'Please provide valid data';
				$data['responsecode'] = "400";
			}	
			else
			{
				$arrUserData = array(
					'status' => 'Delete'
					);
						  
				$result   = $this->Common_Model->update_data('users','user_id',$user_id,$arrUserData);
				
				// $arrData = $this->CustomerModel->getUserDetails($user_id);
				
				// $data['data'] = $arrData;
				$data['responsemessage'] = 'User deleted successfully';
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
}
