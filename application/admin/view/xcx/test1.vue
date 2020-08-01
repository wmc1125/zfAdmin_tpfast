<template id="temp" >
    <button>单组件引入</button>
</template>
<div id="app">
</div>
<script>
  Vue.component( 'temp',{
            template:'#comp',
            //方法
            methods:{},
            //数据data
            data() {
              return {
                }
            }
            }
        })

</script>