/**
 * 
 * @Title: UserDaoImpl.java
 * @Package com.loan.dao.impl
 * @Description: �û��������ݷ���ʵ����
 * @author He ChangYan
 * @date 2012-2-29 ����05:05:38
 * @copyright STARIT   
 */
package com.loan.dao.impl;

import java.util.List;

import javax.swing.JOptionPane;

import org.springframework.orm.hibernate3.support.HibernateDaoSupport;

import com.loan.dao.UserDao;
import com.loan.entity.User;

public class UserDaoImpl extends HibernateDaoSupport implements UserDao {

	/**
	 * �жϵ�¼�û��Ƿ���ȷ
	 */
	public User checkLogin(String sql) {
		User u = null;
		List<User> l = this.getSession().createQuery(sql).list();
		if (l != null && l.size() > 0) {
			u = l.get(0);
		}
		return u;
	}

	/**
	 * ���������û���Ϣ
	 */
	public List<User> findAll() {
		List<User> list = null;
		list = this.getSession().createQuery("from User u").list();
		return list;
	}

	/**
	 * ����������ѯ�û���Ϣ
	 */
	public List<User> searchUser(String sql) {
		List<User> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}

	/**
	 * �����û���Ϣ
	 */
	public boolean addUser(User user) {
		boolean b = true;
		try {
			this.getSession().save(user);
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * ɾ���û���Ϣ
	 */
	public boolean delUser(User user) {
		boolean b = true;
		try {
			this.getSession().delete(user);
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * �޸��û���Ϣ
	 */
	public boolean updateUser(User user) {
		boolean b = true;
		try {
			this.getSession().update(user);
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * ����һ���û���Ϣ
	 */
	public User findUserById(int userId) {
		return (User) getSession().get(User.class, userId);
	}

	/**
	 * ע�����û�
	 */
	public User register(String sql) {
		User r = null;
		List<User> l = this.getSession().createQuery(sql).list();
		if (l != null && l.size() > 0) {
			r = l.get(0);
		}
		return r;
	}

}
