/**
 * 
 * @Title: NewsServiceImpl.java
 * @Package com.loan.service.impl
 * @Description: ���Ź���ҵ��ʵ����
 * @author He ChangYan
 * @date 2012-3-26 ����10:37:39
 * @copyright STARIT   
 */
package com.loan.service.impl;

import java.util.List;

import com.loan.dao.NewsDao;
import com.loan.entity.News;
import com.loan.service.NewsService;

public class NewsServiceImpl implements NewsService {

	private NewsDao newsDao;// ʵ��DAO����

	public NewsDao getNewsDao() {
		return newsDao;
	}

	public void setNewsDao(NewsDao newsDao) {
		this.newsDao = newsDao;
	}

	/*
	 * (�� Javadoc) <p>Title: findAll</p> <p>Description: ��ѯ��������</p>
	 * 
	 * @return
	 * 
	 * @see com.loan.service.NewsService#findAll()
	 */
	public List<News> findAll() {
		return newsDao.findAll();
	}

	/*
	 * (�� Javadoc) <p>Title: addNews</p> <p>Description: �������</p>
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
	 * (�� Javadoc) <p>Title: delNews</p> <p>Description: ɾ������</p>
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

	/* (�� Javadoc)
	* <p>Title: findNewsById</p>
	* <p>Description: �����ݿ� �в��Ҷ�Ӧ��������Ϣ</p>
	* @param nid
	* @return
	* @see com.loan.service.NewsService#findNewsById(int)
	*/
	public News findNewsById(int nid) {
		return newsDao.findNewsById(nid);
	}
}
