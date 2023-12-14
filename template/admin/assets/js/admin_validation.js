
// validation for order change
function order_change(order_id,order_status,user_type,admin_id,customer_id)
{

	if(confirm("Dear Partner, Are you sure want to change order status?"))
	{
		var order_status=order_status;
		var order_id=order_id;

		var admin_id=admin_id;
		var user_type=user_type;

		var customer_id=customer_id;
		/*alert(order_status);
		alert(order_id);*/
		$("#display_status_msg").hide();

		$.ajax({



			type: "POST",



			url: BASEPATH+"Orders/ajaxSetOrderStatus",



			data:'order_status='+order_status+"&order_id="+order_id+"&admin_id="+admin_id+"&user_type="+user_type+"&customer_id="+customer_id,



			dataType: 'json',



			success: function(response)



			{



				if(response.chnage_st==1)



				{



					$("#display_status_msg").show();



					$('#display_status_msg').fadeOut(1000);



				}



			}



			});



	}



	else



	{



		return false;



	}



}



// code for all manage pages



function chk_isDeleteComnfirm()
{



	if(confirm("Are you really want to delete record?"))



		return true;



	else



		return false;



}

$("#ckbCheckAll").click(function () {
    $(".checkBoxClass").prop('checked', $(this).prop('checked'));
});

// validation for rst status change
function rst_status_change(rst_id,rst_status)
{
	if(confirm("Are you really want to "+rst_status+" record ?"))
	{
		var rst_status=rst_status;
		var rst_id=rst_id; 
		$("#display_status_msg").hide();
		$.ajax({
			type: "POST",
			url: BASEPATH+"Merchant/ajaxSetRstStatus",
			data:'rst_status='+rst_status+"&rst_id="+rst_id,
			dataType: 'json',
			success: function(response)
			{ 
				if(response.chnage_st==1)
				{
					$("#display_status_msg").show();
					$('#display_status_msg').fadeOut(1000);
				}
			}
			});
	}		
	else
	{
		return false;
	}
}

// function for changing customer status

function customer_status_change(user_id,user_status)

{

	$("#sucess_sttaus").hide();

	var user_id=user_id;

	var user_status=user_status;



	if(user_id!='')

	{
		if(confirm("Do you really want to "+user_status+" record?"))
		{
			$.ajax({

					type: "POST",

					url: BASEPATH+"Users/ajaxSetUserStatus",

					data:'user_id='+user_id+"&user_status="+user_status,

					dataType: 'json',

					success: function(response)

					{
		 
						$("#sucess_sttaus").show();

						$('#sucess_sttaus').fadeOut(3000);

					}

					});

		}
		else
		{
			//alert("chk");
			location.reload();
		}
			

	}
	else
	{
		return false;
	}
		

}




