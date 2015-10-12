1、克隆这个项目到本地(前提是你得有装git)

git clone git://github.com/robbyrussell/oh-my-zsh.git ~/.oh-my-zsh
2、创建一个zsh的配置文件
注意:如果你已经有一个~/.zshrc文件的话，建议你先做备份。使用以下命令

cp ~/.zshrc ~/.zshrc.orig
然后开始创建zsh的配置文件
cp ~/.oh-my-zsh/templates/zshrc.zsh-template ~/.zshrc
3、设置zsh为你的默认的shell
chsh -s /bin/zsh
4、重启并开始使用你的zsh (打开一个新的终端窗口便可…)
至此，大功告成。

更改zsh主题:

1、编辑 ~/.zshrc

2、修改

ZSH_THEME="ys"
注：主题文件在 ~/.oh-my-zsh/themes 目录
这里有一份详细的zsh主题介绍，可以根据喜好自行修改。
