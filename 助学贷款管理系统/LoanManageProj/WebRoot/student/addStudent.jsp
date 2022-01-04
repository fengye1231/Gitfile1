<%@ page language="java" contentType="text/html; charset=utf-8"%>
<%
	request.setCharacterEncoding("utf-8");
	response.setCharacterEncoding("utf-8");
%>
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
		<title>添加学生信息</title>
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
				学生信息管理 &gt; 增加学生信息
			</label>
		</div>
		<form method="post" action="student_addStu">
			<table width="80%" border="1" align="center" cellpadding="0"
				cellspacing="0" class="tableBorder2" style="padding-left: 5px;">
				<tr align="center">
					<td height="40" colspan="2" class="TableTitle1">
						添加个人信息
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						用户编号:
					</td>
					<td width="210">
						<input type="text" name="addStudent.user.userId"
							style="width: 300px;" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						学号:
					</td>
					<td width="210">
						<input type="text" name="addStudent.stuId" style="width: 300px;" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						姓名:
					</td>
					<td width="210">
						<input type="text" name="addStudent.stuName" style="width: 300px;" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						<label for="m">
							性别:
						</label>
					</td>
					<td width="210">
						<input type="radio" name="addStudent.stuSex" value="男"
							checked="checked" />
						男
						<input type="radio" name="addStudent.stuSex" value="女" />
						女
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						身份证号:
					</td>
					<td width="210">
						<input type="text" name="addStudent.stuIdentity" id="stuIdentity"
							onblur="isIdCardNo()" style="width: 300px;" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						入学日期:
					</td>
					<td width="210">
						<input type="text" name="addStudent.enterSchoolTime"
							style="width: 300px;" id="txtDate" onblur="isDate()" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						民族:
					</td>
					<td width="210">
						<input type="text" name="addStudent.stuNation"
							style="width: 300px;" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						政治面貌:
					</td>
					<td width="231">
						<input type="text" name="addStudent.stuPolitic"
							style="width: 300px;" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						籍贯:
					</td>
					<td width="210">
						<input type="text" name="addStudent.stuNative"
							style="width: 300px;" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						学院:
					</td>
					<td>
						<select size="1" name="addStudent.academy" style="width: 300px;">
							<option value="计算机科学与技术学院" selected="selected">
								计算机科学与技术学院
							</option>
							<option value="外国语学院">
								外国语学院
							</option>
							<option value="化学与生命学院">
								化学与生命学院
							</option>
							<option value="电子与信息工程学院">
								电子与信息工程学院
							</option>
							<option value="生物医学工程学院">
								生物医学工程学院
							</option>
							<option value="数学与统计学院">
								数学与统计学院
							</option>
							<option value="艺术学院">
								艺术学院
							</option>
							<option value="教育学院">
								教育学院
							</option>
							<option value="体育学院">
								体育学院
							</option>
							<option value="经济与管理学院">
								经济与管理学院
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						班级:
					</td>
					<td width="210">
						<input type="text" name="addStudent.classes" style="width: 300px;" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						专业:
					</td>
					<td width="210">
						<input type="text" name="addStudent.major" style="width: 300px;" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						移动电话:
					</td>
					<td width="210">
						<input type="text" name="addStudent.stuMobileTel" id="MTel"
							onblur="checkTel()" style="width: 300px;" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						家庭电话:
					</td>
					<td width="210">
						<input type="text" name="addStudent.stuFamilyTel" id="FTel"
							onblur="checkTel()" style="width: 300px;" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr align="center">
					<td width="142" height="27">
						备注:
					</td>
					<td>
						<input type="text" name="addStudent.stuRemark"
							style="width: 500px;" />
					</td>
				</tr>
				<tr align="center">
					<td colspan="2">
						<input type="submit" name="Submit" value="提交">
						&nbsp;&nbsp;
						<input type="reset" name="Submit2" value="重置">
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>
