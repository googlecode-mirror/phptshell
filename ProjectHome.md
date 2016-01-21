php 的命令shell
> php的命令行运行， 首先要把php安装目录加入环境变量，这样就能直接在命令行使用php作为命令，如果你不想将php的安装目录加入环境变量，你可以使用php 的完整路径运行，如 c:\php\php.exe 的方式。
> php pshell.php shellname    或者
> c:\php\php.exe pshell.php shellname

可以直接输入php语句运行， 或者表达式， 如
> shellname#phpinfo();
> shellname#time();
> shellname#1+10;
> shellname#$a = 1+10;
> shellname#$a;