$(document).ready(function($)

{

/* end login */

	/* select all customers for notification section*/

	$(".check_all_customers_notification").click(function(){

		 $("input:checkbox.cls_check_all_customers").prop('checked',this.checked);

	});

/* valdiation for add  HelpCenter  */
$('#btn_addHelpCenter').click(function(){
	var helpcenter_name=$("#helpcenter_name").val();
	var helpcenter_value=$("#helpcenter_value").val(); 
	

	$("#err_helpcenter_name").html('');
	$("#err_helpcenter_value").html('');
	$("#err_status").html('');
	var flag=1;
	
	if(helpcenter_name=="")
	{
		$("#err_helpcenter_name").html('Enter help name.');
		flag=0;
	}
	if(helpcenter_value=="")
	{
		$("#err_helpcenter_value").html('Enter help value.');
		flag=0;
	}
	
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end add HelpCenter */


/* valdiation for Updated  HelpCenter  */
$('#btn_uptHelpCenter').click(function(){
	var helpcenter_name=$("#helpcenter_name").val();
	var helpcenter_value=$("#helpcenter_value").val(); 
	

	$("#err_helpcenter_name").html('');
	$("#err_helpcenter_value").html('');
	$("#err_status").html('');
	var flag=1;
	
	if(helpcenter_name=="")
	{
		$("#err_helpcenter_name").html('Enter help name.');
		flag=0;
	}
	if(helpcenter_value=="")
	{
		$("#err_helpcenter_value").html('Enter help value.');
		flag=0;
	}
	
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end Updated HelpCenter */


/* valdiation for add  FAQ  */
$('#btn_addFAQ').click(function(){
	var faq_question=$("#faq_question").val();
	var faq_answer=$("#faq_answer").val(); 
	var faq_type=$("#faq_type").val();
	var status=$("#status").val();

	$("#err_faq_question").html('');
	$("#err_faq_answer").html('');
	$("#err_faq_type").html('');
	$("#err_status").html('');
	var flag=1;
	
	if(faq_question=="")
	{
		$("#err_faq_question").html('Enter faq question.');
		flag=0;
	}
	if(faq_answer=="")
	{
		$("#err_faq_answer").html('Enter faq answer.');
		flag=0;
	}
	if(faq_type=="")
	{
		$("#err_faq_type").html('Please select faq type.');
		flag=0;
	}
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end add FAQ */

/* valdiation for Updated  FAQ  */
$('#btn_uptFAQ').click(function(){
	var faq_question=$("#faq_question").val();
	var faq_answer=$("#faq_answer").val(); 
	var faq_type=$("#faq_type").val();
	var status=$("#status").val();

	$("#err_zone_name").html('');
	$("#err_zone_pincode").html('');
	$("#err_status").html('');
	var flag=1;
	
	if(faq_question=="")
	{
		$("#err_faq_question").html('Enter faq question.');
		flag=0;
	}
	if(faq_answer=="")
	{
		$("#err_faq_answer").html('Enter faq answer.');
		flag=0;
	}
	if(faq_type=="")
	{
		$("#err_faq_type").html('Please select faq type.');
		flag=0;
	}
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end Updated FAQ */


/* valdiation for add  Notification*/
$('#btn_addnoti').click(function(){
	var title=$("#title").val();
	var massage=$("#massage").val();
	var select_type=$("#select_type").val(); 
	var user=$("#user").val();

	$("#err_title").html('');
	$("#err_massage").html('');
	$("#err_select_type").html('');
	$("#err_user").html('');
	var flag=1;
	
	if(title=="")
	{
		$("#err_title").html('Enter your title.');
		flag=0;
	}
	if(massage=="")
	{
		$("#err_massage").html('Enter massage.');
		flag=0;
	}
	if(select_type=="")
	{
		$("#err_select_type").html('Please select type.');
		flag=0;
	}
	if(user=="")
	{
		$("#err_user").html('Please select user.');
		flag=0;
	}
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end add zone */

/* valdiation for add  zone*/
$('#btn_updatezone').click(function(){
	var zone_name=$("#zone_name").val();
	var zone_pincode=$("#zone_pincode").val(); 
	var status=$("#status").val();

	$("#err_zone_name").html('');
	$("#err_zone_pincode").html('');
	$("#err_status").html('');
	var flag=1;
	
	if(zone_name=="")
	{
		$("#err_zone_name").html('Enter zone name.');
		flag=0;
	}
	if(zone_pincode=="")
	{
		$("#err_zone_pincode").html('Enter pincode.');
		flag=0;
	}
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end add zone */
/* valdiation for add  zone*/
$('#btn_addzone').click(function(){
	var zone_name=$("#zone_name").val();
	var zone_pincode=$("#zone_pincode").val(); 
	var status=$("#status").val();

	$("#err_zone_name").html('');
	$("#err_zone_pincode").html('');
	$("#err_status").html('');
	var flag=1;
	
	if(zone_name=="")
	{
		$("#err_zone_name").html('Enter zone name.');
		flag=0;
	}
	if(zone_pincode=="")
	{
		$("#err_zone_pincode").html('Enter pincode.');
		flag=0;
	}
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end add zone */
/* valdiation for add  Material*/
$('#btn_addmaterial').click(function(){
	var material_name=$("#material_name").val();
	var status=$("#status").val();

	$("#err_material_name").html('');
	$("#err_status").html('');
	var flag=1;
	
	if(material_name=="")
	{
		$("#err_material_name").html('Enter material name.');
		flag=0;
	}
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end add material */

$('#btn_addPromocode').click(function(){ 
	// alert();
	// var service_id=$("#service_id").val();
	var promocode_code=$("#promocode_code").val();
	var promocode_description=$("#promocode_description").val();
	var promocode_discount=$("#promocode_discount").val();
	var promocode_type=$("#promocode_type").val();
	var status=$("#status").val();
	
	// $("#err_service_id").html('');
	$("#err_promocode_code").html('');
	$("#err_promocode_description").html('');
	$("#err_promocode_discount").html('');
	$("#err_promocode_type").html('');
	$("#err_status").html('');
	
	var flag=1;
	
	// if(service_id=="")
	// {
	// 	$("#err_service_id").html('Select Service.');
	// 	flag=0;
	// }
	if(promocode_code=="")
	{
		$("#err_promocode_code").html('Enter promocode.');
		flag=0;
	}
	if(promocode_description=="")
	{
		$("#err_promocode_description").html('Enter promocode description.');
		flag=0;
	}
	if(promocode_discount=="")
	{
		$("#err_promocode_discount").html('Enter discount.');
		flag=0;
	}
	if(promocode_type=="")
	{
		$("#err_promocode_type").html('Select promocode type.');
		flag=0;
	}
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	
	if(flag==1)
	{	
		return true;
	}
	else
	{
		return false;
	}
});

/* end of code for adding promocode */

/* valdiation for add  city*/
$('#btn_addcity').click(function(){
	var city_name=$("#city_name").val();
	var state_id=$("#state_id").val();
	var status=$("#status").val();

	$("#err_city_name").html('');
	$("#err_state_id").html('');
	$("#err_status").html('');
	var flag=1;
	
	if(city_name=="")
	{
		$("#err_city_name").html('Enter city name.');
		flag=0;
	}
	if(state_id=="")
	{
		$("#err_state_id").html('Please select state.');
		flag=0;
	}
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end Eidt city */
/* valdiation for add  Material*/
$('#btn_uptcity').click(function(){
		var city_name=$("#city_name").val();
	var state_id=$("#state_id").val();
	var status=$("#status").val();

	$("#err_city_name").html('');
	$("#err_status").html('');
	var flag=1;
	
	if(city_name=="")
	{
		$("#err_city_name").html('Enter city name.');
		flag=0;
	}
	if(state_id=="")
	{
		$("#err_state_id").html('Please select state.');
		flag=0;
	}
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end add city */


/* valdiation for Add  Service provider*/
$('#btn_addsp').click(function(){
	var full_name=$("#full_name").val();
	var servicefile=$("#servicefile").val();
	var email_address=$("#email_address").val();
	var password=$("#password").val();
	var address=$("#address").val();
	var experience=$("#experience").val();
	var mobile_number=$("#mobile_number").val(); 
	var gender=$("input[name='gender']:checked").val();
	var zone_id=$("#zone_id").val();
	var category_id=$("#category_id").val();
	var is_verified=$("#is_verified").val();
	var status=$("#status").val();

	var profile_photo=$('#servicefile')[0].files.length;

	$("#err_servicefile").html('');
	$("#err_full_name").html('');
	$("#err_email_address").html('');
	$("#err_password").html('');
	$("#err_address").html('');
	$("#err_mobile_number").html('');
	$("#err_experience").html('');
	$("#err_gender").html('');
	$("#err_zone_id").html('');
	$("#err_category_id").html('');
	$("#err_is_verified").html('');
	$("#err_status").html('');
	$("#err_profile_photo").html('');
	var flag=1;
	
	if(profile_photo==0)
	{
		$("#err_profile_photo").html('Choose your profile.');
		flag=0;
	}
	if(full_name=="")
	{
		$("#err_full_name").html('Enter full name.');
		flag=0;
	}
	if(email_address=="")
	{
		$("#err_email_address").html('Enter email id.');
		flag=0;
	}
	if(password=="")
	{
		$("#err_password").html('Enter password.');
		flag=0;
	}
	if(mobile_number=="")
	{
		$("#err_mobile_number").html('Enter mobile number.');
		flag=0;
	}
	if(mobile_number!="" &&  mobile_number.length!=10)
	{
		$("#err_mobile_number").html('Please enter valid contact number of 10 digit.');
		flag=0;
	}
	if(mobile_number!="" && isNaN(mobile_number))
	{
		$("#err_mobile_number").html('Please enter valid mobile number.');
		flag=0;
	}
	if(gender==undefined)
	{
		// alert();
		$("#err_gender").html('Select gender.');
		flag=0;
	}
	if(zone_id=="")
	{
		$("#err_zone_id").html('Select zone.');
		flag=0;
	}
	if(category_id=="")
	{
		$("#err_category_id").html('Select category');
		flag=0;
	}
	if(address=="")
	{
		$("#err_address").html('Enter address.');
		flag=0;
	}
	if(experience=="")
	{
		$("#err_experience").html('Enter experience.');
		flag=0;
	}
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	if(is_verified=="")
	{
		$("#err_is_verified").html('Please select is verified.');
		flag=0;
	}
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end add service provider */

/* valdiation for Add  Users */
$('#btn_adduser').click(function(){
	alert();
	var full_name=$("#full_name").val();
	var servicefile=$("#servicefile").val();
	var email_address=$("#email_address").val();
	var password=$("#password").val();
	var address=$("#address").val();
	var mobile_number=$("#mobile_number").val(); 
	var gender=$("input[name='gender']:checked").val();
	var zone_id=$("#zone_id").val();
	var daily_report=$("#daily_report").val();

	var status=$("#status").val();
	var profile_photo=$('#servicefile')[0].files.length;

	$("#err_profile_photo").html('');
	$("#err_full_name").html('');
	$("#err_email_address").html('');
	$("#err_password").html('');
	$("#err_address").html('');
	$("#err_mobile_number").html('');
	$("#err_gender").html('');
	$("#err_zone_id").html('');
	$("#err_daily_report").html('');
	$("#err_status").html('');
	var flag=1;
	
	if(profile_photo=="")
	{
		$("#err_profile_photo").html('Choose your profile.');
		flag=0;
	}
	if(full_name=="")
	{
		$("#err_full_name").html('Enter full name.');
		flag=0;
	}
	if(email_address=="")
	{
		$("#err_email_address").html('Enter email id.');
		flag=0;
	}
	if(password=="")
	{
		$("#err_password").html('Enter password.');
		flag=0;
	}
	if(mobile_number=="")
	{
		$("#err_mobile_number").html('Enter mobile number.');
		flag=0;
	}
	if(mobile_number!="" &&  mobile_number.length!=10)
	{
		$("#err_mobile_number").html('Please enter valid contact number of 10 digit.');
		flag=0;
	}
	if(mobile_number!="" && isNaN(mobile_number))
	{
		$("#err_mobile_number").html('Please enter valid mobile number.');
		flag=0;
	}
	if(gender==undefined)
	{
		$("#err_gender").html('Select gender.');
		flag=0;
	}
	if(zone_id=="")
	{
		$("#err_zone_id").html('Select zone.');
		flag=0;
	}
	if(address=="")
	{
		$("#err_address").html('Enter address.');
		flag=0;
	}
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end add Users */


/* valdiation for Add  Category */
$('#btn_addcategory').click(function(){
	var category_name=$("#category_name").val();
	var description=$("#description").val();
	var status=$("#status").val();

	$("#err_category_name").html('');
	$("#err_description").html('');
	
	$("#err_status").html('');
	var flag=1;
	
	if(category_name=="")
	{
		$("#err_category_name").html('Enter category name.');
		flag=0;
	}
	if(description=="")
	{
		$("#err_description").html('Enter description.');
		flag=0;
	}
	
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end add Category */

/* valdiation for update  Category */
$('#btn_uptcategory').click(function(){
	var category_name=$("#category_name").val();
	var description=$("#description").val();
	var status=$("#status").val();

	$("#err_category_name").html('');
	$("#err_description").html('');
	
	$("#err_status").html('');
	var flag=1;
	
	if(category_name=="")
	{
		$("#err_category_name").html('Enter category name.');
		flag=0;
	}
	if(description=="")
	{
		$("#err_description").html('Enter description.');
		flag=0;
	}
	
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end update Category */

/* valdiation for add Service */
$('#btn_addService').click(function(){
	var category=$("#category").val();
	var service_name=$("#service_name").val();
	var description=$("#description").val();
	var price=$("#price").val();
	var discount_price=$("#discount_price").val();
	var offer_percentage=$("#offer_percentage").val();
	var demo_price=$("#demo_price").val();
	var demo_discount_price=$("#demo_discount_price").val();
	var status=$("#status").val();

	$("#err_category_name").html('');
	$("#err_service_name").html('');
	$("#err_description").html('');
	$("#err_price").html('');
	$("#err_discount_price").html('');
	$("#err_offer_percentage").html('');
	$("#err_demo_price").html('');
	$("#err_demo_discount_price").html('');
	$("#err_status").html('');
	var flag=1;
	
	if(category=="")
	{
		$("#err_category").html('Please select category.');
		flag=0;
	}
	if(service_name=="")
	{
		$("#err_service_name").html('Enter service name.');
		flag=0;
	}
	if(description=="")
	{
		$("#err_description").html('Enter description.');
		flag=0;
	}
	if(price=="")
	{
		$("#err_price").html('Enter price.');
		flag=0;
	}
	if(discount_price=="")
	{
		$("#err_discount_price").html('Enter discount price.');
		flag=0;
	}
	if(offer_percentage=="")
	{
		$("#err_offer_percentage").html('Enter offer percentage.');
		flag=0;
	}
	if(demo_price=="")
	{
		$("#err_demo_price").html('Enter demo price.');
		flag=0;
	}
	if(demo_discount_price=="")
	{
		$("#err_demo_discount_price").html('Enter demo discount price.');
		flag=0;
	}
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end add Service */

/* valdiation for add Service */
$('#btn_uptuser').click(function(){
	
	var category=$("#category").val();
	var service_name=$("#service_name").val();
	var description=$("#description").val();
	var price=$("#price").val();
	var discount_price=$("#discount_price").val();
	var offer_percentage=$("#offer_percentage").val();
	var demo_price=$("#demo_price").val();
	var demo_discount_price=$("#demo_discount_price").val();
	var status=$("#status").val();

	$("#err_category_name").html('');
	$("#err_service_name").html('');
	$("#err_description").html('');
	$("#err_price").html('');
	$("#err_discount_price").html('');
	$("#err_offer_percentage").html('');
	$("#err_demo_price").html('');
	$("#err_demo_discount_price").html('');
	$("#err_status").html('');
	var flag=1;
	
	if(category=="")
	{
		$("#err_category").html('Please select category.');
		flag=0;
	}
	if(service_name=="")
	{
		$("#err_service_name").html('Enter service name.');
		flag=0;
	}
	if(description=="")
	{
		$("#err_description").html('Enter description.');
		flag=0;
	}
	if(price=="")
	{
		$("#err_price").html('Enter price.');
		flag=0;
	}
	if(discount_price=="")
	{
		$("#err_discount_price").html('Enter discount price.');
		flag=0;
	}
	if(offer_percentage=="")
	{
		$("#err_offer_percentage").html('Enter offer percentage.');
		flag=0;
	}
	if(demo_price=="")
	{
		$("#err_demo_price").html('Enter demo price.');
		flag=0;
	}
	if(demo_discount_price=="")
	{
		$("#err_demo_discount_price").html('Enter demo discount price.');
		flag=0;
	}
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end add Service */


/* valdiation for Add  Banner */
$('#btn_addbanner').click(function(){
	var banner_title=$("#banner_title").val();
	var bannertype=$("#bannertype").val();
	var status=$("#status").val();

	$("#err_bannertype").html('');
	$("#err_banner_title").html('');
	
	$("#err_status").html('');
	var flag=1;
	
	
	if(banner_title=="")
	{
		$("#err_banner_title").html('Enter banner title.');
		flag=0;
	}
	if(bannertype=="")
	{
		$("#err_bannertype").html('Please select banner type.');
		flag=0;
	}
	
	if(status=="")
	{
		$("#err_status").html('Please select status.');
		flag=0;
	}
	
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end add Banner */

/* code for driver payment */
$('#btn_adddriverpayment').click(function(){
	var weekday=$("#weekday").val();

	var base_value=$("#base_value").val();

	var per_km_value=$("#per_km_value").val();
	var additional_charges=$("#additional_charges").val();
	var to_time=$("#to_time").val();
	var from_time=$("#from_time").val();

	$("#err_weekday").html('');
	$("#err_base_value").html('');
	$("#err_per_km_value").html('');
	$("#err_additional_charges").html('');
	$("#err_to_time").html('');
	$("#err_from_time").html('');
	
	
	var flag=1;

	if(weekday=="")
	{
		$("#err_weekday").html('Select weekday.');
		flag=0;
	}
	if(base_value=="")
	{
	$("#err_base_value").html('Enter valid base value.');
		flag=0;
	}
	if(per_km_value=="")
	{
		$("#err_per_km_value").html('Enter per km value');
		flag=0;
	}
	if(additional_charges=="")
	{
		$("#err_additional_charges").html('Enter additional charges.');
		flag=0;
	}
	if(to_time=="")
	{
		$("#err_to_time").html('Enter to time.');
		flag=0;
	}
	if(from_time=="")
	{
		$("#err_from_time").html('Enter from time.');
		flag=0;
	}
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end payment */

	
/* valdiation for add  merchant*/

$('#btn_save_merchant').click(function(){
	var rst_userfullname=$("#rst_userfullname").val();

	var rst_mobilenumber=$("#rst_mobilenumber").val();

	var rst_name=$("#rst_name").val();
	var rst_image=$("#rst_image").val();
	var rst_contact_no=$("#rst_contact_no").val();
	var rst_email=$("#rst_email").val();
	var rst_address=$("#rst_address").val();
	
var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	var ext1 = $("#rst_image").val().split('.').pop().toLowerCase();

	$("#err_rst_userfullname").html('');
	$("#err_rst_mobilenumber").html('');
	$("#err_rst_name").html('');
	$("#err_rst_image").html('');
	$("#err_rst_contact_no").html('');
	$("#err_rst_email").html('');
	$("#err_rst_address").html('');
	
	var flag=1;

	if(rst_userfullname=="")
	{
		$("#err_rst_userfullname").html('Enter owner/manager name.');
		flag=0;
	}
	if(rst_mobilenumber=="")
	{
	$("#err_rst_mobilenumber").html('Enter owner phone.');
		flag=0;
	}
	if(rst_mobilenumber!="" &&  rst_mobilenumber.length!=9)
	{
		$("#err_rst_mobilenumber").html('Please enter valid contact number of 9 digit.');
		flag=0;
	}
	if(rst_mobilenumber!="" && isNaN(rst_mobilenumber))
	{
		$("#err_rst_mobilenumber").html('Elease enter valid contact number.');
		flag=0;
	}
	if(rst_name=="")
	{
		$("#err_rst_name").html('Enter store name.');
		flag=0;
	}
	if(rst_image=="")
	{
		$("#err_rst_image").html('Select store photo');
		flag=0;
	}
	if(rst_image!="" && $.inArray(ext1, ['gif','png','jpg','jpeg','bmp']) == -1)
    {
        $("#err_rst_image").html('Invalid store photo.');
        flag=0;
     }

	
	if(rst_contact_no=="")
	{
		$("#err_rst_contact_no").html('Enter store phone number.');
		flag=0;
	}
	if(rst_contact_no!="" &&  rst_contact_no.length!=9)
	{
		$("#err_rst_contact_no").html('Please enter valid contact number of 9 digit.');
		flag=0;
	}
	if(rst_contact_no!="" && isNaN(rst_contact_no))
	{
		$("#err_rst_contact_no").html('Please enter valid contact number.');
		flag=0;
	}
	if(rst_email=="")
	{
		$("#err_rst_email").html('Enter email address.');
		flag=0;
	}
	if (rst_email!="" && !testEmail.test(rst_email))
    {
		$("#err_rst_email").html('Please enter a valid email address.');
		flag=0;
	}
	if(rst_address=="")
	{
		$("#err_rst_address").html('Enter address.');
		flag=0;
	}
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end slider */


/* valdiation for add  slider*/

$('#btn_addslider').click(function(){
	

	var banner_title=$("#banner_title").val();

	var banner_image=$("#banner_image").val();
	var banner_start_date=$("#banner_start_date").val();
	var banner_end_date=$("#banner_end_date").val();

	var ext1 = $("#banner_image").val().split('.').pop().toLowerCase();
//var re = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
//var re = "/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g";

	$("#err_banner_url").html('');
	$("#err_banner_title").html('');
	$("#err_banner_image").html('');
	$("#err_banner_start_date").html('');
	$("#err_banner_end_date").html('');

	var flag=1;
	var banner_subtype=$("#banner_subtype").val();
	if(banner_subtype=="product")
    {
        
         var sel_rest=$('#sel_rest').val();
         var sel_product=$('#sel_product').val();

         $("#err_rest").html('');
         $("#err_product").html('');

         if(sel_rest=="")
		{
			$("#err_rest").html('Select restaurent.');
			flag=0;
		}
		if(sel_product=="")
		{
		$("#err_product").html('Select product.');
			flag=0;
		}
       
    }
     else if(banner_subtype=="store")
	{
        
         var sel_rest=$('#sel_rest').val();
         

         $("#err_rest").html('');
         

         if(sel_rest=="")
		{
			$("#err_rest").html('Select restaurent.');
			flag=0;
		}
		
       
    }
    else
    {
       elm = document.createElement('input');
       elm.setAttribute('type', 'url');
		var banner_url=$("#banner_url").val();
       $("#err_banner_url").html('');
       if(banner_url=="")
		{
			$("#err_banner_url").html('Enter url.');
			flag=0;
		}
		if (!/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i.test($("#banner_url").val()) && banner_url!="") 
		{
			$("#err_banner_url").html('Enter valid url.');
			flag=0;
		}
    }
	if(banner_title=="")
	{
	$("#err_banner_title").html('Enter title.');
		flag=0;
	}
	if(banner_image=="")
	{
		$("#err_banner_image").html('Select banner image.');
		flag=0;
	}
	if(banner_image!="" && $.inArray(ext1, ['gif','png','jpg','jpeg','bmp']) == -1)
    {
        $("#err_banner_image").html('Invalid banner image.');
        flag=0;
     }

	if(banner_start_date=="")
	{
		$("#err_banner_start_date").html('Select start date');
		flag=0;
	}
	if(banner_end_date=="")
	{
		$("#err_banner_end_date").html('Select end date.');
		flag=0;
	}

	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end slider */

$('#btn_updateslider').click(function(){
	//var banner_url=$("#banner_url").val();

	var banner_title=$("#banner_title").val();

	
	var banner_start_date=$("#banner_start_date").val();
	var banner_end_date=$("#banner_end_date").val();

	var ext1 = $("#banner_image").val().split('.').pop().toLowerCase();
var re = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/

	$("#err_banner_url").html('');
	$("#err_banner_title").html('');
	
	$("#err_banner_start_date").html('');
	$("#err_banner_end_date").html('');

	var flag=1;

	if(banner_title=="")
	{
	$("#err_banner_title").html('Enter title.');
		flag=0;
	}
	/*if(banner_image=="")
	{
		$("#err_banner_image").html('Select banner image.');
		flag=0;
	}
	if(banner_image!="" && $.inArray(ext1, ['gif','png','jpg','jpeg','bmp']) == -1)
    {
        $("#err_banner_image").html('Invalid banner image.');
        flag=0;
     }*/

	if(banner_start_date=="")
	{
		$("#err_banner_start_date").html('Select start date');
		flag=0;
	}
	if(banner_end_date=="")
	{
		$("#err_banner_end_date").html('select end date.');
		flag=0;
	}
	if(flag==1)
	{
		return true;
	}
	else
	{
		return false;
	}
});
/* end slider */

});