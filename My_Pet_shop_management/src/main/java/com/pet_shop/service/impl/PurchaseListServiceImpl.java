package com.pet_shop.service.impl;

import com.pet_shop.entity.PurchaseList;
import com.pet_shop.mapper.PurchaseListMapper;
import com.pet_shop.service.PurchaseListService;
import org.springframework.stereotype.Service;

import javax.annotation.Resource;
import java.util.List;
import java.util.Map;

/**
 * 进货单Service实现类
 *
 * @author pet_shop
 * @company
 * @create 2020-01-18 12:55
 */
@Service("purchaseListService")
public class PurchaseListServiceImpl implements PurchaseListService {

    @Resource
    private PurchaseListMapper purchaseListMapper;

    @Override
    public String getTodayMaxPurchaseNumber() {
        return purchaseListMapper.getTodayMaxPurchaseNumber();
    }

    @Override
    public PurchaseList findById(Integer id) {
        return purchaseListMapper.findById(id);
    }

    @Override
    public PurchaseList findByPurchaseNumber(String purchaseNumber) {
        return purchaseListMapper.findByPurchaseNumber(purchaseNumber);
    }

    @Override
    public List<PurchaseList> list(Map<String, Object> map) {
        return purchaseListMapper.list(map);
    }

    @Override
    public Integer add(PurchaseList purchaseList) {
        return purchaseListMapper.add(purchaseList);
    }

    @Override
    public Integer update(PurchaseList purchaseList) {
        return purchaseListMapper.update(purchaseList);
    }

    @Override
    public Integer delete(Integer id) {
        return purchaseListMapper.delete(id);
    }
}
