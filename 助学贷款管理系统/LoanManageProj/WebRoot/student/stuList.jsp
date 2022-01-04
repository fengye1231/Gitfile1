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
		<title>显示贷款学生的信息</title>
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
				学生信息管理 &gt; 显示贷款学生的信息
			</label>
		</div>
		<form method="post" action="#">
			<table width="90%" border="1" align="center" cellpadding="0"
				cellspacing="0" class="tableBorder2" style="padding-left: 5px;"  id="datatable">
				<tr align="center">
					<td height="40" colspan="14" class="TableTitle1">
						显示贷款学生的信息
					</td>
				</tr>
				<tr style="">
					<th width="80">
						学号
					</th>
					<th width="80">
						姓名
					</th>
					<th width="80">
						性别
					</th>
					<th width="130">
						身份证号
					</th>
					<th width="130">
						入学日期
					</th>
					<th width="80">
						民族
					</th>
					<th width="130">
						政治面貌
					</th>
					<th width="80">
						籍贯
					</th>
					<th width="130">
						移动电话
					</th>
					<th width="130">
						家庭电话
					</th>
					<th width="130">
						学校名称
					</th>
					<th width="80">
						班级
					</th>
					<th width="80">
						专业
					</th>
					<th width="100">
						操作
					</th>
				</tr>
				<s:iterator value="studentList">
					<tr>
						<td>
							<s:property value="stuId" />
						</td>
						<td>
							<s:property value="stuName" />
						</td>
						<td>
							<s:property value="stuSex" />
						</td>
						<td>
							<s:property value="stuIdentity" />
						</td>
						<td>
							<s:property value="enterSchoolTime" />
						</td>
						<td>
							<s:property value="stuNation" />
						</td>
						<td>
							<s:property value="stuPolitic" />
						</td>
						<td>
							<s:property value="stuNative" />
						</td>
						<td>
							<s:property value="stuMobileTel" />
						</td>
						<td>
							<s:property value="stuFamilyTel" />
						</td>
						<td>
							<s:property value="academy" />
						</td>
						<td>
							<s:property value="classes" />
						</td>
						<td>
							<s:property value="major" />
						</td>
						<td align="center">
							<a
								href="student_updateInput?updateStudent.stuId=<s:property value="stuId"/>">修改</a>
							<a
								href="student_delStu?delStudent.stuId=<s:property value="stuId"/>">删除</a>
						</td>
					</tr>
				</s:iterator>
				<tr>
					<td colspan="14" align="center"></td>
				</tr>
			</table>
			<input type="button" value="导出到EXCEL" onclick="AutomateExcel()" />
		</form>
	</body>
</html>