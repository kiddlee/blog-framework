在使用git status查看修改文件时，有时会发现大量的文件被修改，这有可能是操作系统不一样等问题造成的。比如我现在工作的单位，有人用windows, 有人用mac。使用git diff查看，发现文件只有file mode被修改。

针对这个问题，我们可以编辑.git/config中filemode为false
