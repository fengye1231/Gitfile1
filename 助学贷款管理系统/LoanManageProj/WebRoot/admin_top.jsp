<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%@ taglib prefix="s" uri="/struts-tags"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<title>管理页面</title>
		<base target="main">
		<link href="css/skin.css" rel="stylesheet" type="text/css">
		<script language=JavaScript>
function logout() {
	if (confirm("您确定要退出【助学贷款管理系统】吗？"))
		top.location = "out.jsp";
	return false;
}
</script>

		<script type="text/javascript">
function startTime() {
	var today = new Date()
	var week = new Array("星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六");
	var year = today.getYear()
	var month = today.getMonth() + 1
	var date = today.getDate()
	var day = today.getDay()
	var h = today.getHours()
	var m = today.getMinutes()
	var s = today.getSeconds()
	h = checkTime(h)
	m = checkTime(m)
	s = checkTime(s)
	document.getElementById('time').innerHTML = " " + year + "年" + month + "月"
			+ date + "日  " + week[day] + "  " + h + ":" + m + ":" + s + " "
	t = setTimeout('startTime()', 500)
}

function checkTime(i) {
	if (i < 10) {
		i = "0" + i
	}
	return i
}
</script>

	</head>
	<body leftmargin="0" topmargin="0" onload="startTime()">
		<table width="100%" height="64" border="0" cellpadding="0"
			cellspacing="0" class="admin_topbg">
			<tr>
				<td width="40%" height="64">
					<img src="images/log.jpg" width="262" height="64">
				</td>
				<td width="60%" valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="45%" id="time" style="color: white;"></td>
							<td width="30%" height="38" class="admin_txt">
								<font style="color: red;">${session.status}</font>&nbsp;&nbsp;&nbsp;
								<b style="color: red;">${session.userName}</b>
								&nbsp;&nbsp;&nbsp;您好,欢迎您进入助学贷款管理系统！
							</td>
							<td width="18%">
								<a href="#" target="_self" onClick="logout();"><img
										src="images/out.gif" alt="安全退出" width="46" height="20"
										border="0"> </a>
							</td>
							<td width="4%">
								&nbsp;
							</td>
						</tr>
						<tr>
							<td height="19" colspan="5">
								&nbsp;
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>