<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V5.1<br/><span style="font-size:30px">12载初心不改（2006-2018） - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
    }

    /**
     * 获取账户剩余点数
     * https://open.dianshenqi.com/help/api_doc/20c4b6975f7b4e1c92371dd5a935bc4a#article-h5102
     */
    public function points(){
        $dsq=new \dsq\Sdk();
        $res=$dsq->request('GetTrafficSum');
        halt($res);
    }
    /**
     * 创建查询信息接口-查询店铺信息、商品信息、淘口令信息、直播间信息等需要先创建查询信息，然后通过返回的gid调用信息查询接口
     * https://open.dianshenqi.com/help/api_doc/d2169062676641fe99caa9b40f54bef1#article-h593
     * @param array $params: 参数数组
     */ 
    public function set_business(){
        $params=[
            'share_password'=>'https://detail.tmall.com/item.htm?id=565324528679',// 链接或者淘口令
            'type'=>1 //任务类型 https://open.dianshenqi.com/help/api_doc/d2169062676641fe99caa9b40f54bef1#article-h589
        ];
        $dsq=new \dsq\Sdk();
        $res=$dsq->request('SetBusinessData',$params,'v2');
        halt($res);
    }
    /**
     * 获取查询信息-查询店铺信息、商品信息、淘口令信息、直播间信息等需要先创建查询信息，然后通过返回的gid调用信息查询接口
     * https://open.dianshenqi.com/help/api_doc/d2169062676641fe99caa9b40f54bef1#article-h594
     * 注：如果获取失败，前端可以用定时任务十秒钟请求一次，直到成功
     * @param array $params: 参数数组
     */
    public function get_business(){
        $params['gid']='386e3cb7f8344bea96f473c4612f7f2b';//创建查新订单接口返回的gid
        $dsq=new \dsq\Sdk();
        $res=$dsq->request('GetBusinessData',$params,'v2');
        halt($res);
    }
    /**
     * 发布APP流量任务
     * https://open.dianshenqi.com/help/api_doc/d2169062676641fe99caa9b40f54bef1#article-h5105
     * @param array $params 请求参数数组
     */
    public function release_app(){
        $params=[
            'number'=>'APP456462345465',// 任务编号-请自行生成并且保证唯一性
            'user_name'=>'e10adc3949ba59abbe56e057f20f883e',//用户名，主要作用为分配买号时候去重，也可用作任务记录。如开发者担心自身产品用户名暴露，可做处理后传入，但是最好保证处理后仍能保证唯一性。
            'url'=>'565324528679',//宝贝ID（淘口令来路任务url必须是淘口令）,可通过查询信息接口获取
            'start_time'=>'2020-01-01',//任务开始时间，以天为单位
            'end_time'=>'2020-01-01',//任务结束时间，以天为单位
            'type'=>1,//任务类型
            'referers'=>[//来路类型
                [
                    'referer'=>'1',//来路类型 1 - 手淘搜索 2 - 猜你喜欢（手淘首页） 3 - 直通车 4 - 淘口令 5 - 手淘淘金币
                    'keyword'=>'电风扇',//搜索关键词
                    'sub_tasks'=>[//数量分配
                        [
                            'day'=>'2020-01-01',//执行时间
                            'hours'=>[0,0,0,0,0,0,0,0,0,0,0,0,0,0,15,15,14,12,12,9,8,6,5,4]//0点到23点的每小时的流量数
                        ],
                        [
                            'day'=>'2020-01-02',//执行时间
                            'hours'=>[0,0,0,0,0,0,0,0,0,0,0,0,0,0,15,15,14,12,12,9,8,6,5,4]//0点到23点的每小时的流量数
                        ]
                    ]
                ]
            ],//来路类型
            'shop_name'=>'2383574075',//主要作用为分配买号时候去重，也可用作任务记录。每个任务类型传值详见平台文档任务类型表,可通过查询信息接口获取
            'goods_browsing_time'=>50,//主商品浏览停留时间，单位秒
            'visit_mode'=>0,//商品浏览模式 详见平台商品浏览模式表
            'shop_browsing_time'=>30,//店铺其他商品浏览停留时间，仅当商品浏览模式设定了浏览多个商品时有效
            'is_compare'=>true//是否在搜索后货比三家
        ];
        $dsq=new \dsq\Sdk();
        $res=$dsq->request('ReleaseTraffic',$params,'v2');
        halt($res);
    }
    /**
     * 获取任务列表
     * https://open.dianshenqi.com/help/api_doc/20c4b6975f7b4e1c92371dd5a935bc4a#article-h55
     * @param array $params: 参数数组
     */
    public function task_list(){
        $params=[
            'current_page'=>1,//当前页码
            'page_size'=>20,//每页条数
            'user_name'=>'e10adc3949ba59abbe56e057f20f883e',//通过用户名进行查询
            'shop_name'=>'',//通过发布任务的shop_name进行查询
            'number'=>''//通过
        ];
        $dsq=new \dsq\Sdk();
        $res=$dsq->request('GetTrafficPage',$params);
        halt($res);
    }
    /**
     * 关闭任务
     * https://open.dianshenqi.com/help/api_doc/20c4b6975f7b4e1c92371dd5a935bc4a#article-h57
     * @param array $params: 参数数组
     */
    public function task_close(){
        $params=[
            'number'=>'SQ456462345465'//任务编号
        ];
        $dsq=new \dsq\Sdk();
        $res=$dsq->request('TrafficClose',$params);
        halt($res);
    }
    /**
     * 获取任务详情
     * https://open.dianshenqi.com/help/api_doc/20c4b6975f7b4e1c92371dd5a935bc4a#article-h58
     * @param array $params: 参数数组
     */
    public function task_detail(){
        $params=[
            'number'=>'SQ456462345465'//任务编号
        ];
        $dsq=new \dsq\Sdk();
        $res=$dsq->request('GetTaskTrafficRow',$params);
        halt($res);
    }
    /**
     * 按时间段查询消耗的流量点数(最近3个月内的数据)
     * https://open.dianshenqi.com/help/api_doc/20c4b6975f7b4e1c92371dd5a935bc4a#article-h541
     * @param array $params: 参数数组
     */
    public function consume_sum(){
        $params=[
            'start_time'=>'2019-10-01',//开始时间
            'end_time'=>'2019-12-31'//结束时间
        ];
        $dsq=new \dsq\Sdk();
        $res=$dsq->request('GetTrafficConsumeSum',$params);
        halt($res);
    }
    
    
    //↓↓↓↓↓↓↓↓↓↓↓↓↓以下是其他相关的例子↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    //↓↓↓↓↓↓↓↓↓↓↓↓↓以下是其他相关的例子↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    //↓↓↓↓↓↓↓↓↓↓↓↓↓以下是其他相关的例子↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    //↓↓↓↓↓↓↓↓↓↓↓↓↓以下是其他相关的例子↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    //↓↓↓↓↓↓↓↓↓↓↓↓↓以下是其他相关的例子↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    
    
    /**
     * 发布来路类型为淘口令的APP流量任务
     * https://open.dianshenqi.com/help/api_doc/d2169062676641fe99caa9b40f54bef1#article-h5105
     * @param array $params 请求参数数组
     * 1、创建淘口令信息查询
     * 2、通过第一步返回的gid提交查询信息接口获取淘口令user_id
     * 3、发布任务
     */
    public function release_app_tkl(){
        $params=[
            'number'=>'APP4564623454655',// 任务编号-请自行生成并且保证唯一性
            'user_name'=>'e10adc3949ba59abbe56e057f20f883e',//用户名，主要作用为分配买号时候去重，也可用作任务记录。如开发者担心自身产品用户名暴露，可做处理后传入，但是最好保证处理后仍能保证唯一性。
            'url'=>'【巴拉巴拉男童羽绒服女童外套宝宝冬装加绒儿童冬装洋气暖棒球外套】，復ず■淛这句话₤9qRHYtSW844₤后咑閞綯℡寳',//宝贝ID（淘口令来路任务url必须是淘口令）,可通过查询信息接口获取
            'start_time'=>'2020-01-01',//任务开始时间，以天为单位
            'end_time'=>'2020-01-01',//任务结束时间，以天为单位
            'type'=>1,//任务类型
            'referers'=>[//来路类型
                [
                    'referer'=>'4',//来路类型 1 - 手淘搜索 2 - 猜你喜欢（手淘首页） 3 - 直通车 4 - 淘口令 5 - 手淘淘金币
                    'keyword'=>'',//淘口令来路关键词为空
                    'sub_tasks'=>[//数量分配
                        [
                            'day'=>'2020-01-01',//执行时间
                            'hours'=>[0,0,0,0,0,0,0,0,0,0,0,0,0,0,15,15,14,12,12,9,8,6,5,4]//0点到23点的每小时的流量数
                        ],
                        [
                            'day'=>'2020-01-02',//执行时间
                            'hours'=>[0,0,0,0,0,0,0,0,0,0,0,0,0,0,15,15,14,12,12,9,8,6,5,4]//0点到23点的每小时的流量数
                        ]
                    ]
                ]
            ],
            'shop_name'=>'642320867',//淘口令user_id通过查询信息接口获取
            'goods_browsing_time'=>50,//主商品浏览停留时间，单位秒
            'visit_mode'=>0,//商品浏览模式 详见平台商品浏览模式表
            'shop_browsing_time'=>30,//店铺其他商品浏览停留时间，仅当商品浏览模式设定了浏览多个商品时有效
            'is_compare'=>false//货比三家，淘口令来路不能为true
        ];
        $dsq=new \dsq\Sdk();
        $res=$dsq->request('ReleaseTraffic',$params,'v2');
        halt($res);
    }
    
    /**
     * 发布多个关键词多天的任务
     */
    public function release_app_keys(){
        $params=[
            'number'=>'APP456462345465',// 任务编号-请自行生成并且保证唯一性
            'user_name'=>'e10adc3949ba59abbe56e057f20f883e',//用户名，主要作用为分配买号时候去重，也可用作任务记录。如开发者担心自身产品用户名暴露，可做处理后传入，但是最好保证处理后仍能保证唯一性。
            'url'=>'565324528679',//宝贝ID（淘口令来路任务url必须是淘口令）,可通过查询信息接口获取
            'start_time'=>'2020-01-01',//任务开始时间，以天为单位
            'end_time'=>'2020-01-01',//任务结束时间，以天为单位
            'type'=>1,//任务类型
            'referers'=>[//来路类型
                [
                    'referer'=>'1',//来路类型 1 - 手淘搜索 2 - 猜你喜欢（手淘首页） 3 - 直通车 4 - 淘口令 5 - 手淘淘金币
                    'keyword'=>'电风扇',//搜索关键词
                    'sub_tasks'=>[//数量分配
                        [
                            'day'=>'2020-01-01',//执行时间
                            'hours'=>[0,0,0,0,0,0,0,0,0,0,0,0,0,0,15,15,14,12,12,9,8,6,5,4]//0点到23点的每小时的流量数
                        ],
                        [
                            'day'=>'2020-01-02',//执行时间
                            'hours'=>[0,0,0,0,0,0,0,0,0,0,0,0,0,0,15,15,14,12,12,9,8,6,5,4]//0点到23点的每小时的流量数
                        ]
                    ]
                ],
                [
                    'referer'=>'1',//来路类型 1 - 手淘搜索 2 - 猜你喜欢（手淘首页） 3 - 直通车 4 - 淘口令 5 - 手淘淘金币
                    'keyword'=>'落地扇',//搜索关键词
                    'sub_tasks'=>[//数量分配
                        [
                            'day'=>'2020-01-01',//执行时间
                            'hours'=>[0,0,0,0,0,0,0,0,0,0,0,0,0,0,15,15,14,12,12,9,8,6,5,4]//0点到23点的每小时的流量数
                        ],
                        [
                            'day'=>'2020-01-02',//执行时间
                            'hours'=>[0,0,0,0,0,0,0,0,0,0,0,0,0,0,15,15,14,12,12,9,8,6,5,4]//0点到23点的每小时的流量数
                        ]
                    ]
                ]
            ],//来路类型
            'shop_name'=>'2383574075',//主要作用为分配买号时候去重，也可用作任务记录。每个任务类型传值详见平台文档任务类型表,可通过查询信息接口获取
            'goods_browsing_time'=>50,//主商品浏览停留时间，单位秒
            'visit_mode'=>0,//商品浏览模式 详见平台商品浏览模式表
            'shop_browsing_time'=>30,//店铺其他商品浏览停留时间，仅当商品浏览模式设定了浏览多个商品时有效
            'is_compare'=>true//是否在搜索后货比三家
        ];
        $dsq=new \dsq\Sdk();
        $res=$dsq->request('ReleaseTraffic',$params,'v2');
        halt($res);
    }
}
