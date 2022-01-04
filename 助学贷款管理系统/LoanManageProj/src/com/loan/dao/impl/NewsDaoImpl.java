/**
* 
* @Title: NewsDaoImpl.java
* @Package com.loan.dao.impl
* @Description: 新闻管理数据访问实现类
* @author He ChangYan
* @date 2012-3-26 上午10:40:12
* @copyright STARIT   
*/
package com.loan.dao.impl;

import java.util.List;

import org.springframework.orm.hibernate3.support.HibernateDaoSupport;

import com.loan.dao.NewsDao;
import com.loan.entity.News;


public class NewsDaoImpl extends HibernateDaoSupport implements NewsDao {

	/**
	 * 查询所有新闻
	 */
	public List<News> findAll(){
		List<News> list = null;
		list = this.getSession().createQuery("from News news").list();
		return list;
	}
	
	/**
	 * 添加新闻
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
	 * 删除新闻
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
	 * 从数据库 中查找对应的新闻信息
	 */
	public News findNewsById(int nid) {
		return (News)getSession().get(News.class, nid);
	}

	
}
