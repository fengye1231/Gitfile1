/**
 * 
 * @Title: UserServiceImpl.java
 * @Package com.loan.service.impl
 * @Description: �û�����ҵ���߼�����ʵ����
 * @author He ChangYan
 * @date 2012-2-29 ����05:08:14
 * @copyright STARIT   
 */
package com.loan.service.impl;

import java.util.List;

import com.loan.dao.UserDao;
import com.loan.entity.User;
import com.loan.service.UserService;

public class UserServiceImpl implements UserService {

	private UserDao userDao;// ʵ��DAO����

	public UserDao getUserDao() {
		return userDao;
	}

	public void setUserDao(UserDao userDao) {
		this.userDao = userDao;
	}

	/*
	 * (�� Javadoc) <p>Title: checkLogin</p> <p>Description: �жϵ�¼�û��Ƿ���ȷ</p>
	 * 
	 * @param user
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#checkLogin(com.loan.entity.User)
	 */
	public User checkLogin(String sql) {
		return userDao.checkLogin(sql);
	}

	/*
	 * (�� Javadoc) <p>Title: findAll</p> <p>Description: ���������û���Ϣ</p>
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#findAll()
	 */
	public List<User> findAll() {
		return userDao.findAll();
	}

	/*
	 * (�� Javadoc) <p>Title: searchUser</p> <p>Description: ����������ѯ�û���Ϣ</p>
	 * 
	 * @param sql
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#searchUser(java.lang.String)
	 */
	public List<User> searchUser(String sql) {
		return userDao.searchUser(sql);
	}

	/*
	 * (�� Javadoc) <p>Title: addUser</p> <p>Description: �����û���Ϣ</p>
	 * 
	 * @param user
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#addUser(com.loan.entity.User)
	 */
	public boolean addUser(User user) {
		return userDao.addUser(user);
	}

	/*
	 * (�� Javadoc) <p>Title: delUser</p> <p>Description: ɾ���û���Ϣ</p>
	 * 
	 * @param user
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#delUser(com.loan.entity.User)
	 */
	public boolean delUser(User user) {
		return userDao.delUser(user);
	}

	/*
	 * (�� Javadoc) <p>Title: updateUser</p> <p>Description: �޸��û���Ϣ</p>
	 * 
	 * @param user
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#updateUser(com.loan.entity.User)
	 */
	public boolean updateUser(User user) {
		return userDao.updateUser(user);
	}

	/*
	 * (�� Javadoc) <p>Title: findUserById</p> <p>Description: ����ID����һ���û���Ϣ</p>
	 * 
	 * @param userId
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#findUserById(int)
	 */
	public User findUserById(int userId) {
		return userDao.findUserById(userId);
	}

	/*
	 * (�� Javadoc) <p>Title: register</p> <p>Description: ע�����û�</p>
	 * 
	 * @param register
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#register(com.loan.entity.User)
	 */
	public User register(String sql) {
		return userDao.register(sql);
	}

}
