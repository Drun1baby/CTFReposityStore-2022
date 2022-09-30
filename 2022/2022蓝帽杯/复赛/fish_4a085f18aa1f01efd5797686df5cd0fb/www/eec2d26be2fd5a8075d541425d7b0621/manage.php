<?php
session_start();

if($_SESSION["username"]!=="admin"){
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>管理平台</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="./layui/css/layui.css" rel="stylesheet">
</head>
<body>
  <div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo layui-hide-xs layui-bg-black"></div>
    <!-- 头部区域（可配合layui 已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      <!-- 移动端显示 -->
      <!--li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-header-event="menuLeft">
        <i class="layui-icon layui-icon-spread-left"></i>
      </li>
      
      <li class="layui-nav-item layui-hide-xs"><a href="">nav 1</a></li>
      <li class="layui-nav-item layui-hide-xs"><a href="">nav 2</a></li>
      <li class="layui-nav-item layui-hide-xs"><a href="">nav 3</a></li>
      <li class="layui-nav-item">
        <a href="javascript:;">nav groups</a>
        <dl class="layui-nav-child">
          <dd><a href="">menu 11</a></dd>
          <dd><a href="">menu 22</a></dd>
          <dd><a href="">menu 33</a></dd>
        </dl>
      </li-->
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item layui-hide layui-show-md-inline-block">
        <a href="javascript:;">
          <?php echo $_SESSION["username"];?>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="logout.php">logout</a></dd>
        </dl>
      </li>
      <!--li class="layui-nav-item" lay-header-event="menuRight" lay-unselect>
        <a href="javascript:;">
          <i class="layui-icon layui-icon-more-vertical"></i>
        </a>
      </li-->
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree" lay-filter="test">
        <li class="layui-nav-item layui-nav-itemed">
          <a class="" href="javascript:;">管理</a>
          <dl class="layui-nav-child">
            <dd><a <?php if($_GET['m']==='user')echo 'class="layui-this"';?> href="manage.php?m=user">用户管理</a></dd>
            <dd><a <?php if($_GET['m']==='data')echo 'class="layui-this"';?> href="manage.php?m=data">数据管理</a></dd>
            <dd><a <?php if($_GET['m']==='login')echo 'class="layui-this"';?> href="manage.php?m=login">登录记录</a></dd>
          </dl>
        </li>
        <!--li class="layui-nav-item">
          <a href="javascript:;">menu group 2</a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:;">list 1</a></dd>
            <dd><a href="javascript:;">list 2</a></dd>
            <dd><a href="">超链接</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item"><a href="javascript:;">click menu item</a></li>
        <li class="layui-nav-item"><a href="">the links</a></li-->
      </ul>
    </div>
  </div>
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <table class="layui-hide" id="test" lay-filter="test"></table>
 
<script type="text/html" id="toolbarDemo">
  <div class="layui-btn-container">
    <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>
    <button class="layui-btn layui-btn-sm" lay-event="getData">获取当前页数据</button>
    <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="multi-row">
      多行
    </button>
    <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="default-row">
      单行
    </button>
    <!--button class="layui-btn layui-btn-sm" id="moreTest">
      更多测试 
      <i class="layui-icon layui-icon-down layui-font-12"></i>
    </button>
    <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="default-row">
      添加
    </button>
    <button class="layui-btn layui-btn-sm layui-btn-primary" lay-event="default-row"-->
      修改
    </button>
  </div>

  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    底部固定区域
  </div>
</div>

</script>
 
<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>     
          
<!-- 注意：项目正式环境请勿引用该地址 -->
<script src="layui/layui.js"></script>

<script>
layui.use(['table', 'dropdown'], function(){
  var table = layui.table;
  var dropdown = layui.dropdown;
  /*layer.msg('本示例演示的数据为静态模拟数据，<br>实际使用时换成您的真实接口即可。', {
    closeBtn: 1,
    icon: 6,
    time: 21*1000,
    offset: '21px'
  });*/
  
  // 创建渲染实例
  table.render({
    elem: '#test'
    ,url:'data.php?m=<?php echo $_GET["m"];?>' // 此处为静态模拟数据，实际使用时需换成真实接口
    ,toolbar: '#toolbarDemo'
    ,defaultToolbar: ['filter', 'exports', 'print', {
      title: '帮助'
      ,layEvent: 'LAYTABLE_TIPS'
      ,icon: 'layui-icon-tips'
    }]
    ,height: 'full-200' // 最大高度减去其他容器已占有的高度差
    ,cellMinWidth: 80
    ,totalRow: true // 开启合计行
    ,page: true
    ,cols: [[
      {type: 'checkbox', fixed: 'left'}
      ,{field:'id', fixed: 'left', width:80, title: 'ID', sort: true, totalRowText: '合计：'}
      ,{field:'username', width:80, title: '用户', sort: true}
      ,{field:'password', title: '密码', width: 80, sort: true}
      ,{field:'ip', title:'IP', width: 120, sort: true}
      ,{field:'ua', title:'user-agent', width: 250, sort: true}
      ,{field:'time', title:'时间', width: 200, sort: true}
    ]]
    ,done: function(){
      var id = this.id;
 
      // 更多测试
      dropdown.render({
        elem: '#moreTest' //可绑定在任意元素中，此处以上述按钮为例
        ,data: [{
          id: 'add',
          title: '添加'
        },{
          id: 'update',
          title: '编辑'
        },{
          id: 'delete',
          title: '删除'
        }]
        //菜单被点击的事件
        ,click: function(obj){
          var checkStatus = table.checkStatus(id)
          var data = checkStatus.data; // 获取选中的数据
          switch(obj.id){
            case 'add':
              layer.open({
                title: '添加',
                type: 1,
                area: ['80%','80%'],
                content: '<div style="padding: 16px;">自定义表单元素</div>'
              });
            break;
            case 'update':
              if(data.length !== 1) return layer.msg('请选择一行');
              layer.open({
                title: '编辑',
                type: 1,
                area: ['80%','80%'],
                content: '<div style="padding: 16px;">自定义表单元素</div>'
              });
            break;
            case 'delete':
              if(data.length === 0){
                return layer.msg('请选择一行');
              }
              layer.msg('delete event');
            break;
          }
        }
      });
    }
    ,error: function(res, msg){
      console.log(res, msg)
    }
  });
  
  // 工具栏事件
  table.on('toolbar(test)', function(obj){
    var id = obj.config.id;
    var checkStatus = table.checkStatus(id);
    var othis = lay(this);
    switch(obj.event){
      case 'getCheckData':
        var data = checkStatus.data;
        layer.alert(layui.util.escape(JSON.stringify(data)));
      break;
      case 'getData':
        var getData = table.getData(id);
        console.log(getData);
        layer.alert(layui.util.escape(JSON.stringify(getData)));
      break;
      case 'isAll':
        layer.msg(checkStatus.isAll ? '全选': '未全选')
      break;
      case 'multi-row':
        table.reload('test', {
          // 设置行样式，此处以设置多行高度为例。若为单行，则没必要设置改参数 - 注：v2.7.0 新增
          lineStyle: 'height: 95px;' 
        });
        layer.msg('即通过设置 lineStyle 参数可开启多行');
      break;
      case 'default-row':
        table.reload('test', {
          lineStyle: null // 恢复单行
        });
        layer.msg('已设为单行');
      break;
      case 'LAYTABLE_TIPS':
        layer.alert('Table for layui-v'+ layui.v);
      break;
    };
  });
 
  //触发单元格工具事件
  table.on('tool(test)', function(obj){ // 双击 toolDouble
    var data = obj.data;
    //console.log(obj)
    if(obj.event === 'del'){
      layer.confirm('真的删除行么', function(index){
        obj.del();
        layer.close(index);
      });
    } else if(obj.event === 'edit'){
      layer.open({
        title: '编辑',
        type: 1,
        area: ['80%','80%'],
        content: '<div style="padding: 16px;">自定义表单元素</div>'
      });
    }
  });
 
  //触发表格复选框选择
  table.on('checkbox(test)', function(obj){
    console.log(obj)
  });
 
  //触发表格单选框选择
  table.on('radio(test)', function(obj){
    console.log(obj)
  });
  
  // 行单击事件
  table.on('row(test)', function(obj){
    //console.log(obj);
    //layer.closeAll('tips');
  });
  // 行双击事件
  table.on('rowDouble(test)', function(obj){
    console.log(obj);
  });
 
  // 单元格编辑事件
  table.on('edit(test)', function(obj){
    var field = obj.field //得到字段
    ,value = obj.value //得到修改后的值
    ,data = obj.data; //得到所在行所有键值
 
    var update = {};
    update[field] = value;
    obj.update(update);
  });
});
</script>

</body>
</html>