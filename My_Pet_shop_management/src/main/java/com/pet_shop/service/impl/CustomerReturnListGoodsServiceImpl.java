package com.pet_shop.service.impl;

import com.pet_shop.entity.CustomerReturnListGoods;
import com.pet_shop.mapper.CustomerReturnListGoodsMapper;
import com.pet_shop.service.CustomerReturnListGoodsService;
import org.springframework.stereotype.Service;

import javax.annotation.Resource;
import java.util.List;
import java.util.Map;

/**
 * 客户退货单商品Service实现类
 *
 * @author pet_shop
 * @company
 * @create 2020-01-17 19:17
 */
@Service("customerReturnListGoodsService")
public class CustomerReturnListGoodsServiceImpl implements CustomerReturnListGoodsService {

    @Resource
    private CustomerReturnListGoodsMapper customerReturnListGoodsMapper;

    @Override
    public List<CustomerReturnListGoods> listByCustomerReturnListId(Integer customerReturnListId) {
        return customerReturnListGoodsMapper.listByCustomerReturnListId(customerReturnListId);
    }

    @Override
    public Integer deleteByCustomerReturnListId(Integer customerReturnListId) {
        return customerReturnListGoodsMapper.deleteByCustomerReturnListId(customerReturnListId);
    }

    @Override
    public Long getTotalByGoodsId(Integer goodsId) {
        return customerReturnListGoodsMapper.getTotalByGoodsId(goodsId);
    }

    @Override
    public List<CustomerReturnListGoods> list(Map<String, Object> map) {
        return customerReturnListGoodsMapper.list(map);
    }

    @Override
    public Integer add(CustomerReturnListGoods customerReturnListGoods) {
        return customerReturnListGoodsMapper.add(customerReturnListGoods);
    }
}
