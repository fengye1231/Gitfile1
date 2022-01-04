/**
 * 
 * @Title: NewsServiceImpl.java
 * @Package com.loan.service.impl
 * @Description: 新闻管理业务实现类
 * @author He ChangYan
 * @date 2012-3-26 上午10:37:39
 * @copyright STARIT   
 */
package com.loan.service.impl;

import java.util.List;

import com.loan.dao.NewsDao;
import com.loan.entity.News;
import com.loan.service.NewsService;

public class NewsServiceImpl implements NewsService {

	private NewsDao newsDao;// 实例DAO对象

	public NewsDao getNewsDao() {
		return newsDao;
	}

	public void setNewsDao(NewsDao newsDao) {
		this.newsDao = newsDao;
	}

	/*
	 * (非 Javadoc) <p>Title: findAll</p> <p>Description: 查询所有新闻</p>
	 * 
	 * @return
	 * 
	 * @see com.loan.service.NewsService#findAll()
	 */
	public List<News> findAll() {
		return newsDao.findAll();
	}

	/*
	 * (非 Javadoc) <p>Title: addNews</p> <p>Description: 添加新闻</p>
	 * 
	 * @param addNews
	 * 
	 * @return
	 * 
	 * @see com.loan.service.NewsService#addNews(com.loan.entity.News)
	 */
	public boolean addNews(News addNews) {
		return newsDao.addNews(addNews);
	}

	

	/*
	 * (非 Javadoc) <p>Title: delNews</p> <p>Description: 删除新闻</p>
	 * 
	 * @param delNews
	 * 
	 * @return
	 * 
	 * @see com.loan.service.NewsService#delNews(com.loan.entity.News)
	 */
	public boolean delNews(News delNews) {
		return newsDao.delNews(delNews);
	}

	/* (非 Javadoc)
	* <p>Title: findNewsById</p>
	* <p>Description: 从数据库 中查找对应的新闻信息</p>
	* @param nid
	* @return
	* @see com.loan.service.NewsService#findNewsById(int)
	*/
	public News findNewsById(int nid) {
		return newsDao.findNewsById(nid);
	}
}
