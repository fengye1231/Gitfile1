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
		<title>申请提前还款</title>
		<base href="<%=basePath%>">
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<link rel="stylesheet" type="text/css" href="css/info.css">
		<script src="js/validate.js" type="text/javascript" charset="gb2312" language="javascript"  ></script>
		<script type="text/javascript">
var oWD = new ActiveXObject("Word.Application");
var oDC = oWD.Documents.Add("", 0, 1);
var oRange = oDC.Range(0, 1);
function word(id, way) {
	var sel = document.body.createTextRange();
	sel.moveToElementText(id);
	sel.select();
	sel.execCommand(way);
	oRange.Paste();
}

function test() {
	var table = document.getElementById("table1");
	var table_cells = table.rows[0].cells;
	var form_elements = document.getElementById("apply");
	word(table1, "Copy"); //调用word函数，将table1范围内容拷贝到word里面。
	for (i = 0; i < table_cells.length; i++) {
		oRange = oDC.Range(oRange.End - 1, oRange.End); //设定位置依次由上往下、从左往右
		var sel = document.body.createTextRange();
		sel.moveToElementText(table_cells[i]); //将单元格内容复制到word
		sel.select();
		sel.execCommand("Copy");
		sel.moveEnd("character"); 
		oRange.Paste();
		oRange = oDC.Range(oRange.End - 1, oRange.End);
	}
	oRange = oDC.Range(oRange.End - 1, oRange.End); //复制不同的内容，需要写这句表明复制的前后位置
	oWD.Application.Visible = true; 
}
</script>
	</head>
	<body>
		<div class="map">
			<label class="curr">
				&nbsp;当前位置：
			</label>
			<label class="curr1">
				贷款管理 &gt; 提前还款申请
			</label>
		</div>
		<form method="post" action="apply_addApply" id="apply">
			<table border="1" align="center" cellpadding="0" cellspacing="0"
				class="tableBorder2" style="padding-left: 5px;" id="table1">
				<tr align="center">
					<td height="40" colspan="4" class="TableTitle1">
						提前还款申请表
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						借款人:
					</td>
					<td width="231">
						<input type="text" name="addApply.stuName" />
						<span class="Redfont">*</span>
					</td>
					<td width="142" height="27">
						身份证号:
					</td>
					<td width="231">
						<input type="text" name="addApply.stuIdentity" id="stuIdentity" onblur="isIdCardNo()" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						移动电话:
					</td>
					<td width="231">
						<input type="text" name="addApply.stuMobileTel" id="MTel" onblur="checkTel()" />
						<span class="Redfont">*</span>
					</td>
					<td width="142" height="27">
						家庭电话:
					</td>
					<td width="231">
						<input type="text" name="addApply.stuFamilyTel" id="MTel" onblur="checkTel()" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						贷款合同编号:
					</td>
					<td width="231">
						<input type="text" name="addApply.loan.loanId" />
						<span class="Redfont">*</span>
					</td>
					<td width="142" height="27">
						还款账号:
					</td>
					<td width="231">
						<input type="text" name="addApply.paymentAccount" id="Bpay" onblur="checkPay()" />
						<span class="Redfont">*</span>
					</td>
				</tr>
				<tr>
					<td width="142" height="27">
						合同约定还款方式:
					</td>
					<td colspan="3" align="center">
						<input type="checkbox" name="style" checked="checked" />
						分期还款
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="style" />
						一次性还款
					</td>
				</tr>
				<tr>
					<td>
						还款方式
					</td>
					<td colspan="3" align="center">
						<input type="checkbox" name="addApply.paymentStyle" value="分期还款" />
						分期还款
						<input type="text" name="paymentMoney" value="6000" />
						元
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="addApply.paymentStyle"
							checked="checked" value="一次还清" />
						一次还清
					</td>
				</tr>
				<tr>
					<td>
						提前还款说明
					</td>
					<td colspan="3" align="center">
						<b>贷款有拖欠者，待拖欠封款偿还后，方可办理提前还款业务。</b>
					</td>
				</tr>
				<tr>
					<td colspan="4" align="left">
						本人/本单位在此确认：
						<ul>
							1、承认此《申请表》作为向银行贷款提前还款的依据。
						</ul>
						<ul>
							2、在约定的提前还款日期，将所还贷款缴存银行。
						</ul>
						<ul>
							3、该申请一旦发生即不可撤销，由此产生的所有后果有本人/本单位负责。
						</ul>
						<center>
							<ul>
								申请人（签字/盖章）:&nbsp;&nbsp;&nbsp;&nbsp;
							</ul>
							<ul>
								申请日期：20&nbsp;&nbsp;年&nbsp;&nbsp;月&nbsp;&nbsp;日
							</ul>
						</center>
					</td>
				</tr>
				<tr align="right">
					<td height="22" colspan="4">
						<input type="hidden" name="addApply.approval.approvalId" value="1" />
					</td>
				</tr>
			</table>
			<table border="1" align="center" cellpadding="0" cellspacing="0"
				class="tableBorder2" style="padding-left: 5px;">
				<tr align="center">
					<td height="22" colspan="4">
						<input type="submit" name="Submit" value="提交">
						&nbsp;&nbsp;
						<input type="reset" name="Submit2" value="重置">
						&nbsp;&nbsp;
						<input type="button" onclick="javascript:test();" value="导出到WORD">
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>