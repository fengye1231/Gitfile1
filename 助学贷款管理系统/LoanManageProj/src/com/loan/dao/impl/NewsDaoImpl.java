/**
* 
* @Title: NewsDaoImpl.java
* @Package com.loan.dao.impl
* @Description: ���Ź������ݷ���ʵ����
* @author He ChangYan
* @date 2012-3-26 ����10:40:12
* @copyright STARIT   
*/
package com.loan.dao.impl;

import java.util.List;

import org.springframework.orm.hibernate3.support.HibernateDaoSupport;

import com.loan.dao.NewsDao;
import com.loan.entity.News;


public class NewsDaoImpl extends HibernateDaoSupport implements NewsDao {

	/**
	 * ��ѯ��������
	 */
	public List<News> findAll(){
		List<News> list = null;
		list = this.getSession().createQuery("from News news").list();
		return list;
	}
	
	/**
	 * �������
	 */
	public boolean addNews(News addNews){
		boolean b=true;
		try {
				this.getSession().save(addNews);
		} catch (Exception e) {
			b=false;
			e.printStackTrace();
		} 
		return b;
	}
	
	
	/**
	 * ɾ������
	 */
	public boolean delNews(News delNews) {
		boolean b = true;
		try {
			this.getSession().delete(delNews);
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * �����ݿ� �в��Ҷ�Ӧ��������Ϣ
	 */
	public News findNewsById(int nid) {
		return (News)getSession().get(News.class, nid);
	}

	
}
