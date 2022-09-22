<%@ page language="java" contentType="text/html; charset=UTF-8"
         pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%@ page isELIgnored="false" %>
<%@ include file="top.jsp"%>

<div class="layui-container">

    <div class="layui-row" style="background: #FFFFFF;height: 20px;"></div>
    <div class="layui-row">
        <div class="layui-col-md6">
            <img src="${pageContext.request.contextPath}/images/img.png">
        </div>
        <div class="layui-col-md6">
            <div style="font-size: 40px;color: #2c55a2;margin-top: 14px;margin-left: 30px;">2022年练兵比武竞赛平台</div>
        </div>
    </div>
    <div class="layui-row" style="background: #FFFFFF;height: 20px;"></div>
    <div class="layui-row">
        <div class="layui-col-md12 md-nav">
            <ul>
                <li><a href="${pageContext.request.contextPath}/">AWD攻击靶机：4</a></li>

            </ul>
        </div>
    </div>


    <div class="layui-row">
        <div class="layui-col-md12 main" style="border-bottom-style: groove">
            <blockquote class="site-text layui-elem-quote" style="border-left: 5px solid #6a91c6;">

                SSRF利用
            </blockquote>
        </div>
    </div>

    <div class="layui-row" style="background: #FFFFFF;height: 400px;">
        <a href="${pageContext.request.contextPath}/file/download?file=fujian.txt" class="layui-btn" style="background-color: #1a56a8;">附件下载</a>
    </div>

</div>



<%@ include file="foot.jsp"%>

