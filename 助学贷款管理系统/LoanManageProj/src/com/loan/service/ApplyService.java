/**
* 
* @Title: ApplyService.java
* @Package com.loan.service
* @Description: ������ǰ�����¼ҵ��ӿ���
* @author He ChangYan
* @date 2012-3-26 ����10:36:21
* @copyright STARIT   
*/
package com.loan.service;

import java.util.List;

import com.loan.entity.Apply;


public interface ApplyService {

	/**��ѯ���������¼*/
	public List<Apply> findAll();
	
	/**���������ǰ�����¼*/
	public boolean addApply(Apply addApply);
	
	/**�����ݿ� �в��Ҷ�Ӧ��������Ϣ*/
	public Apply findApplyById(int applyId);
	
	/**�޸�������Ϣ*/
	public boolean updateApply(Apply updateApply);
	
	/**������������������Ϣ*/
	public List<Apply> findApplyByName(String sql);
	
	/**ɾ�������¼*/
	public boolean delApply(Apply delApply);
}
