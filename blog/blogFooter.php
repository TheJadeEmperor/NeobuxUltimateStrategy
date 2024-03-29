<?php
$opt = array(
	'tableName' => 'posts',
	'cond' => 'WHERE status <> "I" ORDER BY postedOn DESC LIMIT 10'
);

$resP = dbSelectQuery($opt);

while($p = $resP->fetch_array()) {
    $recentPosts .= '<p align="left"><a href="./?p='.$p['url'].'">'.shortenText($p['subject'], 35).'</a></p>'; 
}
?>

	</section><!--leftContent-->
	<section class="blogSidebar">
		
		<!-- ebook cover -->
		<a href="#optin"><img src="<?=$dir?>images/nus/book.png" alt="NUS Cover" title="NUS Cover" width="300px" /></a>
		
		<p>&nbsp;</p>
			
		<h1>Recent Posts</h1>
		<?=$recentPosts?>
		<center><p><a href="./?action=posts">Show all posts</a></p></center>
	
		<p>&nbsp;</p>
		
		<h1>Current Products </h1>
		
		<div style="text-align: left">
            <p><b>Neobux Basics</b></p>
            <p>To get this free ebook just sign up to our newsletter.</p>

            <p><b><a href="./">Neobux Ultimate Strategy</a></b></p>

            <p>The ultimate strategy guide to making money with Neobux, comes in PDF format and 
            video tutorials. </p>

            <p><b><a href="./minisite">PTC Mini-Sites</a></b></p>

            <p>Get your own PTC website for a fraction of the cost of regular websites</p>
		</div>
		
		<div class="moduleBlue"><h2>Neobux Ultimate Strategy</h2>
			<div>
			<center>
				<p><a href="./"><img src="<?=$dir?>images/sales/nus.jpg" title="Neobux Ultimate Strategy" width="150px" /></a> </p>
				<p>Make $20 to $30 a day with Neobux </p>
			</center>
			</div>
		</div>
		   
	    <br /><br />
        
        <div class="moduleBlue"><h2>NUS Video Course</h2>
		<div>
        <center>
            <p><a href="./"><img src="<?=$imgDir?>banners/cd.jpg" title="NUS Video Course" width="180px" /></a> </p>
            <p>The Neobux Ultimate Strategy <br />in video format</p>
        </center>
        </div>
		</div>
        
        <br /><br />
       
        <div class="moduleBlue"><h2>Recommended Sites</h2>
		<div style="text-align: left;">
            <p><a href="https://bestpayingsites.com/ppbooster" target="_blank">Paypal Booster</a></p>
            
            <p><a href="https://bestpayingsites.com/" target="_blank">Email Profit System</a></p>
                
            <p><a href="https://www.neobux.com/forum/?/15/229319/Thanks-to-Neobux-Ultimate-Strategy/" target="_blank" rel="nofollow">Neobux Forum 1</a></p>
            
            <p><a href="https://www.neobux.com/forum/?/7/213100/Neobux-Ultimate-Strategy/" target="_blank" rel="nofollow">Neobux Forum 2</a></p>            
        </div>
        </div>
        
		<p>&nbsp;</p>
	</section><!--sidebar-->
</footer>

<footer class="orderForm" id="optin">
	<section id="ebookCover">
		<img src="<?=$dir?>images/nus/book.png" alt="NUS Cover" title="NUS Cover" />
	</section>
	<section id="signUpForm">
		<h1>Get Your Free Neobux Report!</h1>
			<h2 align="center">Just Enter Your Email Address Below </h2>
		
            <form name="sendgrid" method="post" action="<?=$subscribeLandingURL?>">
            <table align="center" cellpadding="1">
            <tr>
                <td align="left"></td>
                <td align="center">
					<div id="error"></div>
					<input type="text" id="email" name="email" class="input" size="25"  value="Your Best Email" onclick="if(this.value=='Your Best Email') this.value=''; " />
				
					<input type="image" src="<?=$dir?>images/sales/getAccessNow.png" name="subscribe" title="Subscribe Now!" onclick="return validateEmail(document.sendgrid.email.value);" />
					
					<p><span class="note">We hate spam and will never sell your email address to others. </span></p>
				</td>
            </tr>
            </table>
            </form>
            
            <br />
	</section>
</footer>

	<p>&nbsp;</p>
	<p>&nbsp;</p>
 
	</div>
		</div>
			</section>
				</div>

				<!-- Footer -->
				<footer id="footer">
				<section>
					<h2>About the Neobux Ultimate Strategy</h2>
					<p>The NUS is the ultimate strategy that will help earn an income from Neobux and all PTC sites. You will get unlimited direct referrals and never be frustrated again!</p>
					<ul class="actions">
						<li><a href="./" class="button">Learn More</a></li>
					</ul>
				</section>
				<section>
					<h2>NUS Contact Info</h2> 
					
						<dl class="alt">
							<dt>URL </dt>
							<dd><a href="./?action=posts" title="<?=$businessName?> Blog">Home</a> &bull; 
								<a href="./?action=faq" title="<?=$businessName?> FAQ">FAQ</a> &bull; 
								<a href="./?action=terms" title="<?=$businessName?> Terms">Terms</a> &bull;
								<a href="./?action=privacy" title="<?=$businessName?> Privacy">Privacy</a> &bull;				
								<a href="./members" title="<?=$businessName?> Members Login">Members Login 
							</dd>
							
							<dt>Links</dt>
							<dd><a href="https://bestpayingsites.com/ppbooster" title="Paypal Booster">Paypal Booster</a> &bull;
							<a href="https://bestpayingsites.com/" title="Email Profit System">Email Profit System</a> &bull;
							<a href="https://bestpayingsites.com/surveys" title="Best Paying Surveys">Best Paying Surveys</a>
							</dd>
							
							<dt>Email</dt>
							<dd><a href="mailto:<?=$supportEmail?>"><?=$supportEmail?></a></dd>
							
							<dt>Disclaimer</dt>
							<dd><a href="?action=terms" target="_BLANK">Terms</a> &bull; <a href="?action=privacy" target="_BLANK">Privacy</a></dd>
						</dl>
						<ul class="icons">
						 
							<li><a href="https://www.instagram.com/confucius.philosopher/" class="icon fa-instagram alt" target="_BLANK"><span class="label">Instagram</span></a></li>
							
							<li><a href="https://extremetracking.com/open?login=nus" class="icon fa-globe alt" target="_BLANK"></a></li>
							
							<li><a href="https://www.youtube.com/channel/UC00XFWxJbES4ZDXpnspVsEA" class="icon fa-youtube alt" target="_BLANK"><span class="label">Instagram</span></a></li>
							
						</ul>
					</section> 
					<p class="copyright">&copy; Benjamin Louie <a href="https://benjaminlouie.com/">BL Web Solutions</a>.</p>
				</footer>
			</div>

			<!-- extreme tracker code -->
			<script src="https://efreecode.com/js.js" id="eXF-nus-0" async defer></script>
	</body>	
</html>