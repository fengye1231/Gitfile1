/**
* 
* @Title: HibernateUtils.java
* @Package com.loan.common
* @Description: ����sessionFactory�Ĺ�����
* @author He ChangYan
* @date 2012-2-29 ����09:07:20
* @copyright STARIT   
*/
package com.loan.common;

import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;


public class HibernateUtils {

	public static SessionFactory sessionFactory;
	static {
		//���������ļ�����SessionFactory
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
