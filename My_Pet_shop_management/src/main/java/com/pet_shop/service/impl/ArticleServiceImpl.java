package com.pet_shop.service.impl;

import com.pet_shop.entity.Article;
import com.pet_shop.mapper.ArticleMapper;
import com.pet_shop.service.ArticleService;
import org.springframework.stereotype.Service;

import javax.annotation.Resource;
import java.util.List;
import java.util.Map;

/**
 * 文章Service实现类
 *
 * @author pet_shop
 * @company
 * @create 2020-01-26 19:38
 */
@Service("articleService")
public class ArticleServiceImpl implements ArticleService {

    @Resource
    private ArticleMapper articleMapper;

    @Override
    public List<Article> list(Map<String, Object> map) {
        return articleMapper.list(map);
    }

    @Override
    public Long getCount(Map<String, Object> map) {
        return articleMapper.getCount(map);
    }

    @Override
    public Integer add(Article article) {
        return articleMapper.add(article);
    }

    @Override
    public Integer update(Article article) {
        return articleMapper.update(article);
    }

    @Override
    public Integer delete(Integer id) {
        return articleMapper.delete(id);
    }

    @Override
    public Article findById(Integer id) {
        return articleMapper.findById(id);
    }

    @Override
    public List<Article> findByTypeId(Integer typeId) {
        return articleMapper.findByTypeId(typeId);
    }

    @Override
    public Article getLast(Integer id) {
        return articleMapper.getLast(id);
    }

    @Override
    public Article getNext(Integer id) {
        return articleMapper.getNext(id);
    }
}