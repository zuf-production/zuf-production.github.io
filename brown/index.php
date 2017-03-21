
<?php

function removeHTML($texttovalid){
		$texttovalid = trim($texttovalid);
		if(strlen($texttovalid)>0){
			$texttovalid = htmlspecialchars(stripslashes($texttovalid));
		}
		return $texttovalid;
}

if(isset($_POST['submit'])){

	$name = removeHTML($_POST['name']);
	$email = removeHTML($_POST['email']);
	$subject = removeHTML($_POST['subject']);
	$message = removeHTML($_POST['message']);
	$msg ='';
	
	if($name=='' || $name=="Your Name..."){
		$msg = '<li>Name is a required field.</li>';
	}
	if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)){
	   $msg .= '<li>Invalid Email Address</li>';
	}
	if($subject=='' || $subject=="Subject..."){
		$msg .= '<li>Subject is a required field.</li>';
	}
	if($message=='' || $message=="Your Message..."){
		$msg .= '<li>Message is a required field.</li>';
	}
	
	if($msg!=''){
		$msg = '<div class="errorMsg"><h3>Message Field!</h3><ul>' . $msg . '</ul></div>';
	}
	else{
		
		/*Change this email to your email address*/
		$to = "zemdda@gmail.com";
		
		
		$headers = "From: $email";
		$subject = "A message from a site visitor | Great Portfolio!";
		$body = "Name: $name\n\n"
			. "Email: $email\n\n"
			. "Subject: $subject\n\n"
			. "Message: $message"
			;
		$ok = (mail($to, $subject, $body, $headers));
		
		if($ok){
		$msg = '<div class="infoMsg"><h3>Message Sent!</h3><p>Thank you for contacting us. We will get back to you shortly!</p></div>';
		}else{
		$msg = '<div class="errorMsg"><h3>Message Field!</h3><br /><p>Please try again.</p></div>';
		}	
	}
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Great Portfolio! One Page Portfolio</title>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="keywords" content="keyword content here" />
<meta name="description" content="description content here" />
<meta name="robots" content="index, follow, noarchive" />
<meta name="googlebot" content="noarchive" />
<link rel="stylesheet" type="text/css" href="css/portfolio.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />

<script src="js/DD_belatedPNG_0.0.7a-min.js" type="text/javascript"></script>

<script type="text/javascript">
	DD_belatedPNG.fix('#logo a, #intro h2 span, .paper-plane');
</script>
<script src="js/smoothscroll.js" type="text/javascript"></script>


