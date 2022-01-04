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
		<title>修改账户信息</title>
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<link rel="stylesheet" type="text/css" href="css/info.css">
	</head>
	<body>
		<div class="map">
			<label class="curr">
				&nbsp;当前位置：
			</label>
			<label class="curr1">
				贷款信息管理 &gt; 修改账户信息
			</label>
		</div>
		<form method="post" action="account_updateMyAccount">
			<table width="80%" border="1" align="center" cellpadding="0"
				cellspacing="0" class="tableBorder2" style="padding-left: 5px;">
				<tr align="center">
					<td height="40" colspan="2" class="TableTitle1">
						修改账户信息
					</td>
				</tr>
				<tr style="">
					<td width="142" height="27">
						账户ID号:
					</td>
					<td width="231">
						<input type="text" name="updateAccount.accountId"
							value="<%=request.getParameter("updateAccount.accountId")%>"
							style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						贷款编号:
					</td>
					<td width="231">
						<input type="text" name="updateAccount.loan.loanId"
							value="${updateAccount.loan.loanId}" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						贷款金额:
					</td>
					<td width="231">
						<input type="text" name="updateAccount.loanAccount"
							value="${updateAccount.loanAccount}" )" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						还款账号:
					</td>
					<td width="231">
						<input type="text" name="updateAccount.paymentAccount"
							value="${updateAccount.paymentAccount}" )" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						还款方式:
					</td>
					<td width="231">
						<input type="text" name="updateAccount.paymentStyle"
							value="${updateAccount.paymentStyle}" )" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						贷款余额:
					</td>
					<td width="231">
						<input type="text" name="updateAccount.balance"
							value="${updateAccount.balance}" )" style="width: 300px;" />
					</td>
				</tr>
				<tr align="center">
					<td height="22" colspan="2">
						<input type="submit" value="提交" />
						&nbsp;&nbsp;
						<input type="reset" value="重置" />
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"></td>
				</tr>
			</table>
		</form>
	</body>
</html>
