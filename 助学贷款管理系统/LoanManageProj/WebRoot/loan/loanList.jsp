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
		<title>显示学生贷款信息</title>
		<base href="<%=basePath%>">
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<link rel="stylesheet" type="text/css" href="css/info.css">
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
				&nbsp;当前位置
			</label>
			<label class="curr1">
				贷款管理 &gt; 显示学生贷款信息
			</label>
		</div>
		<form method="post" action="#">
			<table width="90%" border="1" align="center" cellpadding="0"
				cellspacing="0" class="tableBorder2" style="padding-left: 5px;" id="datatable">
				<tr align="center">
					<td height="40" colspan="11" class="TableTitle1">
						显示学生贷款信息
					</td>
				</tr>
				<tr style="">
					<th width="80">
						贷款编号
					</th>
					<th width="80">
						学号
					</th>
					<th width="80">
						姓名
					</th>
					<th width="80">
						性别
					</th>
					<th width="80">
						学历
					</th>
					<th width="80">
						专业
					</th>
					<th width="80">
						学校名称
					</th>
					<th width="80">
						贷款金额
					</th>
					<th width="80">
						家庭住址
					</th>
					<th width="80">
						申贷时间
					</th>
					<th width="100">
						操作
					</th>
				</tr>
				<s:iterator value="loanList">
					<tr>
						<td>
							<s:property value="loanId" />
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
							<s:property value="major" />
						</td>
						<td>
							<s:property value="schoolName" />
						</td>
						<td>
							<s:property value="loanAccount" />
						</td>
						<td>
							<s:property value="address" />
						</td>
						<td>
							<s:property value="applyLoanTime" />
						</td>
						<td align="center">
							<a
								href="loan_updateInput?updateLoan.loanId=<s:property value="loanId"/>">修改</a>
							<a
								href="loan_delLoan?delLoan.loanId=<s:property value="loanId"/>">删除</a>
						</td>
					</tr>
				</s:iterator>
				<tr>
					<td colspan="11" align="center"></td>
				</tr>
			</table>
			<input type="button" value="导出到EXCEL" onclick="AutomateExcel()" />
		</form>
	</body>
</html>