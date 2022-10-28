<!DOCTYPE html>
<html>
<head>
	<!-- Template Main CSS File -->
	   <!-- Styles -->
	   <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">	  
	    			  
	
	<title>Naybiz</title>
	@vite('resources/css/app.css')
  
</head>
<body>
	<div id="main"> 
		<router-view></router-view>						  
    </div>
	@vite('resources/js/app.js')
	@vite('resources/js/imports/popper.min.js')
	@vite('resources/js/imports/bootstrap.min.js')
	@vite('resources/js/imports/scripts.js')
	@vite('resources/js/imports/swiper.min.js')
</body>
</html>