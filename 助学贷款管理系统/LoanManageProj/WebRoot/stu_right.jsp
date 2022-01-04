<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%@ taglib prefix="s" uri="/struts-tags"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<link href="css/skin.css" rel="stylesheet" type="text/css" />
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
		<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #EEF2FB;
}
</style>
</head>
		<body>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="17" valign="top" background="images/mail_leftbg.gif">
						<img src="images/left-top-right.gif" width="17" height="29" />
					</td>
					<td valign="top" background="images/content-bg.gif">
						<table width="100%" height="31" border="0" cellpadding="0"
							cellspacing="0" class="left_topbg" id="table2">
							<tr>
								<td height="31">
									<div class="titlebt">
										欢迎界面
									</div>
								</td>
							</tr>
						</table>
					</td>
					<td width="16" valign="top" background="images/mail_rightbg.gif">
						<img src="images/nav-right-bg.gif" width="16" height="29" />
					</td>
				</tr>
				<tr>
					<td valign="middle" background="images/mail_leftbg.gif">
						&nbsp;
					</td>
					<td valign="top" bgcolor="#F7F8F9">
						<table width="98%" border="0" align="center" cellpadding="0"
							cellspacing="0">
							<tr>
								<td colspan="2" valign="top">
									&nbsp;
								</td>
								<td>
									&nbsp;
								</td>
								<td valign="top">
									&nbsp;
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top">
									<span class="left_bt">感谢您进入国家助学贷款管理系统</span>
									<br>
									<br>
									<span class="left_txt">&nbsp;<img src="images/ts.gif"
											width="16" height="16" /> </span>
									<table width="100%" height="350" border="0" cellpadding="0"
										cellspacing="0" class="line_table">
										<tr>
											<td width="7%" height="27"
												background="images/news-title-bg.gif">
												<img src="images/news-title-bg.gif" width="2" height="27">
											</td>
										</tr>
										<tr>
											<td width="90%" colspan="2">
												<span> 一、欢迎<font style="color: red;">${session.status}</font>&nbsp;&nbsp;&nbsp;
													<b style="color: red;">${session.userName}</b>
													&nbsp;&nbsp;&nbsp;进入国家开发银行助学贷款信息管理系统。<br> <br>
													二、为了您的信息安全，初次登录用户请【<b>修改登录密码</b>】。<br> <br>
													三、必须在指定的时间内才能申请助学贷款。<br> <br>
													四、在申请助学贷款过程中遇到填写资料问题，请与县资助中心贷款经办人联系。<br> <br>
													五、。。。。。<br> <br> 六、如果您的个人信息发生变化时，请及时在【<b>个人信息</b>】中更新。<br>
													<br> </span>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top">

								</td>
								<td>
									&nbsp;
								</td>
							</tr>
							<tr>
								<td height="20" colspan="4">
									<table width="100%" height="1" border="0" cellpadding="0"
										cellspacing="0" bgcolor="#CCCCCC">
										<tr>
											<td></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td width="2%">
									&nbsp;
								</td>
								<td width="51%" class="left_txt">
									<img src="images/icon-mail2.gif" width="16" height="11">
									客户服务邮箱：850058280@qq.com
									<br>
									<img src="images/icon-phone.gif" width="17" height="14">
									官方网站：http://www.850058280@qq.com
								</td>
							</tr>
						</table>
					</td>
					<td background="images/mail_rightbg.gif">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td valign="bottom" background="images/mail_leftbg.gif">
						<img src="images/buttom_left2.gif" width="17" height="17" />
					</td>
					<td background="images/buttom_bgs.gif">
						<img src="images/buttom_bgs.gif" width="17" height="17">
					</td>
					<td valign="bottom" background="images/mail_rightbg.gif">
						<img src="images/buttom_right2.gif" width="16" height="17" />
					</td>
				</tr>
			</table>
		</body>
</html>