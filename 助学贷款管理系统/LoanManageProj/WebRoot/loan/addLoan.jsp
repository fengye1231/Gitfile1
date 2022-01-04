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
		<title>增加学生贷款信息</title>
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
				贷款管理 &gt; 增加学生贷款信息
			</label>
		</div>
		<form method="post" action="loan_addLoan">
			<table width="80%" border="1" align="center" cellpadding="0"
				cellspacing="0" class="tableBorder2" style="padding-left: 5px;">
				<tr align="center">
					<td height="40" colspan="3" class="TableTitle1">
						增加学生贷款信息
					</td>
				</tr>
				<tr style="">
					<td width="142" height="27">
						贷款编号:
					</td>
					<td width="231">
						<input type="text" name="addLoan.loanId" />
						<span class="Redfont">*</span>
					</td>
					<td rowspan="10" width="227" valign="top" class="Redfont">
						注意:
						<ul>
							一:带*号项是必填项!
						</ul>
						<ul>
							二:贷款时间格式必须为：2012-02-20
						</ul>
						<ul>
							三:贷款金额不能低于3000
						</ul>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						学生学号:
					</td>
					<td width="231">
						<input type="text" name="addLoan.student.stuId" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						学生姓名:
					</td>
					<td width="231">
						<input type="text" name="addLoan.stuName" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						学生性别:
					</td>
					<td width="231">
						<input type="radio" name="addLoan.stuSex" value="男"
							checked="checked" />
						男
						<input type="radio" name="addLoan.stuSex" value="女" />
						女
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						学生学历:
					</td>
					<td width="231">
						<input type="text" name="addLoan.education" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						学校名称:
					</td>
					<td width="231">
						<input type="text" name="addLoan.schoolName" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						专业名称:
					</td>
					<td width="231">
						<input type="text" name="addLoan.major" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						贷款金额:
					</td>
					<td width="231">
						<input type="text" name="addLoan.loanAccount" id="LAccount" onblur="isRangeNumSpan()" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						家庭住址:
					</td>
					<td width="231">
						<input type="text" name="addLoan.address" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						申请贷款时间:
					</td>
					<td width="231">
						<input type="text" name="addLoan.applyLoanTime" id="txtDate" onblur="isDate()" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr align="center">
					<td height="22" colspan="3">
						<input type="submit" name="Submit" value="提交">
						&nbsp;&nbsp;
						<input type="reset" name="Submit2" value="重置">
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center"></td>
				</tr>
			</table>
		</form>
	</body>
</html>
