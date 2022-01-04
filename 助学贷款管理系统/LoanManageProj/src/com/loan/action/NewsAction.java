/**
 * 
 * @Title: NewsAction.java
 * @Package com.loan.action
 * @Description: ���Ź���
 * @author He ChangYan
 * @date 2012-3-26 ����10:32:25
 * @copyright STARIT   
 */
package com.loan.action;

import java.util.List;

import javax.swing.JOptionPane;

import com.loan.entity.News;
import com.loan.service.NewsService;

public class NewsAction {

	public News news;//ʵ�������Ŷ���
	public List<News> newsList;//���ż���
	public News addNews;//�������
	public News delNews;//ɾ������
	public NewsService newsService;
	
	public News getNews() {
		return news;
	}

	public void setNews(News news) {
		this.news = news;
	}

	public List<News> getNewsList() {
		return newsList;
	}

	public void setNewsList(List<News> newsList) {
		this.newsList = newsList;
	}

	public News getAddNews() {
		return addNews;
	}

	public void setAddNews(News addNews) {
		this.addNews = addNews;
	}

	public News getDelNews() {
		return delNews;
	}

	public void setDelNews(News delNews) {
		this.delNews = delNews;
	}

	public NewsService getNewsService() {
		return newsService;
	}

	public void setNewsService(NewsService newsService) {
		this.newsService = newsService;
	}

	/**
	 * 
	 * @Title: list
	 * @Description: ������������
	 * @return
	 * @return String
	 * @throws
	 */
	public String list() {
		newsList = newsService.findAll();
		return "list";
	}
	
	/**
	 * 
	 * @Title: listStu
	 * @Description: ������������
	 * @return
	 * @return String
	 * @throws
	 */
	public String listStu() {
		newsList = newsService.findAll();
		return "listStu";
	}
	
	/**
	 * 
	 * @Title: addNews
	 * @Description: �������
	 * @return
	 * @return String
	 * @throws
	 */
	public String addNews() {
		newsService.addNews(addNews);
		return list();
	}

	/**
	 * 
	* @Title: delNews
	* @Description: ɾ������
	* @return    
	* @return String 
	* @throws
	 */
	public String delNews() {
		News newsDel = newsService.findNewsById(delNews.getNid());
		newsService.delNews(newsDel);
		JOptionPane.showMessageDialog(null, "����ɾ���ɹ���", "��ʾ", 2);
		return list();
	}
	
	
}
