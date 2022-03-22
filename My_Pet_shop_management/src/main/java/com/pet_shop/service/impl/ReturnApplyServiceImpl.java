package com.pet_shop.service.impl;

import com.pet_shop.entity.ReturnApply;
import com.pet_shop.mapper.ReturnApplyMapper;
import com.pet_shop.service.ReturnApplyService;
import org.springframework.stereotype.Service;

import javax.annotation.Resource;
import java.util.List;
import java.util.Map;

/**
 * 客户退货申请Service实现类
 *
 * @author pet_shop
 * @company
 * @create 2020-06-05 22:05
 */
@Service("returnApplyService")
public class ReturnApplyServiceImpl implements ReturnApplyService {

    @Resource
    private ReturnApplyMapper returnApplyMapper;

    @Override
    public List<ReturnApply> list(Map<String, Object> map) {
        return returnApplyMapper.list(map);
    }

    @Override
    public Long getCount(Map<String, Object> map) {
        return returnApplyMapper.getCount(map);
    }

    @Override
    public Integer add(ReturnApply returnApply) {
        return returnApplyMapper.add(returnApply);
    }

    @Override
    public Integer update(ReturnApply returnApply) {
        return returnApplyMapper.update(returnApply);
    }

    @Override
    public Integer delete(Integer id) {
        return returnApplyMapper.delete(id);
    }

    @Override
    public ReturnApply findById(Integer id) {
        return returnApplyMapper.findById(id);
    }
}
