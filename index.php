<?php
/* php知识点require_once : 引入一次配置文件(如果有多条相同引入语句,只执行一次) */
require_once 'config.php';
session_start();//开启会话
if (!($_SESSION['loggedUsername'])){//如果没有登录
    header("location:login.php");//使用php跳转到登录界面
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link type="text/css" rel="styleSheet"  href="style.css" />
</head>

<body class="w">
    <!-- 标题 -->
    <div class="nav">
        <h1> </h1>
        <h1 class="navtitle"><?php echo $title; ?></h1>
        <a class="navloginout" href="loginout.php">退出登录</a>
        <span class="navusername">昵称：<?php echo $_SESSION['loggedUsername'];?></span>
    </div>
    <!-- 留言输入区域 -->

    <!-- 小标题 -->
    <?php  
        $sql = "SELECT COUNT(*) AS allsaytext FROM `liuyan`";
        $result = $conn->query($sql);
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
    ?>
    <h2>留言（共有 <?php echo $row["allsaytext"];?> 条留言）</h2>
    <?php
            }
        }
    ?>

    <!-- 写留言表单 -->
    <form class="w2" action="add.php" method="POST">
        <!-- <p hidden>昵称：<input name="n" type="text" value="<?php //echo $_SESSION['loggedUsername'];?>" placeholder="热心网友"></p> -->
        <textarea class="w2" name="t" rows="6" placeholder="请遵守互联网相关规定，不要发布广告和违法内容!"></textarea>
        <input style="float:right" type="submit" value="提交留言">
    </form>

    <!-- 留言展示区域 -->
    <h2>留言列表</h2>
    <table class="w2">
        <?php
        // 最新留言展示前面
        $sql = "SELECT * FROM `liuyan` ORDER BY `liuyan`.`id` DESC";
        // ORDER BY `liuyan`.`id` DESC 加上这个是降序排列
        $result = $conn->query($sql);

        if($result->num_rows>0){
            //输出数据
            while($row = $result->fetch_assoc()){
                // $result->fetch_assoc()执行一次显示第一条，执行第二次显示第二条
            ?>
            <tr><td>留言人：<?php echo $row["username"];?></td><td style="float:right"><?php echo $row["time"];?> 发表</td></tr>
            <tr><td colspan="2"><?php echo $row["text"];?></td></tr>
            <tr><td></td><td style="float:right">
                第<?php echo $row["id"];?>楼 
                <?php if($row["username"] == $_SESSION['loggedUsername']){ ?>
                    <a href="edit.php?id=<?php echo $row['id'];?>">编辑</a> 
                    <a href="del.php?id=<?php echo $row['id'];?>">删除</a></tr>
                <?php } ?>
            <tr><td colspan="2"><hr></td></tr>
            <?php
            }
        } else {
            echo"暂无留言";
        }
        ?>        
    </table>

</body>

</html>