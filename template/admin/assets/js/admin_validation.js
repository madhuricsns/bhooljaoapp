
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
		$("#err_zone_pincode").html('Enter Pincode.');
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
		$("#err_city_name").html('Enter City name.');
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
		$("#err_city_name").html('Enter City name.');
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
	var mobile_number=$("#mobile_number").val(); 
	var gender=$("#gender").val();
	var zone_id=$("#zone_id").val();
	var daily_report=$("#daily_report").val();

	var status=$("#status").val();

	$("#err_servicefile").html('');
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
	
	if(servicefile=="")
	{
		$("#err_servicefile").html('Choose Your Profile.');
		flag=0;
	}
	if(full_name=="")
	{
		$("#err_full_name").html('Enter Full name.');
		flag=0;
	}
	if(email_address=="")
	{
		$("#err_email_address").html('Enter Email Id.');
		flag=0;
	}
	if(password=="")
	{
		$("#err_password").html('Enter Password.');
		flag=0;
	}
	if(mobile_number=="")
	{
		$("#err_mobile_number").html('Enter Mobile number.');
		flag=0;
	}
	if(gender=="")
	{
		$("#err_gender").html('Select Gender.');
		flag=0;
	}
	if(zone_id=="")
	{
		$("#err_zone_id").html('Select Zone.');
		flag=0;
	}
	if(address=="")
	{
		$("#err_address").html('Enter Address.');
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
		$("#err_rst_mobilenumber").html('Please enter valid contact number.');
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
			$("#err_rest").html('Select Restaurent.');
			flag=0;
		}
		if(sel_product=="")
		{
		$("#err_product").html('Select Product.');
			flag=0;
		}
       
    }
     else if(banner_subtype=="store")
	{
        
         var sel_rest=$('#sel_rest').val();
         

         $("#err_rest").html('');
         

         if(sel_rest=="")
		{
			$("#err_rest").html('Select Restaurent.');
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