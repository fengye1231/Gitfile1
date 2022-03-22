package com.pet_shop.service.impl;

import com.pet_shop.entity.DamageListGoods;
import com.pet_shop.mapper.DamageListGoodsMapper;
import com.pet_shop.service.DamageListGoodsService;
import org.springframework.stereotype.Service;

import javax.annotation.Resource;
import java.util.List;

/**
 * 商品报损单商品Service实现类
 *
 * @author pet_shop
 * @company
 * @create 2020-01-18 11:44
 */
@Service("damageListGoodsService")
public class DamageListGoodsServiceImpl implements DamageListGoodsService {

    @Resource
    private DamageListGoodsMapper damageListGoodsMapper;

    @Override
    public List<DamageListGoods> listByDamageListId(Integer damageListId) {
        return damageListGoodsMapper.listByDamageListId(damageListId);
    }

    @Override
    public Integer deleteByDamageListId(Integer damageListId) {
        return damageListGoodsMapper.deleteByDamageListId(damageListId);
    }

    @Override
    public Integer add(DamageListGoods damageListGoods) {
        return damageListGoodsMapper.add(damageListGoods);
    }
}
