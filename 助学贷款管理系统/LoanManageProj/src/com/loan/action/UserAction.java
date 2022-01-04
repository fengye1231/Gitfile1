/**
 * 
 * @Title: UserAction.java
 * @Package com.loan.action
 * @Description: �û������߼�������
 * @author He ChangYan
 * @date 2012-2-29 ����05:03:35
 * @copyright STARIT   
 */
package com.loan.action;

import java.util.List;
import java.util.Map;

import javax.swing.JOptionPane;

import org.apache.struts2.ServletActionContext;

import com.loan.entity.User;
import com.loan.service.UserService;
import com.opensymphony.xwork2.ActionContext;

public class UserAction {

	private User user;
	private User addUser;
	private User delUser;
	private User updateUser;
	private User updateMy;
	private User register;
	private List<User> userList;
	private String msg;// ��½��ʾ��Ϣ
	private UserService userService;// ʵ����userService����
	private Map<String, Object> session;

	/* get��set���� */
	public User getUser() {
		return user;
	}

	public void setUser(User user) {
		this.user = user;
	}

	public User getRegister() {
		return register;
	}

	public void setRegister(User register) {
		this.register = register;
	}

	public User getAddUser() {
		return addUser;
	}

	public void setAddUser(User addUser) {
		this.addUser = addUser;
	}

	public User getDelUser() {
		return delUser;
	}

	public void setDelUser(User delUser) {
		this.delUser = delUser;
	}

	public User getUpdateUser() {
		return updateUser;
	}

	public void setUpdateUser(User updateUser) {
		this.updateUser = updateUser;
	}

	public List<User> getUserList() {
		return userList;
	}

	public void setUserList(List<User> userList) {
		this.userList = userList;
	}

	public String getMsg() {
		return msg;
	}

	public void setMsg(String msg) {
		this.msg = msg;
	}

	public UserService getUserService() {
		return userService;
	}

	public void setUserService(UserService userService) {
		this.userService = userService;
	}

	public Map<String, Object> getSession() {
		return session;
	}

	public void setSession(Map<String, Object> session) {
		this.session = session;
	}
	
	public User getUpdateMy() {
		return updateMy;
	}

	public void setUpdateMy(User updateMy) {
		this.updateMy = updateMy;
	}

	/**
	 * 
	 * @Title: list
	 * @Description: ���������û���Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String list() {
		userList = userService.findAll();
		return "list";
	}

	/**
	 * 
	 * @Title: login
	 * @Description: ��֤��¼���û����������Ƿ���ȷ
	 * @return
	 * @return String
	 * @throws
	 */
	public String login() {
		String flag = "stuLogin";
		String sql = "from User u where UserName = '" + user.getUserName()
				+ "' and UserPwd = '" + user.getUserPwd() + "'";
		user = userService.checkLogin(sql);
		if (user != null) {
			Map<String, Object> session = ActionContext.getContext()
					.getSession();
			session.put("userId", user.getUserId());
			session.put("userName", user.getUserName());
			ServletActionContext.getRequest().getSession().setAttribute("name", user.getUserName());
			session.put("status", user.getStatus());
			if (user.getStatus().equals("����С��")) {
				flag = "loanLogin";
			} else if (user.getStatus().equals("Ժ�쵼")) {
				flag = "academyLogin";
			} else if (user.getStatus().equals("����Ա")) {
				flag = "adminLogin";
			}
		} else {
			msg = "�û������������!";
			JOptionPane.showMessageDialog(null, msg, "����", 2);
			flag = "fail";
		}
		return flag;
	}

	/**
	 * 
	 * @Title: register
	 * @Description: ע�����û�
	 * @return
	 * @return String
	 * @throws
	 */
	public String register() {
		String flag = "register";
		String sql = "from User u where UserName = '" + register.getUserName()
				+ "'";
		User reg = userService.register(sql);
		if (reg != null) {
			if (reg.getUserName().equals(register.getUserName())) {
				msg = "���û����Ѵ��ڣ������������û���!";
				JOptionPane.showMessageDialog(null, msg, "����", 2);
				flag = "regFail";
			}
		} else {
			userService.addUser(register);
		}
		return flag;
	}

	/**
	 * 
	 * @Title: searchUser
	 * @Description: ����������ѯ�û���Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String searchUser() {
		String sql = "from User u where userId = '" + user.getUserId() + "'"
				+ " and userName = '" + user.getUserName() + "'"
				+ " and status = '" + user.getStatus() + "'";
		userList = userService.searchUser(sql);
		if (userList.size() == 0) {
			String msg = "������Ĳ�ѯ������ȫ�棬�����ҵ���ƥ����û���Ϣ!���������Ƿ�����";
			JOptionPane.showMessageDialog(null, msg, "����", 0);// ������ʾ��Ϣ�Ի���
		}
		return "searchUser";
	}

	/**
	 * 
	 * @Title: addUser
	 * @Description: �����û���Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String addUser() {
		userService.addUser(addUser);
		return list();
	}

	/**
	 * 
	 * @Title: delUser
	 * @Description: ɾ���û���Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String delUser() {
		User userDel = userService.findUserById(delUser.getUserId());
		userService.delUser(userDel);
		JOptionPane.showMessageDialog(null, "����ɾ���ɹ���", "��ʾ", 2);
		return list();
	}

	/**
	 * 
	 * @Title: updateUser
	 * @Description: �޸��û���Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateUser() {
		userService.updateUser(updateUser);
		JOptionPane.showMessageDialog(null, "�����޸ĳɹ������ס���޸ĵ������롣", "��ʾ", 2);
		return "updateUser";
	}
	

	/**
	 * 
	 * @Title: updateInput
	 * @Description: �����ݿ����ҵ�һ������
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateInput() {
		updateUser = userService.findUserById(updateUser.getUserId());
		return "updateInput";
	}
	

}
