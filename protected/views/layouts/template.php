<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pl" xml:lang="pl">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Paweł 'kilab' Balicki - kilab.pl" />
<title>MUIC V2.0 Content Management</title>
<link rel="stylesheet" type="text/css"
	href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css"
	media="screen, projection" />

<link rel="stylesheet" type="text/css"
	href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.treeview.css"
	media="screen, projection" />


<script type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl; ?>/lib/jquery.js"></script>
<script type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl; ?>/lib/jquery.cookie.js"></script>
<script type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.treeview.js"></script>


<script type="text/javascript">

$(document).ready(function(){
	$("#browser").treeview({
		toggle: function() {
			console.log("%s was toggled.", $(this).find(">span").text());
		}
	});
	
	$("#add").click(function() {
		var branches = $("<li><span class='folder'>New Sublist</span><ul>" + 
			"<li><span class='file'>Item1</span></li>" + 
			"<li><span class='file'>Item2</span></li></ul></li>").appendTo("#browser");
		$("#browser").treeview({
			add: branches
		});
	});
});

$(function(){
	$(".box .h_title").not(this).next("ul").hide("normal");
	$(".box .h_title").not(this).next("#home").show("normal");
	$(".box").children(".h_title").click( function() { $(this).next("ul").slideToggle(); });
});
</script>
</head>
<body>
	<div class="wrap">
		<div id="header">
			<div id="top">
				<div class="left">
					<p></p>
					<p>

						<?php echo UserLoginUtil::getUserInfo();?>
						<strong> </strong> [ <a
							href="/itech2/index.php/Dashboard/Logout">logout</a> ]
					</p>


				</div>
				<div class="right">
					<div class="align-right">
						<p>
							<img src="/itech2/images/muiclogo.png" height="40px;"
								style="margin-top: -25px;" />
						</p>

						<p style="margin-top: +10px">

							<b style="color: yellow;">MUIC V2.0 Content Management</b>

						</p>

					</div>
				</div>
			</div>

		</div>

		<div id="content">
			<div id="sidebar">
				<?php if( UserLoginUtil::getUserRole() ==1 ){?>
				<div class="box">

					<div class="h_title">&#8250; Main control</div>
					<ul id="home">

						<li class="b2"><a class="icon contact"
							href="<?php echo Yii::app()->createUrl('ServicePushnotification')?>">Send
								Message</a>
						</li>
						<li class="b1"><a class="icon add_page"
							href="<?php echo Yii::app()->createUrl('Publish')?>">Publish
								Application </a></li>
					</ul>
				</div>
				<?php }?>
				<?php if( UserLoginUtil::getUserRole() >0 ){?>
				<div class="box">
					<div class="h_title">&#8250; Management</div>
					<ul id="home">
						<!-- 
						<li class="b2"><a class="icon page"
							href="<?php echo Yii::app()->createUrl('AppMenu/listView')?>">Manage
								Menu</a>
						</li>
						 -->
						<li class="b2"><a class="icon page"
							href="<?php echo Yii::app()->createUrl('AppMenu')?>">Manage
								Content</a>
						</li>

						<li class="b2"><a class="icon category"
							href="<?php echo Yii::app()->createUrl('AppBanner')?>">Manage
								Banner</a>
						</li>
						<li class="b2"><a class="icon category"
							href="<?php echo Yii::app()->createUrl('AppIcon')?>">Manage Icon</a>
						</li>
						<?php if(  UserLoginUtil::getUserAppId() == 4 ){ ?>
						<li class="b2"><a class="icon report"
							href="<?php echo Yii::app()->createUrl('Book')?>">Manage Book</a>
						</li>
						<li class="b1"><a class="icon add_page"
							href="<?php echo Yii::app()->createUrl('Question')?>">Manage
								Question</a> <?php 
								if(CommonUtil::checkHaveNewMessage())
								{
									?> <img src="../images/i_error.png" /> <?php
								}
								?>
						</li>
						<li class="b1"><a class="icon add_page"
							href="<?php echo Yii::app()->createUrl('QuestionAnswer')?>">Manage
								Answer</a>
						</li>
						<?php }else{?>
						<?php if(UserLoginUtil::getUserAppId() <> 1){?>
						<?php }?>
						<?php }?>

					</ul>
				</div>
				<?php }?>
				<?php 
				 if( UserLoginUtil::getUserRole() == 1){?>
				<div class="box">
					<div class="h_title">&#8250; Master Data</div>
					<ul>
						<li class="b1"><a class="icon config"
							href="<?php echo Yii::app()->createUrl('AppStore')?>">Store</a>
						</li>
					</ul>
				</div>

				<div class="box">
					<div class="h_title">&#8250; Account</div>

					<ul>
						<li class="b2"><a class="icon add_user"
							href="<?php echo Yii::app()->createUrl('Users')?>">User</a>
						</li>
					</ul>
				</div>

				<?php }?>

			</div>
			<div id="main">
				<?php echo $content; ?>
			</div>
			<div class="clear"></div>
		</div>

		<div id="footer">
			<div class="left">
				<p>
					Design: <a href="#">edtech@muic</a> | : <a
						href="http://www.muic.mahidol.ac.th/eng/">muic.mahidol.ac.th</a>
				</p>
			</div>
			<div class="right">
				<p></p>
			</div>
		</div>
	</div>

</body>
</html>
