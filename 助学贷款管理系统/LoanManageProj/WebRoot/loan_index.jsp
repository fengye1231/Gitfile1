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
		<title>贷款小组管理中心</title>
		<meta http-equiv='refresh' content='3;url=login.jsp'>
	</head>
	<body>
		<b>贷款小组模块正在维护中。。。</b>
	</body>
</html>
