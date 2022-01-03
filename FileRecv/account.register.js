/**
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package js
 * @name account.register.js
 * @date 2011-12-15 18:48:18
 */
 
$(document).ready(function(){
	$('#email').bind('blur', CheckEmail);
	$('#phone').bind('blur', CheckPhone);
	$('#password').bind('blur', CheckPassword);
	$('#repassword').bind('blur', CheckRepassword);
	$('#zfpassword').bind('blur', CheckzfPassword);
	$('#rezfpassword').bind('blur', CheckzfRepassword);
	$('#addr_province').bind('blur', Checkprovince);
	$('#addr_city').bind('blur', Checkcity);
	$('#addr_address').bind('blur', Checkaddress);
	$('#addr_zip').bind('blur', Checkzip);
	$('#addr_name').bind('blur', Checkname);
	$('#addr_callphone').bind('blur', Checkcallphone);
	
	
	$('#password_nm').bind('blur', CheckPassword_nm);
	$('#repassword_nm').bind('blur', CheckRepassword_nm);
	$('#zfpassword_nm').bind('blur', CheckzfPassword_nm);
	$('#rezfpassword_nm').bind('blur', CheckRezfPassword_nm);
	$('#zjwords_nm').bind('blur', Checkzjwords_nm);

});

function Checkaddress()
{
	var addr_address= $('#addr_address').val();
	if(addr_address.replace(/[^\x00-\xff]/g,"**").length<5 || addr_address.length>30){
		reg_alert('addr_address', '街道地址必须在5位到30位！');
		return;
	}
		reg_success('addr_address', '可以使用！');
}
function Checkzip()
{
	var addr_zip= $('#addr_zip').val();
	if (addr_zip == '')
	{
		reg_alert('addr_zip', '请输入邮政编码！');
		return;
	}



	var zipRegExp = new RegExp(/^\d{6}$/);   
	if(!zipRegExp.test(addr_zip)){
		reg_alert('addr_zip', '不是有效的邮政编码！');
		return;
	}
		reg_success('addr_zip', '可以使用！');
}
function Checkname()
{
	var addr_name= $('#addr_name').val();
	if(addr_name.replace(/[^\x00-\xff]/g,"**").length<2 || addr_name.length>30){
		reg_alert('addr_name', '用户名最少2位！');
		return;
	}
		reg_success('addr_name', '可以使用！');
}
function Checkcallphone()
{
	var addr_callphone= $('#addr_callphone').val();
	if (addr_callphone == '')
	{
		reg_alert('addr_callphone', '请输入电话号码！');
		return; 
	}
	console.log(addr_callphone);
	var callphoneRegExp = new RegExp(/^([\+][0-9]{1,3}[ \.\-])?([\(][0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/);
	if (!callphoneRegExp.test(addr_callphone)){

		reg_alert('addr_callphone', '无效的电话号码！');
		return;
	}
		reg_success('addr_callphone', '可以使用！');
}
function Checkcity()
{
	var addr_city= $('#addr_city').val();

	if(addr_city=null||addr_city==""){
		
		reg_alert('addr_city', '请选择城市！');
		return;
	}
		reg_success('addr_city', '城市已选！');
}
function Checkprovince()
{var addr_province= $('#addr_province').val();
	if(addr_province=null||addr_province==""){
		reg_alert('addr_province', '请选择省份！');
		return;
	}
		reg_success('addr_province', '省份已选！');
}



function CheckEmail()
{
	var email = $('#email').val();
	if (email == '')
	{
		reg_alert('email', '请输入Email地址！');
		return;
	}
	var emailRegExp = new RegExp("[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?");
	if (!emailRegExp.test(email)||email.indexOf('.')==-1)
	{
		reg_alert('email', '请输入正确的Email地址！');
		return;
	}
	else
	{
		$.get('?mod=account&code=exists&field=email&value='+email+$.rnd.stamp(), function(data)
		{
			eval('var data=' + data);
			if (data.status == 'failed')
			{

				reg_alert('email', '验证失败！'+' '+data.result);
				return;
			}
			if (data.result)
			{
				reg_alert('email', '此Email地址已经被注册！');
				return;
			}
			reg_success('email', '可以使用！');
		});
	}
}

function CheckPhone()
{
	var phone = $('#phone').val();
	if (phone == '') return;
	if (phone.length < 11){
		reg_alert('phone', '请输入正确的手机号码！');
		return;
	}
	else
	{
		$.get('?mod=account&code=exists&field=phone&value='+phone+$.rnd.stamp(), function(data)
		{
			eval('var data=' + data);
			if (data.status == 'failed')
			{

				reg_alert('phone', '验证失败！'+' '+data.result);
				return;
			}
			if (data.result)
			{
				reg_alert('phone', '此手机号码已经被注册！');
				return;
			}
			reg_success('phone', '可以使用！');
		});
	}
}

function CheckUsername()
{
	var name = $('#username').val();
	if(name.replace(/[^\x00-\xff]/g,"**").length<4 || name.length>16){
		reg_alert('username', '用户名必须在4位到16位！');
		return;
	}
	name = encodeURIComponent(name);
	$.get('?mod=account&code=exists&field=name&value='+name+$.rnd.stamp(), function(data)
	{
		eval('var data=' + data);
		if (data.status == 'failed')
		{
			reg_alert('username', '验证失败！'+' '+data.result);
			return;
		}
		if (data.result)
		{
			reg_alert('username', '此用户名已经被注册！');
			return;
		}
		reg_success('username', '可以使用！');
	});
}

function CheckPassword()
{
	var pwd = $('#password').val();
	if(pwd.length < 6){
		reg_alert('password', '密码最少6个字符！');
		return;
	}
	reg_success('password', '可以使用！');
}


function CheckPassword_nm()
{
	var pwd = $('#password_nm').val();
	//var reg = /^(?:(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^A-Za-z0-9])).{8,20}$/;
	
	if(pwd.length < 8){
		
		//document.getElementById("password_nm").style.background="#A52A2A";
		reg_alert_nm('password_nm', '密码最少8个字符！');		
		return;
	}
	

	if(!(pwd.match(/([a-z])+/))){  
		//document.getElementById("password_nm").style.background="#A52A2A";
		reg_alert_nm('password_nm', '密码需包含小写字母！');
		return;
	}
	
	if(!(pwd.match(/([0-9])+/))){  
		//document.getElementById("password_nm").style.background="#A52A2A";
		reg_alert_nm('password_nm', '密码需包含数字！');
		return;
	}
	
	if(!(pwd.match(/([A-Z])+/))){
		//document.getElementById("password_nm").style.background="#A52A2A";
		reg_alert_nm('password_nm', '密码需包含大写字母！');
		return;
	}
	reg_success_nm('password_nm', '可以使用！');
}





function CheckRepassword()
{
	var pwd = $('#password').val();
	if (pwd == '')
	{
		return;
	}
	var repwd = $('#repassword').val();
	if (pwd != repwd)
	{
		
		reg_alert('repassword', '两次密码不一致！');
		return;
	}
	reg_success('repassword', '密码输入正确！');
}



function CheckRepassword_nm()
{
	var pwd = $('#password_nm').val();
	if (pwd == '')
	{
		return;
	}
	var repwd = $('#repassword_nm').val();
	if (pwd != repwd)
	{
		//document.getElementById("repassword_nm").style.background="#A52A2A";
		reg_alert_nm('repassword_nm', '两次密码不一致！');
		return;
	}
	reg_success_nm('repassword_nm', '密码输入正确！');
}







function CheckzfPassword()
{
	var pwd = $('#zfpassword').val();
	if(pwd.length < 4){
		
		reg_alert('zfpassword', '支付密码最短4位数！');
		return ;
	}
	reg_success('zfpassword', '可以使用！');
}


function CheckzfPassword_nm()
{
	var pwd = $('#zfpassword_nm').val();
	if(pwd.length < 8){
		//document.getElementById("zfpassword_nm").style.background="#A52A2A";
		reg_alert_nm('zfpassword_nm', '支付密码最短8位数！');
		return;
	}
	reg_success_nm('zfpassword_nm', '可以使用！');
}






function CheckzfRepassword()
{
	var pwd = $('#zfpassword').val();
	if (pwd == '')
	{
		return;
	}
	var repwd = $('#rezfpassword').val();
	if (pwd != repwd)
	{
		reg_alert('rezfpassword', '两次支付密码不一致！');
		return;
	}
	reg_success('rezfpassword', '支付密码输入正确！');
}




function CheckRezfPassword_nm()
{
	var pwd = $('#zfpassword_nm').val();
	if (pwd == '')
	{
		return;
	}
	var repwd = $('#rezfpassword_nm').val();
	if (pwd != repwd)
	{
		//document.getElementById("rezfpassword_nm").style.background="#A52A2A";
		reg_alert_nm('rezfpassword_nm', '两次支付密码不一致！');
		return;
	}
	reg_success_nm('rezfpassword_nm', '支付密码输入正确！');
}




function Checkzjwords_nm()
{
	var pwd = $('#zjwords_nm').val();
	if(pwd.length < 8){
		reg_alert_nm('zjwords_nm', '助记词最少8个字符！');
		return;
	}
	reg_success_nm('zjwords_nm', '可以使用！');
}




function reg_alert(field, text)
{
	
	$('#'+field+'_result').html(text).removeClass().addClass('alert');
}
function reg_success(field, text)
{
	$('#'+field+'_result').html(text).removeClass().addClass('success');
}

function reg_alert_nm(field, text)
{
	document.getElementById(field).style.background="#A52A2A";
	$('#'+field+'_result').html(text).removeClass().addClass('alert');
}
function reg_success_nm(field, text)
{
	document.getElementById(field).style.background="#99FF33";
	$('#'+field+'_result').html(text).removeClass().addClass('success');
}




