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
		<base href="<%=basePath%>">
		<title>学生账户信息</title>
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<link rel="stylesheet" type="text/css" href="css/info.css">
	</head>
	<body>
		<div class="map">
			<label class="curr">
				&nbsp;当前位置
			</label>
			<label class="curr1">
				贷款管理 &gt; 学生账户信息
			</label>
		</div>
		<div>
			<form method="post" action="#">
				<table width="80%" border="0" align="center" cellpadding="0"
					cellspacing="0" class="tableBorder2" style="padding-left: 5px;">
					<tr align="center">
						<td height="40" colspan="7" class="TableTitle1">
							学生账户信息
						</td>
					</tr>
					<tr style="">
						<th width="80">
							账户编号
						</th>
						<th width="80">
							贷款编号
						</th>
						<th width="80">
							贷款金额
						</th>
						<th width="80">
							还款账号
						</th>
						<th width="80">
							还款方式
						</th>
						<th width="80">
							贷款余额
						</th>
						<th width="100">
							操作
						</th>
					</tr>
					<s:iterator value="singleAccount">
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
							<td align="center">
								<a
									href="account_updateMyInput?updateAccount.accountId=<s:property value="accountId"/>">修改</a>
							</td>
						</tr>
					</s:iterator>
				</table>
			</form>
		</div>
	</body>
</html>