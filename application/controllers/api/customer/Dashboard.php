<?php
require(APPPATH.'/libraries/REST_Controller.php');

class Dashboard extends REST_Controller {
 
	public function __construct()
    {
        parent::__construct();
		$this->load->model('ApiModels/customer/DashboardModel');
		$this->load->model('Common_Model');
	}
	
	public function index_post()
	{
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		$userLat 		= $this->input->post("userLat");
		$userLong 		= $this->input->post("userLong");		
		if($token == TOKEN)
		{
            /*if($user_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            { */
                $userdetails = $this->DashboardModel->getUserDetails($user_id);
				if(!empty($userdetails))
				{
					if(!isset($userdetails->full_name))
					{
						$userdetails->full_name="";
					}
					if(!isset($userdetails->profile_pic))
					{
						$userdetails->profile_pic="";
					}
					if(!isset($userdetails->address))
					{
						$userdetails->address="";
					}
					if(!isset($userdetails->user_lat))
					{
						$userdetails->user_lat="";
					}
				}
				else
				{
					$userdetails="";
				}
				
				// Banners Listing
				$banners = $this->DashboardModel->getAllBanners();
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
				//Category Listing
				$categories = $this->DashboardModel->getCategory(6);
				// echo $this->db->last_query();
				foreach($categories as $key=>$category)
				{
					$subcategories = $this->DashboardModel->getAllSubCategories(0,$category['category_id']);
					$category['isSubcategoryAvailable']=false;
					if($subcategories>0)
					{
						$category['isSubcategoryAvailable']=true;
					}
					$categories[$key]=$category;
				}

				$arrOngoingServices = $this->DashboardModel->ongoingServices(3,$user_id);
				foreach($arrOngoingServices as $key=>$booking)
				{
					$categoryData=$this->DashboardModel->getCategoryDetails($booking['category_id']);
					$main_category="";
					if($categoryData->category_parent_id!=0)
					{
						$category=$this->DashboardModel->getCategoryDetails($categoryData->category_parent_id);
						$category_id=$categoryData->category_parent_id;
						$main_category=$category->category_name;
						$booking['category_name']=$main_category."-".$booking['category_name'];
					}
					// Calculate Days
					$date1 = new DateTime($booking['booking_date']);
					$date1 = $date1->format('Y-m-d');
					
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
					
					$booking['booking_date']=$date1->format('M d,Y');
					$booking['expiry_date']=$date2->format('M d,Y');

					$booking['expiry_day']=$days;
					if(!isset($booking['full_name']))
					{
						$booking['full_name']="";
					}
					if(!isset($booking['profile_pic']))
					{
						$booking['profile_pic']="";
					}

					$arrOngoingServices[$key]=$booking;
				}

				$arrServiceGivers = $this->DashboardModel->getNearByServiceGivers(3,$userLat,$userLong);
				// print_r($arrServiceGivers);
				// echo $this->db->last_query();
				foreach($arrServiceGivers as $k=>$sp)
				{
					//  Review
					$arrReviewsData=$this->DashboardModel->getReviews($sp['service_provider_id']);
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
					$isFavourite = $this->DashboardModel->checkIsFavourite($user_id,$sp['service_provider_id']);
					$isverified = $this->DashboardModel->checkIsVerified($sp['service_provider_id']);
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
					$subcategories = $this->DashboardModel->getAllSubCategories(0,$sp['category_id']);
					$sp['isSubcategoryAvailable']=false;
					if($subcategories>0)
					{
						$sp['isSubcategoryAvailable']=true;
					}

					$arrServiceGivers[$k]=$sp;
				}
				//print_r($arrServiceGivers);
                //$banners = $this->DashboardModel->getAllBanners();
               
                //$this->Common_Model->insert_data('banner',$inputArr);
                $data['responsecode'] = "200";
                $data['UserData'] = $userdetails;
                $data['Banners'] = $banners;
                $data['Categories'] = $categories;
				$data['OngoingServices'] = $arrOngoingServices;
                $data['NearByServiceGivers'] = $arrServiceGivers;
                //$data['banners'] = $banners;
            // }
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

	public function nearbyServiceGivers_post()
	{
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		$userLat 		= $this->input->post("userLat");
		$userLong 		= $this->input->post("userLong");		
		if($token == TOKEN)
		{
            /*if($user_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            { */
                $userdetails = $this->DashboardModel->getUserDetails($user_id);
				if(!empty($userdetails))
				{
					if(!isset($userdetails->full_name))
					{
						$userdetails->full_name="";
					}
					if(!isset($userdetails->profile_pic))
					{
						$userdetails->profile_pic="";
					}
					if(!isset($userdetails->address))
					{
						$userdetails->address="";
					}
					if(!isset($userdetails->user_lat))
					{
						$userdetails->user_lat="";
					}
				}
				else
				{
					$userdetails="";
				}
				
				$arrServiceGivers = $this->DashboardModel->getNearByServiceGivers('',$userLat,$userLong);
				// echo $this->db->last_query();
				foreach($arrServiceGivers as $key=>$sp)
				{
					//  Review
					$arrReviews=$this->DashboardModel->getReviews($sp['service_provider_id']);
					//echo $this->db->last_query();
					$star1=$star2=$star3=$star4=$star5=$rowCount=$average=$percent=0;
					foreach($arrReviews as $k=>$review)
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
						$arrReviews[$k]=$review;
					}
					$tot_stars = $star1 + $star2 + $star3 + $star4 + $star5;
					$reviewCount=count($arrReviews);
					if($tot_stars>0)
					{
						$average = $tot_stars/$reviewCount;
					}
					// echo $average;
					//Total Review & Rating Count
					$sp['total_rating']=$reviewCount;
					$sp['rating_avg']=number_format($average,1);

					$sp['isVerified']=false;
					$sp['isFavourite']=false;

					// Is Favourite and Verified
					$isFavourite = $this->DashboardModel->checkIsFavourite($user_id,$sp['service_provider_id']);
					
					$isverified = $this->DashboardModel->checkIsVerified($sp['service_provider_id']);
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
					$subcategories = $this->DashboardModel->getAllSubCategories(0,$sp['category_id']);
					$sp['isSubcategoryAvailable']=false;
					if($subcategories>0)
					{
						$sp['isSubcategoryAvailable']=true;
					}

					$arrServiceGivers[$key]=$sp;
				}
				//print_r($arrServiceGivers);
                //$banners = $this->DashboardModel->getAllBanners();
               
                //$this->Common_Model->insert_data('banner',$inputArr);
                $data['responsecode'] = "200";
                $data['UserData'] = $userdetails;
                $data['NearByServiceGivers'] = $arrServiceGivers;
            // }
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

	public function ongoingServices_post()
	{
		$token 			= $this->input->post("token");
		$user_id		= $this->input->post("user_id");
		$userLat 		= $this->input->post("userLat");
		$userLong 		= $this->input->post("userLong");		
		if($token == TOKEN)
		{
            /*if($user_id=="")
            {
                $data['responsemessage'] = 'Please provide valid data ';
                $data['responsecode'] = "400"; //create an array
            }
            else
            { */
                $userdetails = $this->DashboardModel->getUserDetails($user_id);
				if(!empty($userdetails))
				{
					if(!isset($userdetails->full_name))
					{
						$userdetails->full_name="";
					}
					if(!isset($userdetails->profile_pic))
					{
						$userdetails->profile_pic="";
					}
					if(!isset($userdetails->address))
					{
						$userdetails->address="";
					}
					if(!isset($userdetails->user_lat))
					{
						$userdetails->user_lat="";
					}
				}
				else
				{
					$userdetails="";
				}
				
				$arrOngoingServices = $this->DashboardModel->ongoingServices('',$user_id);
				foreach($arrOngoingServices as $key=>$booking)
				{
					// Calculate Days
					$date1 = new DateTime($booking['booking_date']);
					$date1 = $date1->format('Y-m-d');
					
					$date2 = new DateTime($booking['expiry_date']);
					$date2 = $date2->format('Y-m-d');

					$date1=date_create($date1);
					$date2=date_create($date2);
					
					$interval = date_diff($date1, $date2); 
					$days  = $interval->format('%a days left'); 
					
					$booking['booking_date']=$date1->format('M d,Y');
					$booking['expiry_date']=$date2->format('M d,Y');

					$booking['expiry_day']=$days;
					if(!isset($booking['full_name']))
					{
						$booking['full_name']="";
					}
					if(!isset($booking['profile_pic']))
					{
						$booking['profile_pic']="";
					}

					$arrOngoingServices[$key]=$booking;
				}
				
                $data['responsecode'] = "200";
                $data['UserData'] = $userdetails;
				$data['OngoingServices'] = $arrOngoingServices;
            // }
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
    
}
