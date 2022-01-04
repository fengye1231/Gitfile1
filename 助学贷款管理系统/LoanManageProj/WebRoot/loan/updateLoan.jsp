<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%
	String path = request.getContextPath();
	String basePath = request.getScheme() + "://"
			+ request.getServerName() + ":" + request.getServerPort()
			+ path + "/";
%>
<%@ taglib prefix="s" uri="/struts-tags"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>修改学生贷款信息</title>
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
				贷款管理 &gt; 修改学生贷款信息
			</label>
		</div>
		<form method="post" action="loan_updateLoan">
			<table width="80%" border="1" align="center" cellpadding="0"
				cellspacing="0" class="tableBorder2" style="padding-left: 5px;">
				<tr align="center">
					<td height="40" colspan="2" class="TableTitle1">
						修改学生贷款信息
					</td>
				</tr>
				<tr style="">
					<td width="142" height="27">
						贷款编号:
					</td>
					<td width="231">
						<input type="text" name="updateLoan.loanId"
							value="${updateLoan.loanId}" )" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						学生学号:
					</td>
					<td width="231">
						<input type="text" name="updateLoan.student.stuId"
							value="${updateLoan.student.stuId}" )" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						学生姓名:
					</td>
					<td width="231">
						<input type="text" name="updateLoan.stuName"
							value="${updateLoan.stuName}" )" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						学生性别:
					</td>
					<td width="231">
						<c:choose>
							<c:when test="${updateLoan.stuSex == '男'}">
								<input type="radio" checked="checked" value='男'
									name="updateLoan.stuSex" />男
									        <input type="radio" value='女' name="updateLoan.stuSex" />女
										</c:when>
							<c:when test="${updateLoan.stuSex == '女'}">
								<input type="radio" value='男' name="updateLoan.stuSex" />男
									        <input type="radio" checked="checked" value='女'
									name="updateLoan.stuSex" />女
										</c:when>
						</c:choose>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						学生学历:
					</td>
					<td width="231">
						<input type="text" name="updateLoan.education"
							value="${updateLoan.education}" )" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						学校名称:
					</td>
					<td width="231">
						<input type="text" name="updateLoan.schoolName"
							value="${updateLoan.schoolName}" )" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						专业名称:
					</td>
					<td width="231">
						<input type="text" name="updateLoan.major"
							value="${updateLoan.major}" )" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						贷款金额:
					</td>
					<td width="231">
						<input type="text" name="updateLoan.loanAccount"
							value="${updateLoan.loanAccount}" )" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						家庭住址:
					</td>
					<td width="231">
						<input type="text" name="updateLoan.address"
							value="${updateLoan.address}" )" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						申请贷款时间:
					</td>
					<td width="231">
						<input type="text" name="updateLoan.applyLoanTime"
							value="${updateLoan.applyLoanTime}" )" style="width: 300px;" />
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
