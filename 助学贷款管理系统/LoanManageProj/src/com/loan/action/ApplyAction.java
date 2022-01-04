/**
 * 
 * @Title: ApplyAction.java
 * @Package com.loan.action
 * @Description: ������ǰ�����¼
 * @author He ChangYan
 * @date 2012-3-26 ����10:32:25
 * @copyright STARIT   
 */
package com.loan.action;

import java.util.List;

import javax.swing.JOptionPane;

import org.apache.struts2.ServletActionContext;

import com.loan.entity.Apply;
import com.loan.service.ApplyService;

public class ApplyAction {

	private Apply addApply;
	private Apply delApply;
	private Apply updateApply;
	private List<Apply> applyList;// ������Ϣ����
	private List<Apply> myApplyList;
	private ApplyService applyService;// ʵ����service����

	/* get��set���� */
	public Apply getAddApply() {
		return addApply;
	}

	public void setAddApply(Apply addApply) {
		this.addApply = addApply;
	}

	public Apply getDelApply() {
		return delApply;
	}

	public void setDelApply(Apply delApply) {
		this.delApply = delApply;
	}

	public Apply getUpdateApply() {
		return updateApply;
	}

	public void setUpdateApply(Apply updateApply) {
		this.updateApply = updateApply;
	}

	public List<Apply> getApplyList() {
		return applyList;
	}

	public void setApplyList(List<Apply> applyList) {
		this.applyList = applyList;
	}

	public ApplyService getApplyService() {
		return applyService;
	}

	public void setApplyService(ApplyService applyService) {
		this.applyService = applyService;
	}

	public List<Apply> getMyApplyList() {
		return myApplyList;
	}

	public void setMyApplyList(List<Apply> myApplyList) {
		this.myApplyList = myApplyList;
	}

	
	/**
	 * 
	 * @Title: list
	 * @Description: �������������¼
	 * @return
	 * @return String
	 * @throws
	 */
	public String list() {
		applyList = applyService.findAll();
		return "list";
	}
	
	/**
	 * 
	* @Title: findAccountByName
	* @Description: ������������������Ϣ
	* @return    
	* @return String 
	* @throws
	 */
	public String findApplyByName() {
		String flag = "myApplyList";
		String userName = (String)ServletActionContext.getRequest().getSession().getAttribute("name");
		String sql = "from Apply a where StuName = '" + userName +"'";
		myApplyList = applyService.findApplyByName(sql);
		if (myApplyList.size() == 0) {
			String msg = "�����ҵ�������Ϣ������!����д�����";
			JOptionPane.showMessageDialog(null, msg, "����", 0);// ������ʾ��Ϣ�Ի���
			flag = "addMyApply";
		}
		return flag;
	}
	
	/**
	 * 
	 * @Title: addApply
	 * @Description: ���������ǰ�����¼
	 * @return
	 * @return String
	 * @throws
	 */
	public String addApply() {
		applyService.addApply(addApply);
		return findApplyByName();
	}

	/**
	 * 
	* @Title: delApply
	* @Description: ɾ�������¼
	* @return    
	* @return String 
	* @throws
	 */
	public String delApply() {
		Apply applyDel = applyService.findApplyById(delApply.getApplyId());
		applyService.delApply(applyDel);
		JOptionPane.showMessageDialog(null, "����ɾ���ɹ���", "��ʾ", 2);
		return list();
	}
	
	/**
	 * 
	 * @Title: updateInput
	 * @Description: �����ݿ� �в��Ҷ�Ӧ��������Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateInput() {
		updateApply = applyService.findApplyById(updateApply.getApplyId());
		return "updateInput";
	}

	/**
	 * 
	 * @Title: updateApply
	 * @Description: �޸���Ո��Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateApply() {
		applyService.updateApply(updateApply);
		JOptionPane.showMessageDialog(null, "�����޸ĳɹ���", "��ʾ", 2);
		return list();
	}
	
	/**
	 * 
	 * @Title: updateInput
	 * @Description: �����ݿ� �в��Ҷ�Ӧ��������Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateMyInput() {
		updateApply = applyService.findApplyById(updateApply.getApplyId());
		return "updateMyInput";
	}

	/**
	 * 
	 * @Title: updateApply
	 * @Description: �޸���Ո��Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateMyApply() {
		applyService.updateApply(updateApply);
		JOptionPane.showMessageDialog(null, "�����޸ĳɹ���", "��ʾ", 2);
		return findApplyByName();
	}
}
