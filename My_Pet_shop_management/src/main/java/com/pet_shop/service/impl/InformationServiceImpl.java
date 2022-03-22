package com.pet_shop.service.impl;

import com.pet_shop.entity.Information;
import com.pet_shop.mapper.InformationMapper;
import com.pet_shop.service.InformationService;
import org.springframework.stereotype.Service;

import javax.annotation.Resource;
import java.util.List;
import java.util.Map;

/**
 * 客户消息Service实现类
 *
 * @author pet_shop
 * @company
 * @create 2020-05-02 00:35
 */
@Service("informationService")
public class InformationServiceImpl implements InformationService {

    @Resource
    private InformationMapper informationMapper;

    @Override
    public List<Information> list(Map<String, Object> map) {
        return informationMapper.list(map);
    }

    @Override
    public Long getCount(Map<String, Object> map) {
        return informationMapper.getCount(map);
    }

    @Override
    public Integer add(Information information) {
        return informationMapper.add(information);
    }

    @Override
    public Integer update(Information information) {
        return informationMapper.update(information);
    }

    @Override
    public Integer delete(Integer id) {
        return informationMapper.delete(id);
    }

    @Override
    public Information findById(Integer id) {
        return informationMapper.findById(id);
    }
}
