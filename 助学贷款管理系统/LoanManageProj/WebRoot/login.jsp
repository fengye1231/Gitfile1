<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>
<%@ taglib prefix="s" uri="/struts-tags"%>
<html>
	<head>
		<base href="<%=basePath%>">
		<title>用户登陆</title>
		<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #1D3647;
}
</style>
		<link href="css/skin.css" rel="stylesheet" type="text/css">
		<script type="text/javascript">
function register() {
	window.location = "user/registerUser.jsp";
}
</script>
	</head>
	<body>
		<table width="100%" height="166" border="0" cellpadding="0"
			cellspacing="0">
			<tr>
				<td height="42" valign="top">
					<table width="100%" height="42" border="0" cellpadding="0"
						cellspacing="0" class="login_top_bg">
						<tr>
							<td width="1%" height="21">
								&nbsp;
							</td>
							<td height="42">
								&nbsp;
							</td>
							<td width="17%">
								&nbsp;
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="top">
					<table width="100%" height="532" border="0" cellpadding="0"
						cellspacing="0" class="login_bg">
						<tr>
							<td width="49%" align="right">
								<table width="91%" height="532" border="0" cellpadding="0"
									cellspacing="0" class="login_bg2">
									<tr>
										<td height="138" valign="top">
											<table width="89%" height="427" border="0" cellpadding="0"
												cellspacing="0">
												<tr>
													<td height="149">
														&nbsp;
													</td>
												</tr>
												<tr>
													<td height="80" align="right" valign="top">
														<img src="images/logo.png" width="279" height="68">
													</td>
												</tr>
												<tr>
													<td height="198" align="right" valign="top">
														<table width="100%" border="0" cellpadding="0"
															cellspacing="0">
															<tr>
																<td width="35%">
																	&nbsp;
																</td>
																<td height="25" colspan="2" class="left_txt">
																	<p>
																		<b>助学贷款介绍...</b>
																	</p>
																</td>
															</tr>
															<tr>
																<td width="35%">
																	&nbsp;
																</td>
																<td height="25" colspan="2" class="left_txt">
																	<p>
																		1- 国家助学贷款是由...专门帮助高校贫困家庭学生的银行贷款
																	</p>
																</td>
															</tr>
															<tr>
																<td>
																	&nbsp;
																</td>
																<td height="25" colspan="2" class="left_txt">
																	<p>
																		2- 借款学生...需要承诺按期还款，并承担相关法律责任
																	</p>
																</td>
															</tr>
															<tr>
																<td>
																	&nbsp;
																</td>
																<td height="25" colspan="2" class="left_txt">
																	<p>
																		3- 借款学生通过...弥补在校学习期间学费、住宿费和生活费，毕业后分期偿还
																	</p>
																</td>
															</tr>
															<tr>
																<td>
																	&nbsp;
																</td>
																<td width="30%" height="40">
																	<img src="images/icon-demo.gif" width="16" height="16">
																	<a href="#" target="_blank" class="left_txt3"> 使用说明</a>
																</td>
																<td width="35%">
																	<img src="images/icon-login-seaver.gif" width="16"
																		height="16">
																	<a href="#" class="left_txt3"> 在线客服</a>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>

								</table>
							</td>
							<td width="1%">
								&nbsp;
							</td>
							<td width="50%" valign="bottom">
								<table width="100%" height="59" border="0" align="center"
									cellpadding="0" cellspacing="0">
									<tr>
										<td width="4%">
											&nbsp;
										</td>
										<td width="96%" height="38">
											<span class="login_txt_bt">登陆助学贷款系统</span>
										</td>
									</tr>
									<tr>
										<td>
											&nbsp;
										</td>
										<td height="21">
											<table cellSpacing="0" cellPadding="0" width="100%"
												border="0" id="table211" height="328">
												<tr>
													<td height="164" colspan="2" align="middle">
														<form action="<%=request.getContextPath()%>/user_login"
															method="post">
															<table cellSpacing="0" cellPadding="0" width="100%"
																border="0" height="143" id="table212">
																<tr>
																	<td width="13%" height="38" class="top_hui_text">
																		<span class="login_txt">用户名：&nbsp;&nbsp; </span>
																	</td>
																	<td height="38" colspan="2" class="top_hui_text">
																		<input name="user.userName" class="editbox4" value=""
																			size="20">
																	</td>
																</tr>
																<tr>
																	<td width="13%" height="35" class="top_hui_text">
																		<span class="login_txt"> 密 码： &nbsp;&nbsp; </span>
																	</td>
																	<td height="38" colspan="2" class="top_hui_text">
																		<input class="editbox4" type="password" size="20"
																			name="user.userPwd">
																		<img src="images/luck.gif" width="19" height="18">
																	</td>
																</tr>
																<tr>
																	<td width="20" height="35">
																		<input name="Submit" type="submit" class="button"
																			value="登 陆">
																	</td>
																	<td width="20" height="35">
																		<input name="reset" type="reset" class="button"
																			value="重置">
																	</td>
																</tr>
																<tr>
																	<td>
																		&nbsp;
																	</td>
																</tr>
																<tr>
																	<td>
																		&nbsp;
																	</td>
																</tr>
																<tr>
																	<td colspan="2">
																		<SPAN style="color: red;">若您是学生，并且是第一次进入该系统的，请先注册用户。</SPAN>
																	</td>
																</tr>
																<tr>
																	<td width="20" height="35">
																		<input name="button" type="button" class="button"
																			value="注册新用户" onclick="register()">
																	</td>
																</tr>
															</table>
															<br>
														</form>
													</td>
												</tr>
												<tr>
													<td width="433" height="164" align="right" valign="bottom">
														<img src="images/login-wel.gif" width="242" height="138">
													</td>
													<td width="57" align="right" valign="bottom">
														&nbsp;
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td height="20">
					<table width="100%" border="0" cellspacing="0" cellpadding="0"
						class="login-buttom-bg">
						<tr>
							<td align="center">
								<span class="login-buttom-txt">Copyright &copy;
									2012-02-27 850085280@qq.com</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>