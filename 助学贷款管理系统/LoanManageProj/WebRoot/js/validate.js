//---------------------�жϴ������Ƿ�Ϸ�
function isRangeNumSpan() {   
        var val = document.getElementById("LAccount").value;  
        if (/^\d+$/.test(val))     
	    {     
	       if(val<3000 || val>6000){
		    	alert("����������Ǵ��ڵ���3000��С�ڵ���6000������!"); 
		    	document.getElementById("LAccount").value = "";
		   }  
	    }else     
	    {     
		   alert("����������");
		   document.getElementById("LAccount").value = "";
	       return false;     
	    }     

    }   

//--------------�ж��˺��Ƿ�Ϸ�
function checkPay(){
	
	var pay = document.getElementById("Bpay").value;
	var reg = /^\d{19}$/g;
	if(!reg.test(pay)){
		alert("��ʽ����Ӧ����19λ������ɣ�");
		document.getElementById("Bpay").value = "";
	}else{
		alert("��֤�ɹ���");
	}
}


//--------------�ж������ǺϷ���
function isDate() {
	var strDate = document.getElementById("txtDate").value;
	var result1 = strDate
			.match(/((^((1[8-9]\d{2})|([2-9]\d{3}))(-)(10|12|0?[13578])(-)(3[01]|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))(-)(11|0?[469])(-)(30|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))(-)(0?2)(-)(2[0-8]|1[0-9]|0?[1-9])$)|(^([2468][048]00)(-)(0?2)(-)(29)$)|(^([3579][26]00)(-)(0?2)(-)(29)$)|(^([1][89][0][48])(-)(0?2)(-)(29)$)|(^([2-9][0-9][0][48])(-)(0?2)(-)(29)$)|(^([1][89][2468][048])(-)(0?2)(-)(29)$)|(^([2-9][0-9][2468][048])(-)(0?2)(-)(29)$)|(^([1][89][13579][26])(-)(0?2)(-)(29)$)|(^([2-9][0-9][13579][26])(-)(0?2)(-)(29)$))/);
	if (result1 == null) {
		alert("��������ȷ�����ڸ�ʽ��,���磺2009-01-01��");
		document.getElementById("txtDate").value = "";
	} else {
		alert("��������ںϷ���");
	}
}

//--------------------------------�жϵ绰����/�ֻ����� 
function checkTel() {
	var tel = document.getElementById("MTel");
	if (tel.value.length != 11) {
		alert("������д��ʵ����ϵ��ʽ");
		document.getElementById("MTel").value = "";
	} else {
		for ( var i = 0; i < 11; i++) {
			if (tel.value.charAt(i) < "0" || tel.value.charAt(i) > "9") {
				alert("��ϵ�绰ֻ����0--9���������");
				document.getElementById("MTel").value = "";
				return;
			}
		}
	}
}

//----------------------��֤���֤����ĺϷ���
function isIdCardNo() {
	var idcard = document.getElementById("stuIdentity").value;
	var area = {
		11 : "����",
		12 : "���",
		13 : "�ӱ�",
		14 : "ɽ��",
		15 : "���ɹ�",
		21 : "����",
		22 : "����",
		23 : "������",
		31 : "�Ϻ�",
		32 : "����",
		33 : "�㽭",
		34 : "����",
		35 : "����",
		36 : "����",
		37 : "ɽ��",
		41 : "����",
		42 : "����",
		43 : "����",
		44 : "�㶫",
		45 : "����",
		46 : "����",
		50 : "����",
		51 : "�Ĵ�",
		52 : "����",
		53 : "����",
		54 : "����",
		61 : "����",
		62 : "����",
		63 : "�ຣ",
		64 : "����",
		65 : "�½�",
		71 : "̨��",
		81 : "���",
		82 : "����",
		91 : "����"
	}
	var Y, JYM;
	var S, M;
	var idcard_array = new Array();
	idcard_array = idcard.split("");

	//�������� 
	if (area[parseInt(idcard.substr(0, 2))] == null) {
		alert("���֤�����Ƿ�!");
		document.getElementById("stuIdentity").value = "";
	}
	//��ݺ���λ������ʽ���� 
	switch (idcard.length) {
	case 15:
		if ((parseInt(idcard.substr(6, 2)) + 1900) % 4 == 0
				|| ((parseInt(idcard.substr(6, 2)) + 1900) % 100 == 0 && (parseInt(idcard
						.substr(6, 2)) + 1900) % 4 == 0)) {
			ereg = /^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}$/; //���Գ������ڵĺϷ��� 
		} else {
			ereg = /^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}$/; //���Գ������ڵĺϷ��� 
		}
		if (ereg.test(idcard)) {
			alert("��֤ͨ��!");
		} else {
			alert("���֤����������ڳ�����Χ���зǷ��ַ�!");
			document.getElementById("stuIdentity").value = "";
		}
		break;
	case 18:
		//18λ��ݺ����� 
		if (parseInt(idcard.substr(6, 4)) % 4 == 0
				|| (parseInt(idcard.substr(6, 4)) % 100 == 0 && parseInt(idcard
						.substr(6, 4)) % 4 == 0)) {
			ereg = /^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}[0-9Xx]$/; //����������ڵĺϷ���������ʽ 
		} else {
			ereg = /^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}[0-9Xx]$/; //ƽ��������ڵĺϷ���������ʽ 
		}
		if (ereg.test(idcard)) {//���Գ������ڵĺϷ��� 
			//����У��λ 
			S = (parseInt(idcard_array[0]) + parseInt(idcard_array[10])) * 7
					+ (parseInt(idcard_array[1]) + parseInt(idcard_array[11]))
					* 9
					+ (parseInt(idcard_array[2]) + parseInt(idcard_array[12]))
					* 10
					+ (parseInt(idcard_array[3]) + parseInt(idcard_array[13]))
					* 5
					+ (parseInt(idcard_array[4]) + parseInt(idcard_array[14]))
					* 8
					+ (parseInt(idcard_array[5]) + parseInt(idcard_array[15]))
					* 4
					+ (parseInt(idcard_array[6]) + parseInt(idcard_array[16]))
					* 2 + parseInt(idcard_array[7]) * 1
					+ parseInt(idcard_array[8]) * 6 + parseInt(idcard_array[9])
					* 3;
			Y = S % 11;
			M = "F";
			JYM = "10X98765432";
			M = JYM.substr(Y, 1); //�ж�У��λ 
			if (M == idcard_array[17]) {
				alert("��֤ͨ��!");//���ID��У��λ 
			} else {
				alert("���֤����У�����!");
				document.getElementById("stuIdentity").value = "";
			}
		} else {
			alert("���֤����������ڳ�����Χ���зǷ��ַ�!");
			document.getElementById("stuIdentity").value = "";
		}
		break;
	default: {
		alert("���֤����λ������!");
		document.getElementById("stuIdentity").value = "";
		break;
	}
	}
}

