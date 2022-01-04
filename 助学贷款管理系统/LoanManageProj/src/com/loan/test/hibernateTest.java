/**
 * 
 * @Title: hibernateTest.java
 * @Package com.loan.test
 * @Description: 测试数据库是否连接成功
 * @author He ChangYan
 * @date 2012-3-1 下午05:54:56
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
			System.out.print("连接数据库成功");
			ssn.close();
		} else {
			System.out.print("连接数据库失败");
		}
	}
}
