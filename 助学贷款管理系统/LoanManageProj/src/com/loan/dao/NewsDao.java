/**
* 
* @Title: NewsDao.java
* @Package com.loan.dao
* @Description: 新闻管理数据访问接口
* @author He ChangYan
* @date 2012-3-26 上午10:39:15
* @copyright STARIT   
*/
package com.loan.dao;

import java.util.List;

import com.loan.entity.News;


public interface NewsDao {

	/**查询所有新闻*/
	public List<News> findAll();
	
	/**添加新闻*/
	public boolean addNews(News addNews);
	
	/**删除新闻*/
	public boolean delNews(News delNews);
	
	/**从数据库 中查找对应的新闻信息*/
	public News findNewsById(int nid);
}
