/**
* 
* @Title: HibernateUtils.java
* @Package com.loan.common
* @Description: 产生sessionFactory的工具类
* @author He ChangYan
* @date 2012-2-29 上午09:07:20
* @copyright STARIT   
*/
package com.loan.common;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;


public class HibernateUtils {

	public static SessionFactory sessionFactory;
	static {
		//根据配置文件产生SessionFactory
		sessionFactory = new Configuration().configure().buildSessionFactory();
	}
	public static Session getSession() {
		return sessionFactory.openSession();
	}
	
	public static void closeSession(Session session) {
		if(session.isOpen()) {
			session.close();
		}
	}
}
