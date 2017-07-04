<?php
namespace Api\Controller;
use Think\Controller;
class ReportController extends Controller{
	public function reportlist(){
		header('Access-Control-Allow-Origin:*');  
		$model = M('Report');
		$res = $model -> field('id,title,intro,banner,create_time') -> order('create_time desc')->limit(6)->select();
		$this-> assign('reportres',$res);
		$this-> display();
	}
	public function reporttext(){
		header('Access-Control-Allow-Origin:*');  
		$rid = I('get.rid');
		$model = M('Report');
		$res = $model -> where('id='.$rid) -> field('id,title,key_word,text,banner') -> find();
		$map['id'] = array('neq',$rid);
		$res1 = $model -> where($map) -> field('id,title') -> limit(10) -> select();
		$this -> assign('report',$res);
		$this -> assign('other',$res1);
		$this -> display();
	}
}