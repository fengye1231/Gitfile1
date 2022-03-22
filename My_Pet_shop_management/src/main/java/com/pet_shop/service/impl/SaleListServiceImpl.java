package com.pet_shop.service.impl;

import com.pet_shop.entity.Goods;
import com.pet_shop.entity.SaleCount;
import com.pet_shop.entity.SaleList;
import com.pet_shop.entity.SaleListGoods;
import com.pet_shop.mapper.GoodsMapper;
import com.pet_shop.mapper.SaleListGoodsMapper;
import com.pet_shop.mapper.SaleListMapper;
import com.pet_shop.service.SaleListService;
import org.springframework.stereotype.Service;

import javax.annotation.Resource;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * 销售单Service实现类
 *
 * @author pet_shop
 * @company
 * @create 2020-01-18 16:09
 */
@Service("saleListService")
public class SaleListServiceImpl implements SaleListService {

    @Resource
    private SaleListMapper saleListMapper;

    @Resource
    private GoodsMapper goodsMapper;

    @Resource
    private SaleListGoodsMapper saleListGoodsMapper;

    @Override
    public String getTodayMaxSaleNumber() {
        return saleListMapper.getTodayMaxSaleNumber();
    }

    @Override
    public List<SaleCount> countSaleByDay(String begin, String end) {
        return saleListMapper.countSaleByDay(begin, end);
    }

    @Override
    public List<SaleCount> countSaleByMonth(String begin, String end) {
        return saleListMapper.countSaleByMonth(begin, end);
    }

    @Override
    public SaleList findById(Integer id) {
        return saleListMapper.findById(id);
    }

    @Override
    public SaleList findBySaleNumber(String saleNumber) {
        return saleListMapper.findBySaleNumber(saleNumber);
    }

    @Override
    public Integer add(SaleList saleList) {
        return saleListMapper.add(saleList);
    }

    @Override
    public Integer update(SaleList saleList) {
        return saleListMapper.update(saleList);
    }

    @Override
    public List<SaleList> list(Map<String, Object> map) {
        return saleListMapper.list(map);
    }

    @Override
    public Long getCount(Map<String, Object> map) {
        return saleListMapper.getCount(map);
    }

    @Override
    public Integer delete(Integer id) {
        return saleListMapper.delete(id);
    }

    @Override
    public SaleList findCurrentOneOrderByCustomerId(Integer customerId) {
        return saleListMapper.findCurrentOneOrderByCustomerId(customerId);
    }

    @Override
    public void cancelOrderOverOneDay() {
        List<SaleList> saleListList = saleListMapper.findOrderOverOneDay();
        for (SaleList saleList : saleListList) {
            Map<String,Object> map=new HashMap<>(16);
            map.put("saleListId", saleList.getId());
            List<SaleListGoods> saleListGoodsList = saleListGoodsMapper.list(map);
            for (SaleListGoods saleListGoods : saleListGoodsList) {
                Goods goods = goodsMapper.findById(saleListGoods.getGoodsId());
                goods.setInventoryQuantity(goods.getInventoryQuantity()+saleListGoods.getNum());
                goodsMapper.update(goods);
            }
            saleList.setState(6);
            saleListMapper.update(saleList);
        }
    }

    @Override
    public void automaticReceiptConfirmation() {
        List<SaleList> saleListList = saleListMapper.findOrderOverTwoWeeksNotReceipt();
        for (SaleList saleList : saleListList) {
            saleList.setState(5);
            saleListMapper.update(saleList);
        }
    }
}
