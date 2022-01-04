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
		<title>查询学生贷款信息</title>
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
				贷款管理 &gt; 查询贷款信息
			</label>
		</div>
		<form method="post" action="loan_searchLoan">
			<table border="1" align="center" cellpadding="0" cellspacing="0"
				class="tableBorder2" style="padding-left: 5px;">
				<tr align="center">
					<td height="27" colspan="4" class="TableTitle1">
						学生贷款信息查询
					</td>
				</tr>
				<tr>
					<td height="27" align="center" width="120">
						贷款编号:
					</td>
					<td height="27" align="center">
						<input type="text" name="loan.loanId">
					</td>
					<td height="27" align="center" width="120">
						姓名:
					</td>
					<td height="27" align="center">
						<input type="text" name="loan.stuName">
					</td>
				</tr>
				<tr>
					<td height="27" align="center" width="120">
						学号:
					</td>
					<td height="27" align="center">
						<input type="text" name="loan.student.stuId">
					</td>
					<td height="27" align="center" width="120">
						学校名称:
					</td>
					<td height="27" align="center">
						<input type="text" name="loan.schoolName">
					</td>
				</tr>
				<tr>
					<td height="20" colspan="4" align="center">
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
				width="90%">
				<tr>
					<th>
						贷款编号
					</th>
					<th>
						贷款金额
					</th>
					<th>
						学号
					</th>
					<th>
						姓名
					</th>
					<th>
						性别
					</th>
					<th>
						学历
					</th>
					<th>
						学校
					</th>
					<th>
						专业
					</th>
					<th>
						贷款时间
					</th>
					<th>
						家庭住址
					</th>
					<th>
						备注
					</th>
				</tr>
				<s:iterator value="loanList">
					<tr>
						<td>
							<s:property value="loanId" />
						</td>
						<td>
							<s:property value="loanAccount" />
						</td>
						<td>
							<s:property value="student.stuId" />
						</td>
						<td>
							<s:property value="stuName" />
						</td>
						<td>
							<s:property value="stuSex" />
						</td>
						<td>
							<s:property value="education" />
						</td>
						<td>
							<s:property value="schoolName" />
						</td>
						<td>
							<s:property value="major" />
						</td>
						<td>
							<s:property value="applyLoanTime" />
						</td>
						<td>
							<s:property value="address" />
						</td>
						<td>
							<s:property value="remark" />
						</td>
					</tr>
				</s:iterator>
			</table>
		</div>
	</body>
</html>