</head>
<body>    
<div id="page">
  <div id="wrap">
    
    <div id="header">
      <div id="logo">
        <h1><a href="index.html">Portfolio</a></h1>
        <span class="tagline">Another great portfolio theme</span> </div>
      <!-- /logo-->
      <div id="intro" class="clear">
      	<span class="paper-plane"></span>
        <h2><span>I build websites based on the latest web standards providing the best possible solution to your company</span></h2>
      </div>
      <!-- /intro-->
      <div id="home">
        <div class="main-nav-wrap clear"><a name="home"></a>
          <ul class="main-nav">
            <li class="current"><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#portfolio">Portfolio</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div>
        <!-- /main-nav-wrap-->
        <div class="featured-work">
          <h2><span>Featured Work</span></h2>
          <a href="#" class="image-thumb"><img src="images/featured_image.jpg" alt="Elegant CSS Templates" /></a>
          <h3>Elegant CSS Templates</h3>
          <p>Pellentesque <a href="#">habitant morbi tristique senectus</a> et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
          <p><a href="#" class="buttonlink">Visit Site</a>&nbsp;<a href="#portfolio" class="buttonlink">View Portfolio</a></p>
        </div>
        <!-- /featured-work-->
        <div class="testimonial">
          <h2><span>Testimonial</span></h2>
          <blockquote>
            <p class="first"> Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat leo. </p>
            <p class="author">— <cite><strong>John Doe</strong>, Position, <a href="#">Company Name</a></cite></p>
          </blockquote>
          <blockquote>
            <p class="first"> Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. </p>
            <p class="author">— <cite><strong>John Doe</strong>, Position, <a href="#">Company Name</a></cite></p>
          </blockquote>
        </div>
        <!-- /testimonial-->
        <div class="twitter">
          <h2><span>Thoughts via Twitter</span></h2>
          
          <ul id="twitter_update_list"><li>&nbsp;</li></ul>

          <p><a href="http://twitter.com/collis" class="buttonlink">Follow me on twitter</a></p>
          <span class="clear"></span>
          <!--/clear for IE6 issue -->
        </div>
        <!-- /twitter-->
      </div>
      <!-- /home-->
      
      <div id="about">
        <div class="main-nav-wrap clear"><a name="about"></a>
          <ul class="main-nav">
            <li><a href="#home">Home</a></li>
            <li class="current"><a href="#about">About</a></li>
            <li><a href="#portfolio">Portfolio</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div>
        <!-- /main-nav-wrap-->
        <div class="about-me">
          <h2><span>About Me</span></h2>
          <p>Hi, my name is <a href="#">Joefrey Mahusay</a> a Filipino Freelance Web Designer and Web Deveoper based in Cagayan de Oro, Philippines.</p>
          <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
          <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui.</p>
        </div>
        <!-- /about-me-->
        <div class="my-services">
          <h2><span>My Services</span></h2>
          <ul>
            <li>Website Design</li>
            <li>Website XHTML &amp; CSS Development</li>
            <li>Wordpress Website Integration</li>
            <li>Joomla Website Integration</li>
            <li>Drupal Website Integration</li>
            <li>Search Engine Optimisation</li>
            <li>Logo and Graphic Design</li>
            <li>Blog Post Writing Services</li>
          </ul>
        </div>
        <!-- /my-services-->
        <div class="download-cv">
          <h2><span>Download My CV</span></h2>
          <span class="downloadcv"><a href="#">Click here to download my CV</a></span>
          <p>Pellentesque habitant morbi <a href="#">tristique senectus</a> et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
        </div>
        <!-- /download-cv-->
      </div>
      <!-- /about-->
      
      
      <div id="portfolio">
          <div class="main-nav-wrap clear"><a name="portfolio"></a>
              <ul class="main-nav">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li class="current"><a href="#portfolio">Portfolio</a></li>
                <li><a href="#contact">Contact</a></li>
              </ul>
            </div>
        <!-- /main-nav-wrap-->
         <div class="sample-works">
      	 	<h2><span>Sample Works</span></h2>
            <ul class="works">
            	<li>
                	<a href="#" class="image-thumb"><img src="images/work1.jpg" alt="Sample Work" /></a>
                    <h3>Elegant CSS Templates</h3>
                    <p>Pellentesque <a href="#">habitant morbi tristique senectus</a> et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                    <p class="responsibility"><small>My Responsibilty</small></p>
                    <p class="skill">Concept Design + XHTML &amp; CSS Development</p>
          <p><a href="#" class="buttonlink">Visit Site</a></p>
                </li>
                <li>
                	<a href="#" class="image-thumb"><img src="images/work1.jpg" alt="Sample Work" /></a>
                    <h3>Elegant CSS Templates</h3>
                    <p>Pellentesque <a href="#">habitant morbi tristique senectus</a> et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                    <p class="responsibility"><small>My Responsibilty</small></p>
                    <p class="skill">Concept Design + XHTML &amp; CSS Development</p>
          <p><a href="#" class="buttonlink">Visit Site</a></p>
                </li>
                <li class="lastrowbox">
                	<a href="#" class="image-thumb"><img src="images/work1.jpg" alt="Sample Work" /></a>
                    <h3>Elegant CSS Templates</h3>
                    <p>Pellentesque <a href="#">habitant morbi tristique senectus</a> et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                    <p class="responsibility"><small>My Responsibilty</small></p>
                    <p class="skill">Concept Design + XHTML &amp; CSS Development</p>
          <p><a href="#" class="buttonlink">Visit Site</a></p>
                </li>
                <li>
                	<a href="#" class="image-thumb"><img src="images/work1.jpg" alt="Sample Work" /></a>
                    <h3>Elegant CSS Templates</h3>
                    <p>Pellentesque <a href="#">habitant morbi tristique senectus</a> et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                    <p class="responsibility"><small>My Responsibilty</small></p>
                    <p class="skill">Concept Design + XHTML &amp; CSS Development</p>
          <p><a href="#" class="buttonlink">Visit Site</a></p>
                </li>
                <li>
                	<a href="#" class="image-thumb"><img src="images/work1.jpg" alt="Sample Work" /></a>
                    <h3>Elegant CSS Templates</h3>
                    <p>Pellentesque <a href="#">habitant morbi tristique senectus</a> et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                    <p class="responsibility"><small>My Responsibilty</small></p>
                    <p class="skill">Concept Design + XHTML &amp; CSS Development</p>
          <p><a href="#" class="buttonlink">Visit Site</a></p>
                </li>
                <li class="lastrowbox">
                	<a href="#" class="image-thumb"><img src="images/work1.jpg" alt="Sample Work" /></a>
                    <h3>Elegant CSS Templates</h3>
                    <p>Pellentesque <a href="#">habitant morbi tristique senectus</a> et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                    <p class="responsibility"><small>My Responsibilty</small></p>
                    <p class="skill">Concept Design + XHTML &amp; CSS Development</p>
          <p><a href="#" class="buttonlink">Visit Site</a></p>
                </li>
            </ul>
         </div>
      </div>

      
      <div id="contact">
        <div class="main-nav-wrap clear"><a name="contact"></a>
          <ul class="main-nav">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#portfolio">Portfolio</a></li>
            <li class="current"><a href="#contact">Contact</a></li>
          </ul>
        </div>
        <!-- /main-nav-wrap-->
        <div class="contact-form">
          <h2><span>Send Me A Message</span></h2>
          <?php echo $msg;?>
          <form id="contact-form" action="<?php echo $_SERVER['PHP_SELF'].'#contact'; ?>" method="post">
            <p>
              <input type="text" name="name" id="cf_name" value="Your Name..." onblur="if (this.value == ''){this.value = 'Your Name...'; this.style.color='#948574';}" onfocus="if (this.value == 'Your Name...') {this.value = ''; this.style.color='#948574';}" />
            </p>
            <p>
              <input type="text" name="cemail" id="cf_email"  value="Your Email..." onblur="if (this.value == ''){this.value = 'Your Email...'; this.style.color='#948574';}" onfocus="if (this.value == 'Your Email...') {this.value = ''; this.style.color='#948574';}"/>
            </p>
            <p>
              <input type="text" name="subject" id="cf_subject" value="Subject..." onblur="if (this.value == ''){this.value = 'Subject...'; this.style.color='#948574';}" onfocus="if (this.value == 'Subject...') {this.value = ''; this.style.color='#948574';}" />
            </p>
            <p>
              <textarea name="message" id="cf_message" cols="20" rows="8" onblur="if (this.value == ''){this.value = 'Your Message...'; this.style.color='#948574';}" onfocus="if (this.value == 'Your Message...') {this.value = ''; this.style.color='#948574';}" >Your Message...</textarea>
            </p>
            <p>
              <input type="submit" class="button-bg" value="Send Your Message" name="submit" />
            </p>
          </form>
        </div>
        <!-- /contact-form-->
        <div class="availability">
          <h2><span>Current Avilability</span></h2>
          <p>Hi, I'm currently <span class="highlight">available</span> for any freelance work.
            Send me an email using the form to the left</p>
        </div>
        <!-- /availability-->
        <div class="contact-info">
          <h2><span>Contact Information</span></h2>
          <p><strong>Great Portfolio.</strong><br />
            2901 Marmora Road, Glassgow, D04 59GR</p>
          <p> Telephone: +1 959 603 6035<br />
            FAX: +1 504 559 5454<br />
            E-mail: <a href="#">mail@yoursitename.com</a></p>
        </div>
        <!-- /download-cv-->
      </div><!-- /contact-->
      
      <div id="footer" class="clear">
      	<div class="floatLeft"><span>&copy; Copyright 2009 <a href="#home">Great Portfolio</a>. All Rights Reserved.</span></div>
        <div class="floatRight">This site is conform to <abbr title="World Wide Web Consortium">W3C</abbr> Standard <a href="http://validator.w3.org/check?uri=referer" title="Validate XHTML">XHTML</a> &amp; <a href="http://jigsaw.w3.org/css-validator/check/referer" title="Validate CSS">CSS</a>
        <div class="clear"></div>
        </div>
        <div class="clear"></div>
      </div>
      
    </div>
  </div>
</div>
<!-- twitter start script -->
<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/collis.json?callback=twitterCallback2&amp;count=4"></script>
<!-- twitter end script -->

</body>
</html>
