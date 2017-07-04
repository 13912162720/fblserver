<?php
namespace Api\Controller;
use Think\Controller;
class CosController extends Controller{
	public function index(){
		echo '1';
	}
	public function SearchRes(){
		header('Access-Control-Allow-Origin:*');  
		$key = I('get.key');
		$p = I('get.p')?I('get.p'):1;
		$show = 3;
		
		$model = M('Cos');
		$map['name'] = array('like','%'.$key.'%');
		$map['cd_brand.alias'] = array('like','%'.$key.'%');
		$map['cosname'] = array('like','%'.$key.'%');
		$map['_logic'] = 'or';

		$count = $model -> join('Left JOIN __BRAND__ ON __COS__.brand_id = __BRAND__.id') -> where($map) -> count();
		$pagecount = ceil($count/$show);
		$p = ($p<=$pagecount)?$p:$pagecount;

		$offset = $show*($p-1);
		
		$res = $model -> join('Left JOIN __BRAND__ ON __COS__.brand_id = __BRAND__.id') -> where($map) -> field('cd_cos.id as id,name,cosname,cd_brand.alias as balias,cd_cos.alias as calias,orglink') -> limit($offset,$show)-> select();
		foreach ($res as $key => $value) {
			$res[$key]['img'] = $this->getCosPicture($res[$key]['orglink']);
		}
		$this -> assign('pagecount',$pagecount);
		$this -> assign('pagenow',$p);
		$this -> assign('res',$res);
		$this -> display();
	}	
	public function getCosInfo(){
		header('Access-Control-Allow-Origin:*');  
		$id = I('get.cosid');
		$model = M('Cosingred');
		$map['cosid'] = $id;
		$res = $model->join('LEFT JOIN __INGRED__ ON __COSINGRED__.ingid = __INGRED__.id')->where('cosid='.$id) -> field('name,chname,outprop,safelevel,ingid') -> limit(5) -> select();
		$cos = M('Cos');
		$res1 = $cos -> join('LEFT JOIN __BRAND__ ON __COS__.brand_id = __BRAND__.id') -> where('cd_cos.id='.$id) -> field('cd_cos.id as cosid,cd_brand.name as bname,cd_brand.alias as balias,cosname,orglink') -> find();
		$res1['img'] = $this->getCosPicture($res1['orglink'],'l');
		$this -> assign('res',$res);
		$this -> assign('res1',$res1);
		$this -> display();
	}

	public function getAllIng(){
		header('Access-Control-Allow-Origin:*');
		$id = I('get.cosid');
		$model = M('Cosingred');
		$res = $model->join('LEFT JOIN __INGRED__ ON __COSINGRED__.ingid = __INGRED__.id')->where('cosid='.$id) -> field('name,chname,outprop,safelevel,ingid') -> select();
		$this -> assign('res',$res);
		$this -> display();
	}

	public function getCosPicture($url,$type='s'){
		header('Access-Control-Allow-Origin:*');
		$userAgent = "Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$r = curl_exec($ch);
		curl_close($ch);
		$r=preg_replace("/[\t\n\r]+/","",$r);  
		$rep = '/<div id="Ing_ProdImg"><img src="([^<>]+)"><\/div>/is';
		preg_match($rep, $r, $match);
		if($match){
			/**
			 * @todo 将获得的图片存入数据库中，最好是将图片下载下来
			 */
			$timg = "http://cosdna.com$match[1]";
			return $timg;
		}else{
			return "./img/default_cos_".$type.".png";
		}
	}
}