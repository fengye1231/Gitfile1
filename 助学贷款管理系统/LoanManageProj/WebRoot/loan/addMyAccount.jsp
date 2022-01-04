<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>增加贷款账户信息</title>
		<base href="<%=basePath%>">
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<link rel="stylesheet" type="text/css" href="css/info.css">
		<script src="js/validate.js" type="text/javascript" charset="gb2312" language="javascript"  ></script>
	</head>
	<body>
		<div class="map">
			<label class="curr">
				&nbsp;当前位置：
			</label>
			<label class="curr1">
				贷款管理 &gt; 增加贷款账户信息
			</label>
		</div>
		<form method="post" action="account_addMyAccount">
			<table width="80%" border="1" align="center" cellpadding="0"
				cellspacing="0" class="tableBorder2" style="padding-left: 5px;">
				<tr align="center">
					<td height="40" colspan="2" class="TableTitle1">
						增加贷款账户信息
					</td>
				</tr>
				<tr style="">
					<td width="142" height="27">
						贷款编号:
					</td>
					<td width="231">
						<input type="text" name="addAccount.loan.loanId" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						贷款金额:
					</td>
					<td width="231">
						<input type="text" name="addAccount.loanAccount" id="LAccount" onblur="isRangeNumSpan()" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						还款账号:
					</td>
					<td width="231">
						<input type="text" name="addAccount.paymentAccount" id="Bpay" onblur="checkPay()" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						还款方式:
					</td>
					<td width="231">
						<input type="text" name="addAccount.paymentStyle" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						贷款余额:
					</td>
					<td width="231">
						<input type="text" name="addAccount.balance" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr align="center">
					<td height="40" colspan="2">
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
