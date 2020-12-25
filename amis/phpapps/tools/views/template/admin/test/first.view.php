<html lang="zh">
<head>
    <meta charset="UTF-8" />
    <title>amis demo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1"
    />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <link rel="stylesheet" href="../../../node_modules/amis/sdk/sdk.css" />
    <style>
        html,
        body,
        .app-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
<div id="root" class="app-wrapper"></div>
<script src="../../../node_modules/amis/sdk/sdk.js"></script>
<script type="text/javascript">
    (function () {
        let amis = amisRequire('amis/embed');
        // 通过替换下面这个配置来生成不同页面
        let amisScoped = amis.embed('#root', {
            type: 'page',
            title: '表单页面',
            body: {
                type: 'form',
                mode: 'horizontal',
                api: '/saveForm',
                controls: [
                    {
                        label: 'Name',
                        type: 'text',
                        name: 'name'
                    },
                    {
                        label: 'Email',
                        type: 'email',
                        name: 'email'
                    }
                ]
            }
        });
    })();
</script>
</body>
</html>