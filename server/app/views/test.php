<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	 
</head>
<body>
	<div class="welcome">
		 <form method="post" id="validation-form" name="slider_image" action="" class="form-horizontal"  enctype="multipart/form-data" >
		  <input  type="file" id="photo" name="photo" />
 
		 
		 <button class="btn btn-info" type="submit" name="submit" id="submit">
						<i class="ace-icon fa fa-check bigger-110"></i>
						Submit
					</button>
		 </form>
		<h1>You have arrived.</h1>
	</div>
<?php
 $data = array("name" => "Hagrid", "age" => "36");                                                                    
$data_string = json_encode($data);
$data_string   ='{
  "id": 19,
  "email": "tola@smart.com",
  "permissions": null,
  "activated": false,
  "activation_code": null,
  "activated_at": null,
  "last_login": null,
  "persist_code": null,
  "reset_password_code": null,
  "first_name1": "Toli",
  "last_name": "Smart",
  "created_at": "2014-10-11 23:19:10",
  "updated_at": "2014-10-11 23:19:10",
  "user_type": "1",
  "address": null,
  "phone_number": "4126920720",
  "longitude": null,
  "latitude": null,
  "state_id": 3,
  "town_id": 6,
  "area_id": 1132,
  "gender": "M",
  "dob": "10/10/1997",
  "photo_path": null,
  "student": null,
  "tutor": {
    "id": 19,
    "rate": "0.00",
    "profile_title": "",
    "profile_summary": "",
    "occupation": "",
    "terms_agreed": 0,
    "created_at": "2014-10-11 23:19:10",
    "updated_at": "2014-10-11 23:19:10"
  },
  "education": "F",
  "major": "Computer Science",
  "institution": "Babcock Uni",
  "rate": "100",
  "subjects": [
    2,
    6,
	12,
    16
  ]

}';                                                                                
 
 $data_string='{
 "from": 4,
 "to": [1,2,3],
 "subject": "hello",
 "body":"message"
}
'; 
$ch = curl_init('http://localhost/neartutor-job/public/v1/user/4/mail/8');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
 
$result = curl_exec($ch);
print_r($result);
?>
</body>
</html>
