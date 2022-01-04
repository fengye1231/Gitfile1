<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%>

<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<base href="<%=basePath%>">
		<title>注册用户</title>
		<meta http-equiv='refresh' content='3;url=login.jsp'>
	</head>
	<body>
		<b>新用户注册成功，请稍后。。。</b>
	</body>
</html>
