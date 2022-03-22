package com.pet_shop.service.impl;

import com.pet_shop.entity.OverflowListGoods;
import com.pet_shop.mapper.OverflowListGoodsMapper;
import com.pet_shop.service.OverflowListGoodsService;
import org.springframework.stereotype.Service;

import javax.annotation.Resource;
import java.util.List;

/**
 * 商品报溢单商品Service实现类
 *
 * @author pet_shop
 * @company
 * @create 2020-01-18 12:22
 */
@Service("overflowListGoodsService")
public class OverflowListGoodsServiceImpl implements OverflowListGoodsService {

    @Resource
    private OverflowListGoodsMapper overflowListGoodsMapper;

    @Override
    public List<OverflowListGoods> listByOverflowListId(Integer overflowListId) {
        return overflowListGoodsMapper.listByOverflowListId(overflowListId);
    }

    @Override
    public Integer deleteByOverflowListId(Integer overflowListId) {
        return overflowListGoodsMapper.deleteByOverflowListId(overflowListId);
    }

    @Override
    public Integer add(OverflowListGoods overflowListGoods) {
        return overflowListGoodsMapper.add(overflowListGoods);
    }
}
