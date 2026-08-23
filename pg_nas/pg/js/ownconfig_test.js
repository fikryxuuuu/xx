var rule = {
    title:'own测试[自测]',
    host:'https://example.com',
    homeUrl:'/',
    url:'*',
    searchable:0,
    quickSearch:0,
    filterable:0,
    headers:{'User-Agent':PC_UA},
    timeout:5000,
    play_parse:false,
    limit:10,
    推荐:'',
    一级:'',
    二级:'',
    class_name:'测试分类A&测试分类B',
    class_url:'a&b',
    homeContent:function(){
        return '{"class":[{"type_id":"a","type_name":"测试分类A"},{"type_id":"b","type_name":"测试分类B"}],"list":[ {"vod_id":"t1","vod_name":"own自测卡片1","vod_pic":"https://img.zcool.cn/community/01a8ba5af5593fa801207ab43307d5.gif","vod_remarks":"OK"},{"vod_id":"t2","vod_name":"own自测卡片2","vod_pic":"https://img.zcool.cn/community/01a8ba5af5593fa801207ab43307d5.gif","vod_remarks":"OK"} ]}';
    },
    categoryContent:function(t,p,fl,ext){
        return '{"list":[ {"vod_id":"t1","vod_name":"own分类列表","vod_pic":"https://img.zcool.cn/community/01a8ba5af5593fa801207ab43307d5.gif"} ],"page":1,"pagecount":1,"total":1}';
    }
};
