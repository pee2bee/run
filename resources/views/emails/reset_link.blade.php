<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>找回密码</title>
  </head>
  <body>
    <h1>你正在尝试</h1>

    <p>
      请点击一下链接进入下一步操作：
      <a href="{{route('password.reset',$token)}}">{{route('password.reset',$token)}}</a>
    </p>
    <p>如果这不是你本人的操作，请忽略此邮件</p>
  </body>
</html>




















