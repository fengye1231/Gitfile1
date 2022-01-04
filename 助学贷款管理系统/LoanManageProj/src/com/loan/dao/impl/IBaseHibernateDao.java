package com.loan.dao.impl;

import org.hibernate.Session;



public interface IBaseHibernateDao {
	public Session getSession();
}