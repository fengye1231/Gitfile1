package com.pet_shop.controller;

import com.pet_shop.entity.Standard;
import com.pet_shop.service.StandardService;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.transaction.interceptor.TransactionAspectSupport;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.servlet.ModelAndView;

/**
 * 健康标准
 */
@Controller("UserStandardController")
@RequestMapping("/user/standard")
public class UserStandardController {
    @Autowired
    private StandardService standardService;

    private final Logger logger = LoggerFactory.getLogger(this.getClass());
    /**
     * 医生列表页面user/standardListDoctor.html
     */





    @RequestMapping("/standardListDoctor")
    public ModelAndView standardListDoctor() {
        ModelAndView mav = new ModelAndView();
        mav.addObject("title", "健康标准界面");
        mav.addObject("mainPage", "page/user/standardListDoctor");
        mav.addObject("mainPageKey", "#b");
        mav.setViewName("index");
        return mav;

    }
    /**
     * 普通用户页面user/standardList.html
     */
    @RequestMapping("/standardList")
    public ModelAndView standardList() {
        ModelAndView mav = new ModelAndView();
        mav.addObject("title", "健康标准界面");
        mav.addObject("mainPage", "page/user/standardList");
        mav.addObject("mainPageKey", "#b");
        mav.setViewName("index");
        return mav;

    }
    /**
     * 普通用户返回查询数据
     */
    @RequestMapping("/getAllByLimit")
    @ResponseBody
    public Object getAllByLimit(Standard pojo) {
        return standardService.getAllByLimit(pojo);
    }
    /**
     * 医生返回查询数据
     */
    @RequestMapping("/getAllByLimitDoctor")
    @ResponseBody
    public Object getAllByLimitBaoJie(Standard pojo) {
        return standardService.getAllByLimit(pojo);
    }

    /**
     * 根据id删除
     */
    @RequestMapping(value = "/del")
    @ResponseBody
    @Transactional
    public String del(Long id) {
        try {
            standardService.deleteById(id);
            return "SUCCESS";
        } catch (Exception e) {
            logger.error("删除异常", e);
            TransactionAspectSupport.currentTransactionStatus().setRollbackOnly();
            return "ERROR";
        }
    }

    /**
     * 添加页面 user/standardAdd.html
     */
    @RequestMapping(value = "/add")
    public String add() {
        return "user/standardAdd";
    }

    /**
     * 插入数据库
     */
    @RequestMapping(value = "/doAdd")
    @ResponseBody
    @Transactional
    public String doAdd(Standard pojo) {
        try {
            standardService.add(pojo);
            return "SUCCESS";
        } catch (Exception e) {
            logger.error("添加异常", e);
            TransactionAspectSupport.currentTransactionStatus().setRollbackOnly();
            return "ERROR";
        }
    }
}
