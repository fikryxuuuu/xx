var rule = {
    title:'🛠 我的配置中心',
    host:'https://raw.githubusercontent.com',
    homeUrl:'/',
    url:'*',
    searchable:0,quickSearch:0,filterable:0,
    headers:{'User-Agent':PC_UA},timeout:5000,play_parse:false,limit:10,
    推荐:'',一级:'',二级:'',
    class_name:'配置&玩偶&网盘',
    class_url:'cfg&muou&pan',
    homeContent:function(){
        return JSON.stringify({"class":[
            {"type_id":"cfg","type_name":"配置中心"},
            {"type_id":"muou","type_name":"玩偶"},
            {"type_id":"pan","type_name":"网盘"}
        ],"list":[
            {"vod_id":"c1","vod_name":"⚙️ 配置中心-基础设置","vod_pic":"https://img.zcool.cn/community/01a8ba5af5593fa801207ab43307d5.gif","vod_remarks":"OWN"},
            {"vod_id":"m1","vod_name":"🧸 玩偶-木偶剧场","vod_pic":"https://img.zcool.cn/community/01a8ba5af5593fa801207ab43307d5.gif","vod_remarks":"OWN"},
            {"vod_id":"p1","vod_name":"☁️ 网盘-云分享","vod_pic":"https://img.zcool.cn/community/01a8ba5af5593fa801207ab43307d5.gif","vod_remarks":"OWN"}
        ]});
    },
    categoryContent:function(t,p,fl,ext){
        return JSON.stringify({"list":[{"vod_id":"x1","vod_name":"own分类-"+t,"vod_pic":"https://img.zcool.cn/community/01a8ba5af5593fa801207ab43307d5.gif"}],"page":1,"pagecount":1,"total":1});
    }
};
