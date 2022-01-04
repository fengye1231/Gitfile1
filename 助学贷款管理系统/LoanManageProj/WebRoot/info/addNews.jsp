<%@ page language="java" contentType="text/html; charset=utf-8"%>
<%request.setCharacterEncoding("utf-8");
response.setCharacterEncoding("utf-8"); %>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://" + request.getServerName() + ":" + 
		request.getServerPort() + path + "/";
 %>
<%@ taglib  prefix="s" uri="/struts-tags" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<base href="<%=basePath%>">
		<title>添加新闻</title>
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<link rel="stylesheet" type="text/css" href="css/info.css">
	</head>
	<body onload="clockon(bgclock)">
		<div class="map">
			<label class="curr">
				&nbsp;当前位置：
			</label>
			<label class="curr1">
				常规信息管理 &gt; 添加新闻
			</label>
		</div>
		<form  method="post" action="news_addNews">
			<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0"
				class="tableBorder2" style="padding-left: 5px;">
				<tr align="center">
					<td height="40" colspan="2" class="TableTitle1">
						添加新闻
					</td>
				</tr>
				<tr>
					<td width="100" height="27">
						新闻标题:
					</td>
					<td width="100">
						<input type="text" name="addNews.ntitle" /> 
					</td>
				</tr>
				<tr>
					<td width="100" height="27">
						发布时间:
					</td>
					<td width="100">
						<input type="text" name="addNews.ntime" />
					</td>
				</tr>
				<tr>
					<td width="100" height="27">
						出处:
					</td>
					<td width="100">
						<input type="text" name="addNews.nfromto" />
					</td>
				</tr>
				<tr align="center">
					<td height="22" colspan="2">
						<input type="submit" name="Submit" value="提交">
						&nbsp;&nbsp;
						<input type="reset" name="Submit2" value="重置">
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"></td>
				</tr>
			</table>
		</form>
	</body>
</html>
