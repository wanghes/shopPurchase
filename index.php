<?php
require_once("models/config.php");

$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
$ua_checker = array(
    'android' => preg_match('/android/', $ua),
    'iphone' => preg_match('/iphone|ipod|ipad/', $ua)
);
$device = "iPhone";
$imgs = array();
if ($ua_checker['android']) {
    $device = "android";
} else if ($ua_checker['iphone']) {
    $device = "iPhone";
}

  $screenshots_dir = "assets/imgs/screenshots/".$device;

  if(is_dir($screenshots_dir)){
      $config = $screenshots_dir.'/config.json';

      $config_handle = $handle = fopen($config, "r");
      if(!$config_handle){
          //exit("产品缩略图的config.json无法打开");
      }
      $config_text = fread($config_handle, filesize($config));
      if(!$config_text){
          //exit("无法读取产品缩略图的config.json或config.json没有内容");
      }
      $config_text = json_decode($config_text);

      if ($screenshots_dir_handle = opendir($screenshots_dir)) {
          while (($file = readdir($screenshots_dir_handle)) !== false) {
              if ($file!="." && $file!=".." && $file !== "config.json") {
                  $filename = preg_split('/\./', $file);
                  if($filename[0]){
                      $alt = $config_text->$filename[0];
                      $src = $screenshots_dir."/$file";
                      if($alt && $src){
                          array_push($imgs, "<img src=\"$src\" alt=\"$alt\">");
                      }
                  }
              }
          }
          closedir($screenshots_dir_handle);
      }else{
          //exit($screenshots_dir." 无法打开");
      }
  }
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="baidu-tc-cerfication" content="816c8ab30314eda7a925cae8918fb130" />
    <meta name="description" content="小店记账宝是一款面向小商户的轻量级记账工具。帮助您轻松管理小店日常运营数据、货品数据。您再也不需要手抄本了，随身带部手机即可完成店铺每日的运营；您再也不需要在电脑里安装一大堆记账软件，现在只需要在您心爱的手机里打开小店记账宝即可">
    <meta name="keywords" content="记账宝,小店记账宝/账务管理/店铺账务管理/手机记账,手机进销存/iPhone记账/Android记账/小店铺记账/夜市记账/摆摊记账,货品管理/销售数据管理,记账宝网站,小店记账宝网站,记账宝官方网站,下载小店记账宝,下载记账宝,小店数据管理,小店运营管理,小店货品管理,小店记账软件">
    <meta charset="utf-8"/>
    <meta content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width" name="viewport"/>
    <meta content="telephone=no" name="format-detection"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta name="apple-itunes-app" content="app-id=805541586">
    <meta name="google-site-verification" content="_cWcSIxwgfYWssv1sEMxhHvb-YzjhTO6inWfuogdnBY" />
    <meta name="msvalidate.01" content="71BE92EDF492EA24798598C27A3134E2" />
    <link href="assets/imgs/logo.png" rel="apple-touch-icon-precomposed"/>
    <link rel="shortcut icon" href="assets/imgs/favicon.ico" type="image/x-icon" />
    <title>
        小店记账宝
    </title>
    <link rel="stylesheet" href="assets/css/reset.css"/>
    <link rel="stylesheet" href="assets/css/common.css"/>
    <link rel="stylesheet" href="assets/libs/style.css"/>
    <link rel="stylesheet" href="assets/css/index.css"/>
    <script src="assets/libs/swipe.js"></script>
    <script src="assets/libs/sea.js"></script>
    <script type="text/javascript">
        seajs.config({
            base: './assets/js/',
            map: [
                [".js", ".js?t=" + new Date().getTime()]
            ]
        });
    </script>
</head>
<body>
<header id="header">
    让小店的记账更简单
