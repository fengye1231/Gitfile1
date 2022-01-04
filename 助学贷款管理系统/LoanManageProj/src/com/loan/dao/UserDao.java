/**
 * 
 * @Title: UserDao.java
 * @Package com.loan.dao
 * @Description: �û��������ݷ��ʽӿ���
 * @author He ChangYan
 * @date 2012-2-29 ����05:04:34
 * @copyright STARIT   
 */
package com.loan.dao;

import java.util.List;

import com.loan.entity.User;

public interface UserDao {

	/** �жϵ�¼�û��Ƿ���ȷ */
	public User checkLogin(String sql);

	/** ���������û���Ϣ */
	public List<User> findAll();

	/** ����������ѯ�û���Ϣ */
	public List<User> searchUser(String sql);

	/** �����û���Ϣ */
	public boolean addUser(User user);

	/** �����û���Ϣ */
	public boolean delUser(User user);

	/** �����û���Ϣ */
	public boolean updateUser(User user);

	/** ����ID����һ���û���Ϣ */
	public User findUserById(int userId);

	/** ע�����û� */
	public User register(String sql);
}
