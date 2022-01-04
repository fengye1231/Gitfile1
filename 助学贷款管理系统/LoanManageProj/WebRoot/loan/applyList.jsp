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
		<title>提前还款申请记录</title>
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
				贷款管理 &gt; 提前还款申请记录
			</label>
		</div>
		<div>
			<form method="post" action="#">
				<table width="90%" border="0" align="center" cellpadding="0"
					cellspacing="0" class="tableBorder2" style="padding-left: 5px;"  id="datatable">
					<tr align="center">
						<td height="40" colspan="11" class="TableTitle1">
							提前还款申请记录
						</td>
					</tr>
					<tr style="">
						<th width="100">
							申请编号
						</th>
						<th width="100">
							学生姓名
						</th>
						<th width="100">
							身份证号
						</th>
						<th width="100">
							移动电话
						</th>
						<th width="100">
							家庭电话
						</th>
						<th width="100">
							还款账号
						</th>
						<th width="100">
							还款方式
						</th>
						<th width="100">
							还款金额
						</th>
						<th width="100">
							贷款编号
						</th>
						<th width="100">
							审批状态
						</th>
						<th width="100">
							操作
						</th>
					</tr>
					<s:iterator value="applyList">
						<tr>
							<td>
								<s:property value="applyId" />
							</td>
							<td>
								<s:property value="stuName" />
							</td>
							<td>
								<s:property value="stuIdentity" />
							</td>
							<td>
								<s:property value="stuMobileTel" />
							</td>
							<td>
								<s:property value="stuFamilyTel" />
							</td>
							<td>
								<s:property value="paymentAccount" />
							</td>
							<td>
								<s:property value="paymentStyle" />
							</td>
							<td>
								<s:property value="paymentMoney" />
							</td>
							<td>
								<s:property value="loan.loanId" />
							</td>
							<td>
								<s:property value="approval.approvalId" />
							</td>
							<td align="center">
								<a
									href="apply_updateInput?updateApply.applyId=<s:property value="applyId"/>">修改</a>
								<a
									href="apply_delApply?delApply.applyId=<s:property value="applyId"/>">删除</a>
							</td>
						</tr>
					</s:iterator>
					<tr>
						<td colspan="11" align="right"></td>
					</tr>
				</table>
				<input type="button" value="导出到EXCEL" onclick="AutomateExcel()" />
			</form>
		</div>
	</body>
</html>