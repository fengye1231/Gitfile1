<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>
<%@ taglib prefix="s" uri="/struts-tags"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<base href="<%=basePath%>">
		<title>显示新闻</title>
		<link rel="stylesheet" type="text/css" href="css/info.css">
		<link rel="stylesheet" type="text/css" href="css/css.css">
	</head>
	<body>
		<div class="map">
			<label class="curr">
				&nbsp;当前位置：
			</label>
			<label class="curr1">
				常规信息管理 &gt; 新闻管理中心
			</label>
		</div>
		<div>
			<form method="post" action="#">
				<table width="80%" border="1" align="center" cellpadding="0"
					cellspacing="0" class="tableBorder2" style="padding-left: 5px;">
					<tr align="center">
						<td height="40" colspan="5" class="TableTitle1">
							新闻信息列表
						</td>
					</tr>
					<tr style="">
						<th height="27" width="150">
							新闻编号
						</th>
						<th width="150">
							新闻标题
						</th>
						<th width="150">
							发布时间
						</th>
						<th width="150">
							摘自
						</th>
						<th  width="150">
							操作
						</th>
					</tr>

					<s:iterator value="newsList">
						<tr>
							<td>
								<s:property value="nid" />
							</td>
							<td>
								<s:property value="ntitle" />
							</td>
							<td>
								<s:property value="ntime" />
							</td>
							<td>
								<s:property value="nfromto" />
							</td>
							<td align="center">
								<a
									href="news_delNews?delNews.nid=<s:property value="nid"/>">删除</a>
							</td>
						</tr>
					</s:iterator>
					<tr>
						<td colspan="5" align="center"></td>
					</tr>
					<tr align="center">
						<td height="27" colspan="5">
							<a href="info/addNews.jsp" target="main">添加新闻</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>