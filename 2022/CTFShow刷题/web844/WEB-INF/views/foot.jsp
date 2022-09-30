<%@ page language="java" contentType="text/html; charset=UTF-8"
         pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<%@ page isELIgnored="false" %>
<div class="layui-panel bottom-nav" >
    <span>主办单位：</span>
    <a href="http://hebei.chinatax.gov.cn/" target="_blank" style="margin-block-start: 1.33em">&nbsp;&nbsp;&nbsp;国家税务总局河北省税务局&nbsp;&nbsp;</a>
    <span>技术支持：</span>
    <a href="https://www.ctf.show" target="_blank">&nbsp;&nbsp;&nbsp;红蓝信安&nbsp;&nbsp;<a>| 永信至诚
</div>

<!-- 你的 HTML 代码 -->

<script src="${pageContext.request.contextPath}/layui/layui.js"></script>
<script>
    layui.use(['layer', 'form','element'], function(){
        var layer = layui.layer
            ,form = layui.form
            ,element = layui.element;
        const message = "${message}";
        if(message.length>0){
            layer.msg(message);
        }
    });
</script>
</body>
</html>