/**
 * 
 * @Title: hibernateTest.java
 * @Package com.loan.test
 * @Description: �������ݿ��Ƿ����ӳɹ�
 * @author He ChangYan
 * @date 2012-3-1 ����05:54:56
 * @copyright STARIT   
 */
package com.loan.test;


import org.hibernate.Session;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;

public class hibernateTest {
	public static void main(String[] args) {
		Configuration cfg = (new Configuration())
				.configure("/hibernate.cfg.xml");
		SessionFactory sf = cfg.buildSessionFactory();
		Session ssn = sf.openSession();
		if (ssn != null) {
			System.out.print("�������ݿ�ɹ�");
			ssn.close();
		} else {
			System.out.print("�������ݿ�ʧ��");
		}
	}
}
