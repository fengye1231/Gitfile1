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
		<title>显示所有的用户信息</title>
		<link rel="stylesheet" type="text/css" href="css/info.css">
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<script type="text/javascript">
function AutomateExcel() {
	var elTable = document.getElementById("datatable"); //要导出的table id。
	var oRangeRef = document.body.createTextRange();
	oRangeRef.moveToElementText(elTable);
	oRangeRef.execCommand("Copy");
	var appExcel = new ActiveXObject("Excel.Application");
	appExcel.Workbooks.Add().Worksheets.Item(1).Paste();
	appExcel.Visible = true;
	appExcel = null;

}
</script>
	</head>
	<body>
		<div class="map">
			<label class="curr">
				&nbsp;当前位置：
			</label>
			<label class="curr1">
				常规信息管理 &gt; 显示所有的用户信息
			</label>
		</div>
		<div>
			<form method="post" action="#">
				<table width="80%" border="1" align="center" cellpadding="0"
					cellspacing="0" class="tableBorder2" style="padding-left: 5px;">
					<tr align="center">
						<td height="40" colspan="5" class="TableTitle1">
							所有用户信息
						</td>
					</tr>
					<tr style="">
						<th width="80">
							用户ID号
						</th>
						<th width="80">
							用户名
						</th>
						<th width="80">
							用户身份
						</th>
						<th width="120">
							备注
						</th>
						<th width="80">
							操作
						</th>
					</tr>

					<s:iterator value="userList">
						<tr>
							<td>
								<s:property value="userId" />
							</td>
							<td>
								<s:property value="userName" />
							</td>
							<td>
								<s:property value="status" />
							</td>
							<td>
								<s:property value="remark" />
							</td>
							<td align="center">
								<a
									href="user_delUser?delUser.userId=<s:property value="userId"/>">删除</a>
							</td>
						</tr>
					</s:iterator>
					<tr>
						<td colspan="5" align="center"></td>
					</tr>
				</table>
				<input type="button" value="导出到EXCEL" onclick="AutomateExcel()" />
			</form>
		</div>
	</body>
</html>