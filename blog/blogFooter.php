<br /><br />
<center>
<div class="orderForm" id="optin">
    <table>
    <tr>
        <td>
            <img src="images/splash/nusXSmall.jpg" alt="NUS Cover" title="NUS Cover" />
        </td>
        <td width="30px"></td>
        <td align="center">
            <h2>Get Your Free Neobux Report!</h2>
            
            <p>Just Enter Your Email Address Below </p>
            <form method=post action="http://www.trafficwave.net/cgi-bin/autoresp/inforeq.cgi">
            <table align="center" cellpadding="1">
            <tr>
                <td align="left"></td>
                <td><input type=text id="da_email" name="da_email" class="input" size="25" 
                value="Enter your email" onclick="if(this.value=='Enter your email') this.value=''" />
                </td>
            </tr><tr>
                <td colspan="2" align="center">
                
                    <input type="image" src="images/sales/getAccessNow.png" name="subscribe" width="200px"  
                    title="Subscribe Now!"></td>
            </tr>
            </table>
            
            <input type=hidden id="da_name" name="da_name" value="PTC User">
            <input type=hidden name="da_cust1" value="blog post" />
            <input type=hidden name="da_cust2" value="">
            <input type=hidden name="trwvid" value="theemperor">
            <input type=hidden name="series" value="nusnewsletter">
            <input type=hidden name="subscrLandingURL" value="http://neobuxultimatestrategy.com/redirect.php?url=basics">
            <input type=hidden name="confirmLandingURL" value="http://neobuxultimatestrategy.com/redirect.php?url=basics">
            </form>
            
            <br />
            <span class="note">We hate spam and will never sell your email address to others. </span>
        </td>
    </tr>
    </table>
</div>	
</center>

<?
$selP = 'SELECT * FROM posts WHERE status <> "I" ORDER BY postedOn DESC LIMIT 10';
$resP = mysql_query($selP, $conn) or die(mysql_error());

while($p = mysql_fetch_assoc($resP)) {
    $recentPosts .= '<p align="left"><a href="./?p='.$p['url'].'">'.shortenText($p['subject'], 35).'</a></p>'; 
}
?>	

<p>&nbsp;</p>
	 
