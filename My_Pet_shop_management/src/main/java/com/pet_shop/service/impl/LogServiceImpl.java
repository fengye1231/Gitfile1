package com.pet_shop.service.impl;

import com.pet_shop.entity.Log;
import com.pet_shop.mapper.LogMapper;
import com.pet_shop.mapper.UserMapper;
import com.pet_shop.service.LogService;
import org.apache.shiro.SecurityUtils;
import org.springframework.stereotype.Service;

import javax.annotation.Resource;
import java.util.List;
import java.util.Map;

/**
 * 用户Service实现类
 *
 * @author pet_shop
 * @company
 * @create 2020-01-18 12:09
 */
@Service("logService")
public class LogServiceImpl implements LogService {

    @Resource
    private LogMapper logMapper;

    @Resource
    private UserMapper userMapper;

    @Override
    public Integer add(Log log) {
        log.setUser(userMapper.findByUserName(SecurityUtils.getSubject().getPrincipal().toString()));
        return logMapper.add(log);
    }

    @Override
    public List<Log> list(Map<String, Object> map) {
        return logMapper.list(map);
    }

    @Override
    public Long getCount(Map<String, Object> map) {
        return logMapper.getCount(map);
    }
}
