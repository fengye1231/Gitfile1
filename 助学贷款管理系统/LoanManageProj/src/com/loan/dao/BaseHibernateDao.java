package com.loan.dao;

import org.hibernate.Session;

import com.loan.common.HibernateUtils;
import com.loan.dao.impl.IBaseHibernateDao;


/**
 * Data access object (DAO) for domain model
 * @author MyEclipse Persistence Tools
 */
public class BaseHibernateDao implements IBaseHibernateDao {
	
	public Session getSession() {
		return HibernateUtils.getSession();
	}
	
}