</td>
<td width="20px"></td>
<td align="center" id="rightCol">
<br />
<center>
<div class="optin" id="optin">
    <table width="310px" cellpadding="0">
        <tr>
            <td align="center">
        
		<h1>Get 1000+ Downlines Using Our System!</h1>
	
		<p class="note"><input type=checkbox checked>Yes, please subscribe me and send 
                    me a copy of the <br><b>free Neobux Basics eBook!</b></p>
		
		<br />
		<form method=post action="http://www.trafficwave.net/cgi-bin/autoresp/inforeq.cgi">
    
                    <input type=text class="input" size="25" id="da_email" name="da_email" value="Your Email Address"
                    onclick="if(this.value=='Your Email Address') this.value='';">

                    <input type=image src="images/sales/getAccessNow.png"
                        value=" >> Subscribe! << " onclick="submit();" width="250px" />            

                    <input type="hidden" id="da_name" name="da_name" value="PTC User" />
                    <input type=hidden name="da_cust1" value="blog menu">
                    <input type=hidden name="da_cust2" value="<?=$_SERVER[HTTP_REFERER]?>">
                    <input type=hidden name="trwvid" value="theemperor">
                    <input type=hidden name="series" value="nusnewsletter">
                    <input type=hidden name="subscrLandingURL" value="<?=$subscrLandingURL?>">
                    <input type=hidden name="confirmLandingURL" value="<?=$confirmLandingURL?>">
                </form>
		
                <p><span class="note">We hate spam and will never sell your email address <br />to others. 
                        All opt-ins are completely optional.</span></p>
		 
            </td>
	</tr>
	</table>
	</div>
	</center>
	<br /><br />
	
	<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
        <fb:like-box href="http://www.facebook.com/NeobuxUltimateStrategy" width="320" show_faces="true"    
        border_color="gray" stream="false" header="true"></fb:like-box>
    
	<br /><br />
	<div class="moduleBlue"><h1>Recent Posts</h1><div>
		<?=$recentPosts?>
		<center><p><a href="./?action=posts">Show all posts</a></p></center>
	</div></div>
	
	<br /><br />
        
	<!--
	<div class="moduleBlue"><h1>Video Testimonials</h1><div>

        <iframe width="300" height="230" src="http://www.youtube.com/embed/Wu5LwJ5wQYQ" frameborder="0" allowfullscreen></iframe>
	</div></div>
	-->	
        
        

        <div class="moduleBlue"><h1>Current Products </h1>
            <div>

            <p><b>Neobux Basics</b></p>
            <p>To get this free ebook just sign up to our newsletter.</p>

            <p><b><a href="./">Neobux Ultimate Strategy</a></b></p>

            <p>The ultimate strategy guide to making money with Neobux, comes in PDF format and 
            video tutorials. </p>

            <p><b><a href="./minisite">PTC Mini-Sites</a></b></p>

            <p>Get your own PTC website for a fraction of the cost of regular websites</p>

            </div>
        </div>
        
        <br /><br />
		
        <div class="moduleBlue"><h1>Neobux Ultimate Strategy</h1><div>
        <center>
            <p><a href="./"><img src="./images/sales/nus.jpg" title="Neobux Ultimate Strategy" width="150px" /></a> </p>
            <p>Make $20 to $30 a day with Neobux </p>
        </center>
	    </div></div>
	   
	    <br /><br />
        
        <div class="moduleBlue"><h1>NUS Video Course</h1><div>
        <center>
            <p><a href="./"><img src="./images/guide/cd.jpg" title="NUS Video Course" width="180px" /></a> </p>
            <p>The Neobux Ultimate Strategy <br />in video format</p>
        </center>
        </div></div>
        
        <br /><br />
       
        <div class="moduleBlue"><h1>Recommended Sites</h1><div>
            <p><a href="http://vector.me" title="Free Clipart" target="_blank">Free Clipart</a></p>

            <p><a href="http://pp-booster-system.com" target="_blank">Paypal Booster</a></p>
            
            <p><a href="http://bestpayingsites.com/" target="_blank">Email Profit System</a></p>
                
            <p><a href="http://www.neobux.com/forum/?/15/229319/Thanks-to-Neobux-Ultimate-Strategy/" target="_blank">Neobux Forum 1</a></p>
            
            <p><a href="http://www.neobux.com/forum/?/7/213100/Neobux-Ultimate-Strategy/" target="_blank">Neobux Forum 2</a></p>            
        </div>
        </div>
	</td>
    </tr>
</table>
          
    <p>&nbsp;</p> <hr />

    <div class="footer">
        <p>Copyright &copy; <?=date('Y', time())?> NUS Blog - All rights reserved</p>

        <div id="eXTReMe"><a href="http://extremetracking.com/open?login=richptc">
        <img src="http://t1.extreme-dm.com/i.gif" style="border: 0;"
        height="38" width="41" id="EXim" alt="eXTReMe Tracker" /></a>
        <script type="text/javascript"><!--
        EXref="";top.document.referrer?EXref=top.document.referrer:EXref=document.referrer;//-->
        </script><script type="text/javascript"><!--
        var EXlogin='richptc' // Login
        var EXvsrv='s10' // VServer
        EXs=screen;EXw=EXs.width;navigator.appName!="Netscape"?
        EXb=EXs.colorDepth:EXb=EXs.pixelDepth;EXsrc="src";
        navigator.javaEnabled()==1?EXjv="y":EXjv="n";
        EXd=document;EXw?"":EXw="na";EXb?"":EXb="na";
        EXref?EXref=EXref:EXref=EXd.referrer;
        EXd.write("<img "+EXsrc+"=http://e1.extreme-dm.com",
        "/"+EXvsrv+".g?login="+EXlogin+"&amp;",
        "jv="+EXjv+"&amp;j=y&amp;srw="+EXw+"&amp;srb="+EXb+"&amp;",
        "l="+escape(EXref)+" height=1 width=1>");//-->
        </script><noscript><div id="neXTReMe"><img height="1" width="1" alt=""
        src="http://e1.extreme-dm.com/s10.g?login=richptc&amp;j=n&amp;jv=n" />
        </div></noscript></div>

    </div><!--footer-->
</div><!-- container -->
</div><!-- wrapper -->

<br />

</body>
</html>