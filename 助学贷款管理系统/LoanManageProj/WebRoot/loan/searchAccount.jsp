<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<%@ taglib prefix="s" uri="/struts-tags"%>
<html>
	<head>
		<title>查询学生账户信息</title>
		<base href="<%=basePath%>">
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<link rel="stylesheet" type="text/css" href="css/info.css">
	</head>
	<body>
		<div class="map">
			<label class="curr">
				&nbsp;当前位置：
			</label>
			<label class="curr1">
				贷款管理 &gt; 查询学生账户信息
			</label>
		</div>
		<form method="post" action="account_searchAccount">
			<table border="1" align="center" cellpadding="0" cellspacing="0"
				class="tableBorder2" style="padding-left: 5px;">
				<tr align="center">
					<td height="27" colspan="3" class="TableTitle1">
						学生账户信息查询
					</td>
				</tr>
				<tr>
					<td height="27" align="center" width="150">
						贷款编号:
					</td>
					<td height="27" align="center" width="150">
						<input type="text" name="account.loan.loanId">
					</td>
				</tr>
				<tr>
					<td height="20" colspan="3" align="center">
						&nbsp;
					</td>
				</tr>
			</table>
			<p>
				<input type="image" src="images/search.gif"
					onclick="javascript:submit();">
				<input type="hidden" value="submit" name="submit">
			</p>			
		</form>
		<div>
			<table border="1" align="center" cellpadding="0" cellspacing="0"
				width="80%">
				<tr>
					<th>
						账户编号
					</th>
					<th>
						贷款编号
					</th>
					<th>
						贷款金额
					</th>
					<th>
						还款账号
					</th>
					<th>
						还款方式
					</th>
					<th>
						贷款余额
					</th>
				</tr>
				<s:iterator value="accountList">
					<tr>
						<td>
							<s:property value="accountId" />
						</td>
						<td>
							<s:property value="loan.loanId" />
						</td>
						<td>
							<s:property value="loanAccount" />
						</td>
						<td>
							<s:property value="paymentAccount" />
						</td>
						<td>
							<s:property value="paymentStyle" />
						</td>
						<td>
							<s:property value="balance" />
						</td>
					</tr>
				</s:iterator>
			</table>
		</div>
	</body>
</html>