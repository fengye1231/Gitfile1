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
		<base href="<%=basePath%>">
		<title>查询学生信息</title>
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<link rel="stylesheet" type="text/css" href="css/info.css">
	</head>
	<body>
		<div class="map">
			<label class="curr">
				&nbsp;当前位置：
			</label>
			<label class="curr1">
				学生信息管理 &gt; 查询贷款学生信息
			</label>
		</div>
		<form name="form" method="post" action="student_findMyInfo">
			<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0"
				class="tableBorder2">
				<tr align="center">
					<td height="27" colspan="3" class="TableTitle1">
						学生信息查询
					</td>
				</tr>
				<tr>
					<td>
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td width="120">
									学生学号：
								</td>
								<td>
									<input type="text" name="student.stuId" />
								</td>
							</tr>
							<tr>
								<td width="120">
									学生姓名：
								</td>
								<td>
									<input type="text" name="student.stuName" />
								</td>
							</tr>
							<tr>
								<td width="120">
									身份证号：
								</td>
								<td>
									<input type="text" name="student.stuIdentity" />
								</td>
							</tr>
						</table>
					</td>
					<td>
						<input type="radio" name="student.stuSex" value="男">
						男 &nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="student.stuSex" value="女">
						女
					</td>
					<td>
						<select size="1" name="student.academy">
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
					<td height="20" colspan="3" align="center">
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
						学号
					</th>
					<th>
						姓名
					</th>
					<th>
						性别
					</th>
					<th>
						身份证号
					</th>
					<th>
						入学日期
					</th>
					<th>
						民族
					</th>
					<th>
						政治面貌
					</th>
					<th>
						籍贯
					</th>
					<th>
						移动电话
					</th>
					<th>
						家庭电话
					</th>
					<th>
						学院名称
					</th>
					<th>
						班级
					</th>
					<th>
						专业
					</th>
					<th>
						备注
					</th>
				</tr>
				<s:iterator value="myInfoList">
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
						<td>
							<s:property value="stuRemark" />
						</td>
					</tr>
				</s:iterator>
				<tr>
					<td colspan="14" align="right">
						<a
							href="student_updateInput?updateStudent.stuId=<s:property value="stuId"/>">修改个人信息</a>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>