</header>
<div class="container">
    <div class="flexBox logoanddownload">
        <div class="box logoBox">
            <img src="assets/imgs/logo.png" alt="小店记账宝" width="70"/>

            <p>
                <?php echo $websiteName; ?>
            </p>

            <p class="version">
                最新版本 <?php echo $version; ?>
            </p>
        </div>
        <div class="downloadBtnBox box">
            <a href="https://itunes.apple.com/us/app/xiao-dian-ji-zhang-bao/id805541586?ls=1&mt=8#weixin.qq.com" title="下载iOS版" target="_blank" class="ios flexBox">
                <img src="assets/imgs/iphone.png" width="32" alt="下载<?php echo $websiteName; ?>iOS版"/>
                  <span class="box">
                      下载iOS版
                  </span>
            </a>
            <a href="download/xiaodianjizhangbao.apk#weixin.qq.com" title="下载安卓版" target="_blank" class="android flexBox">
                <img src="assets/imgs/android.png" width="32" alt="下载<?php echo $websiteName; ?>安卓版"/>
                  <span class="box">
                      下载安卓版
                  </span>
            </a>
            <a href="itms-services://?action=download-manifest&url=http://jizhangbao.com.cn/app.plist#weixin.qq.com" title="下载越狱版" target="_blank" class="yy flexBox">
                <img src="assets/imgs/skullcandy.png" width="32" alt="下载<?php echo $websiteName; ?>越狱版"/>
                  <span class="box">
                      下载越狱版
                  </span>
            </a>
        </div>
    </div>
    <?php if(count($imgs) > 0): ?>
    <div class="screenshots">
        <div class="triggerBox flexBox">
            <div class="triggers box" id="J-triggers">
                <?php
                  foreach($imgs as $k=>$img){
                      $current = '';
                      if($k === 0){
                          $current = 'class="current"';
                      }
                      echo "<span $current></span>";
                  }
                ?>
            </div>
            <span class="currentScreenName" id="J-currentScreenName">产品展示</span>
        </div>
        <div id='slider' class='swipe'>
            <div class='swipe-wrap'>
                <?php
                foreach($imgs as $k=>$img){
                    $current = '';
                    if($k === 0){
                        $current = 'class="current"';
                    }
                    echo "<div>".$img."</div>";
                }
                ?>
            </div>
        </div>
    </div>
    <? endif; ?>
</div>

<div class="partners">
    <div class="container">
        <div class="content">
            <header>去应用市场下载</header>
            <ul>
                <li>
                    <a href="http://www.25pp.com" target="_blank" class="flexBox">
                        <img src="assets/imgs/ppzs.png" alt="PP助手(iPhone游戏)"/>
                        <span class="box">
                            PP助手(iPhone游戏)
                        </span>
                    </a>
                </li>
                <li>
                    <a href="http://zhushou.360.cn/" target="_blank" class="flexBox">
                        <img src="assets/imgs/360zs.png" alt="360手机助手"/>
                        <span class="box">
                            360手机助手
                        </span>
                    </a>
                </li>
                <li>
                    <a href="http://android.app.qq.com/" target="_blank" class="flexBox">
                        <img src="assets/imgs/qq.png" alt="应用宝"/>
                        <span class="box">
                            应用宝
                        </span>
                    </a>
                </li>
                <li>
                    <a href="http://as.baidu.com/a/appsearch?pre=web_am_index" target="_blank" class="flexBox">
                        <img src="assets/imgs/baidu.png" alt="百度手机助手"/>
                        <span class="box">
                            百度手机助手
                        </span>
                    </a>
                </li>
                <li>
                    <a href="http://zs.91.com/" target="_blank" class="flexBox">
                        <img src="assets/imgs/91.png" alt="91手机助手"/>
                        <span class="box">
                            91手机助手
                        </span>
                    </a>
                </li>
                <li>
                    <a href="http://apk.hiapk.com/himarket/" target="_blank" class="flexBox">
                        <img src="http://cdn.r.apk.hiapk.com/web2/themes/t1/images/logo72.png" alt="安卓市场"/>
                        <span class="box">
                            安卓市场
                        </span>
                    </a>
                </li>
                <li>
                    <a href="http://www.appchina.com/" target="_blank" class="flexBox">
                        <img src="http://static.yingyonghui.com/icon/72/9999.png" alt="应用汇"/>
                        <span class="box">
                            应用汇
                        </span>
                    </a>
                </li>
                <li>
                    <a href="http://www.wandoujia.com/apps" target="_blank" class="flexBox">
                        <img src="assets/imgs/wdj.png" alt="碗豆荚"/>
                        <span class="box">
                            碗豆荚
                        </span>
                    </a>
                </li>
                <li>
                    <a href="http://apk.gfan.com/apps_7_1_1.html" target="_blank" class="flexBox">
                        <img src="assets/imgs/jf.png" alt="机锋市场"/>
                        <span class="box">
                            机锋市场
                        </span>
                    </a>
                </li>
                <li>
                    <a href="http://m.163.com/android/" target="_blank" class="flexBox">
                        <img src="assets/imgs/wy.png" alt="网易应用市场"/>
                        <span class="box">
                            网易应用市场
                        </span>
                    </a>
                </li>
                <li>
                    <a href="http://mm.10086.cn/" target="_blank" class="flexBox">
                        <img src="http://u5.mm-img.com/rs/res1/21/2013/12/14/a278/699/32699278/logo1140x1407031345623_src.jpg" alt="中国移动MM应用市场"/>
                        <span class="box">
                            中国移动MM应用市场
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<footer id="footer">
    <p>
        记账宝版权所有 © 2014 - 2015
    </p>
    <p>
        浙ICP备08107985号-4
    </p>
</footer>
</body>
<script>
    seajs.use("index.js");
</script>
</html>