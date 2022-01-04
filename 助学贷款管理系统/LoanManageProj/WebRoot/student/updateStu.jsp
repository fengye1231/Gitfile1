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
		<base href="<%=basePath%>">
		<title>修改学生信息</title>
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<link rel="stylesheet" type="text/css" href="css/info.css">
	</head>
	<body>
		<div class="map">
			<label class="curr">
				&nbsp;当前位置：
			</label>
			<label class="curr1">
				学生信息管理 &gt; 修改学生信息
			</label>
		</div>
		<form method="post" action="student_updateStu">
			<table width="80%" border="1" align="center" cellpadding="0"
				cellspacing="0" class="tableBorder2" style="padding-left: 5px;">
				<tr align="center">
					<td height="40" colspan="2" class="TableTitle1">
						修改个人信息
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						用户编号:
					</td>
					<td width="231">
						<input type="text" name="updateStudent.user.userId" value="${updateStudent.user.userId}" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						学号:
					</td>
					<td width="231">
						<input type="text" name="updateStudent.stuId"
							value="${updateStudent.stuId}" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						姓名:
					</td>
					<td width="231">
						<input type="text" name="updateStudent.stuName"
							value="${updateStudent.stuName}" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						性别:
					</td>
					<td width="231">
						<c:choose>
							<c:when test="${updateStudent.stuSex == '男'}">
								<input type="radio" checked="checked" value='男'
									name="updateStudent.stuSex" />男
									        <input type="radio" value='女' name="updateStudent.stuSex" />女
										</c:when>
							<c:when test="${updateStudent.stuSex == '女'}">
								<input type="radio" value='男' name="updateStudent.stuSex" />男
									        <input type="radio" checked="checked" value='女'
									name="updateStudent.stuSex" />女
										</c:when>
						</c:choose>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						身份证号:
					</td>
					<td width="231">
						<input type="text" name="updateStudent.stuIdentity"
							value="${updateStudent.stuIdentity}" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						入学日期:
					</td>
					<td width="231">
						<input type="text" name="updateStudent.enterSchoolTime"
							value="${updateStudent.enterSchoolTime}" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						民族:
					</td>
					<td width="231">
						<input type="text" name="updateStudent.stuNation"
							value="${updateStudent.stuNation}" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						政治面貌:
					</td>
					<td width="231">
						<input type="text" name="updateStudent.stuPolitic"
							value="${updateStudent.stuPolitic}" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						籍贯:
					</td>
					<td width="231">
						<input type="text" name="updateStudent.stuNative"
							value="${updateStudent.stuNative}" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						移动电话:
					</td>
					<td width="231">
						<input type="text" name="updateStudent.stuMobileTel"
							value="${updateStudent.stuMobileTel}" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						家庭电话:
					</td>
					<td width="231">
						<input type="text" name="updateStudent.stuFamilyTel"
							value="${updateStudent.stuFamilyTel}" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						学院:
					</td>
					<td>
						<select size="1" name="updateStudent.academy"
							value="${updateStudent.academy}">
							<option value="计算机科学与技术学院">
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
					<td width="231">
						<input type="text" name="updateStudent.classes"
							value="${updateStudent.classes}" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						专业:
					</td>
					<td width="231">
						<input type="text" name="updateStudent.major"
							value="${updateStudent.major}" style="width: 300px;" />
					</td>
				</tr>
				<tr align="center">
					<td width="142" height="27">
						备注:
					</td>
					<td>
						<input type="text" name="updateStudent.stuRemark"
							value="${updateStudent.stuRemark}" style="width: 300px;" />
					</td>
				</tr>
				<tr>
					<td width="227" colspan="2" align="center">
						<input type="submit" name="Submit" value="修改">
						&nbsp;&nbsp;
						<input type="reset" name="Submit2" value="重置">
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>